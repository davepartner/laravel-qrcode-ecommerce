<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paystack;
use Flash;
use App\Models\Transaction;
use App\Models\Qrcode as QrcodeModel;
use App\Models\User;
use App\Models\Account;
use App\Models\AccountHistory;
use Auth;

class PaymentController extends Controller
{

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

       
        if($paymentDetails['data']['status'] != 'success'){
            Flash::error('Sorry, payment failed');
            //redirect here 
            return redirect()->route('qrcodes.show',['id'=> $paymentDetails['data']['metadata']['qrcode_id'] ]);
           
        }

        //check if the amount paid is same as amount they are supposed to pay
        $qrcode = QrcodeModel::find($paymentDetails['data']['metadata']['qrcode_id']);

        if( $qrcode->amount != ($paymentDetails['data']['amount']/100) ){
            Flash::success('Sorry, you paid the wrong amount. Please contact admin.');
            return redirect()->route('qrcodes.show',['id'=> $paymentDetails['data']['metadata']['qrcode_id'] ]);
           
        }

        //update transaction
        $transaction =  Transaction::where('id',$paymentDetails['data']['metadata']['transaction_id'] )->first();
       
        Transaction::where('id',$paymentDetails['data']['metadata']['transaction_id'] )
        ->update(['status'=> 'completed']);
 
        //get buyer details
        $buyer = User::find($paymentDetails['data']['metadata']['buyer_user_id']);
        
        //update qrcode owner account and account history
        $qrCodeOwnerAccount = Account::where('user_id',$qrcode->user_id)->first();

        Account::where('user_id',$qrcode->user_id)->update([
            'balance' => ($qrCodeOwnerAccount->balance + $qrcode->amount),
            'total_credit' => ($qrCodeOwnerAccount->total_credit + $qrcode->amount)
        ]);

        AccountHistory::create([
            'user_id' => $qrcode->user_id,
            'account_id' =>  $qrCodeOwnerAccount->id,
            'message' => 'Received '.$transaction->payment_method.' payment from '.$buyer->email . 'for qrcode: '. $qrcode->product_name
        ]);

        //update buyer account and account history
        $buyerAccount = Account::where('user_id',$paymentDetails['data']['metadata']['buyer_user_id'])->first();

        Account::where('user_id',$paymentDetails['data']['metadata']['buyer_user_id'])->update([
            'total_debit' => ($qrCodeOwnerAccount->total_credit + $qrcode->amount)
        ]);

        AccountHistory::create([
            'user_id' => $paymentDetails['data']['metadata']['buyer_user_id'],
            'account_id' =>  $buyerAccount->id,
            'message' => 'Paid '.$transaction->payment_method.' payment to '.$qrcode->user['email'] . 'for qrcode: '. $qrcode->product_name
        ]);

        Flash::success('Payment successful');
        return redirect(route('transactions.show',['id'=> $transaction->id]));

        //send email alert to both parties 
        //QRCode owner email : $qrcode->user['email']
        //Buyer email: $paymentDetails['data']['metadata']['buyer_user_email']
        
        //send sms

        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
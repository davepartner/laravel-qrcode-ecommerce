<table class="table table-responsive" id="transactions-table">
    <thead>
        <tr>
        <th>Qrcode</th>
        <th>Buyer</th>
        <th>Method</th>
        <th>Amount</th>
        <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            
            <td>
             <a href="{!! route('transactions.show', [$transaction->id]) !!}">
                {!! $transaction->qrcode['product_name'] !!}
             </a> 
             <small>|  {{ $transaction->created_at->format('D d, M, Y h:i')}} </small>
            </td>
            <td>{!! $transaction->user['name'] !!}</td>
            <td>{!! $transaction->payment_method !!}</td>
            <td>${!! $transaction->amount !!}</td>
            <td>{!! $transaction->status !!}  <br/>
                 <small>  {{ $transaction->updated_at->format('D d, M, Y h:i')}} </small>
            </td>
            
        </tr>
    @endforeach
    </tbody>
</table>
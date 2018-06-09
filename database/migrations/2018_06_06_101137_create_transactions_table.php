<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id'); //user making transaction
            $table->integer('qrcode_owner_id')->nullable();
            $table->integer('qrcode_id');
            $table->string('payment_method')->nullable(); //paypal, stripe, paystack etc
            $table->longText('message')->nullable();
            $table->float('amount', 10, 4);
            $table->string('status')->default('initiated'); //initiated, completed and payment failed, completed and successful
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}

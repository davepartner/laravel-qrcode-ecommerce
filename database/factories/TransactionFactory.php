<?php

use Faker\Generator as Faker;


$factory->define(App\Models\Transaction::class, function (Faker $faker) {
  
  $status = array('completed', 'initiated', 'failed');

    return [
        'user_id' =>  function(){
            return App\Models\User::all()->random();
        },
        'qrcode_owner_id' =>  function(){
            return App\Models\User::all()->random();
        },
        'qrcode_id' =>  function(){
            return App\Models\Qrcode::all()->random();
        },
        'payment_method' => 'paystack/'.$faker->creditCardType,
        'amount' => $faker->numberBetween(200,4000),
        'status' => $status[rand(0,2)]
        
    ];
});


          
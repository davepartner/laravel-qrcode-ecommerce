@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            Account: {{$account->id}} 

            <small> 
                    @if($account->applied_for_payout == 1)
                    Payout request pending
        
                    @endif

            </small>
        </h1>

        <h1 class="pull-right"> 


@if(Auth::user()->id == $account->user_id && $account->applied_for_payout != 1)
            {!! Form::open(['route' => ['accounts.apply_for_payout'], 'method' => 'post', 'class'=>'pull-left']) !!}
     
            <input type="hidden" value="{{ $account->id}}" name="apply_for_payout" />
                 {!! Form::button('<i class="glyphicon glyphicon-ok"></i> Apply for payout', ['type' => 'submit', 'class' => 'btn btn-primary', 'onclick' => "return confirm('Are you sure you wish to apply for payout?')"]) !!}
      
            {!! Form::close() !!}
@endif

@if(Auth::user()->role_id < 3 && $account->paid != 1)
            {!! Form::open(['route' => ['accounts.mark_as_paid'], 'method' => 'post', 'class'=>'pull-right','style'=>'margin-left: 10px']) !!}
            <input type="hidden" value="{{ $account->id}}" name="mark_as_paid" />
                 {!! Form::button('<i class="glyphicon glyphicon-ok"></i>  Mark as Paid', ['type' => 'submit', 'class' => 'btn btn-primary', 'onclick' => "return confirm('Are you sure you wish to confirm payout?')"]) !!}
      
            {!! Form::close() !!}
            @endif
        </h1>



       


    </section>
    <div class="content">
        <div class="clearfix"> </div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('accounts.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection

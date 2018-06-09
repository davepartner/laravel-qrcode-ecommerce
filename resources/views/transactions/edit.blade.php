@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Transaction
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($transaction, ['route' => ['transactions.update', $transaction->id], 'method' => 'patch']) !!}

                        @include('transactions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
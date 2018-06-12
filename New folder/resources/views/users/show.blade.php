@extends('layouts.app')

@section('content')
    <section class="content-header">
       
        <h1 class="pull-left">User: {!! $user->id !!}</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('users.edit',['id'=> $user->id]) !!}">Edit Profile</a>
        </h1>
    </section>
    <div class="content">
            <div class="clearfix"></div>

            @include('flash::message')
    
            <div class="clearfix"></div>
            
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('users.show_fields')
               </div>
            </div>
        </div>
    </div>
@endsection

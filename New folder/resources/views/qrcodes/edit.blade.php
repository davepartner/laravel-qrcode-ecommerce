@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Qrcode
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($qrcode, ['route' => ['qrcodes.update', $qrcode->id], 'method' => 'patch']) !!}

                        @include('qrcodes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
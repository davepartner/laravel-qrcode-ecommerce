
<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $user->name !!}</p>
</div>

<!-- Role Id Field -->
<div class="form-group">
    {!! Form::label('role_id', 'User level:') !!}
    <p>{!! $user->role['name'] !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $user->email !!}</p>
</div>



<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Joined:') !!}
    <p>{!! $user->created_at->format('D d, M , Y h:i') !!}</p>
</div>



@if($user->id == Auth::user()->id || Auth::user()->role_id < 3)
    <div class="col-xs-12">
        <h3 class="text-center ">Transactions</h3>
            @include('transactions.table')

    </div>
    <div class="col-xs-12">
            <h3 class="text-center ">Qrcodes</h3>
                @include('qrcodes.table')
    
        </div>
    


@endif


<div class="form-group">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('user[name]', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div><div class="form-group">
    {!! Form::label('email', 'E-mail:') !!}
    {!! Form::text('user[email]', null, ['class' => 'form-control', 'id' => 'email']) !!}
</div>
<div class="form-group">
    {!! Form::label('phone', 'Telefone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control', 'id' => 'phone']) !!}
</div>
<div class="form-group">
    {!! Form::label('address', 'Endere&ccedil;o:') !!}
    {!! Form::textarea('address', null, ['class' => 'form-control', 'id' => 'address']) !!}
</div>
<div class="form-group">
    {!! Form::label('city', 'Cidade:') !!}
    {!! Form::text('city', null, ['class' => 'form-control', 'id' => 'city']) !!}
</div>
<div class="form-group">
    {!! Form::label('state', 'Estado:') !!}
    {!! Form::text('state', null, ['class' => 'form-control', 'id' => 'state']) !!}
</div>
<div class="form-group">
    {!! Form::label('zipcode', 'CEP:') !!}
    {!! Form::text('zipcode', null, ['class' => 'form-control', 'id' => 'zipcode']) !!}
</div>
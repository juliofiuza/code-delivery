@extends('app')

@section('content')

<div class="container">
    <h3>Novo Cupom</h3>

    @include('errors._check')

    {!! Form::open(['route' => 'admin.cupoms.store']) !!}

    @include('admin.cupoms._form')
    
    <div class="form-group">
        <a href="{{ route('admin.cupoms.index') }}" class="btn btn-default">Voltar</a>
        {!! Form::submit('Criar', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}


</div>

@endsection
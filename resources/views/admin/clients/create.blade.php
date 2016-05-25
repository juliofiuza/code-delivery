@extends('app')

@section('content')

<div class="container">
    <h3>Novo Cliente</h3>

    @include('errors._check')

    {!! Form::open(['route' => 'admin.clients.store']) !!}

    @include('admin.clients._form')
    
    <div class="form-group">
        <a href="{{ route('admin.clients.index') }}" class="btn btn-default">Voltar</a>
        {!! Form::submit('Criar', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}


</div>

@endsection
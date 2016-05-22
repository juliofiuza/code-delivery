@extends('app')

@section('content')

<div class="container">
    <h3>Nova Categoria</h3>

    @include('errors._check')

    {!! Form::open(['route' => 'admin.categories.store']) !!}

    @include('admin.categories._form')
    
    <div class="form-group">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-default">Voltar</a>
        {!! Form::submit('Criar', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}


</div>

@endsection
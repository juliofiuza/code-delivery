@extends('app')

@section('content')

<div class="container">
    <h3>Editando Categoria: {{ $category->name }}</h3>

    @include('errors._check')

    {!! Form::model($category, ['route' => ['admin.categories.update', $category->id]]) !!}

    @include('admin.categories._form')

    <div class="form-group">
        <a href="{{ route('admin.categories.index') }}" class="btn btn-default">Voltar</a>
        {!! Form::submit('Editar Categoria', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

</div>

@endsection
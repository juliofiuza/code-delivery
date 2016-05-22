@extends('app')

@section('content')

<div class="container">
    <h3>Editando Produto: {{ $product->name }}</h3>

    @include('errors._check')

    {!! Form::model($product, ['route' => ['admin.products.update', $product->id]]) !!}

    @include('admin.products._form')

    <div class="form-group">
        <a href="{{ route('admin.products.index') }}" class="btn btn-default">Voltar</a>
        {!! Form::submit('Editar Produto', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

</div>

@endsection
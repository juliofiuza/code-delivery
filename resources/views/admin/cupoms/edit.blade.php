@extends('app')

@section('content')

<div class="container">
    <h3>Editando Cupom: {{ $cupom->name }}</h3>

    @include('errors._check')

    {!! Form::model($cupom, ['route' => ['admin.cupoms.update', $cupom->id]]) !!}

    @include('admin.cupoms._form')

    <div class="form-group">
        <a href="{{ route('admin.cupoms.index') }}" class="btn btn-default">Voltar</a>
        {!! Form::submit('Salvar Cupom', ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}

</div>

@endsection
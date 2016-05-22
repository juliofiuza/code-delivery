@extends('app')

@section('content')

<div class="container">
    <h3>Cupons</h3>

    <a href="{{ route('admin.cupoms.create') }}" class="btn btn-default">Novo Cupom</a>

    <br /><br />

    <table class="table table-bordered">
        <thead>
            <th>ID</th>
            <th>C&oacute;digo</th>
            <th>Valor</th>
            <th>A&ccedil;&atilde;o</th>
        </thead>
        <tbody>
        @foreach($cupoms as $cupom)
        <tr>
            <td>{{ $cupom->id }}</td>
            <td>{{ $cupom->code }}</td>
            <td>{{ $cupom->value }}</td>
            <td>---</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    {!! $cupoms->render() !!}
</div>

@endsection
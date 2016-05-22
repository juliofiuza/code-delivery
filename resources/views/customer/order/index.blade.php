@extends('app')

@section('content')

<div class="container">
    <h3>Meus Pedidos</h3>

    <a href="{{ route('customer.order.create') }}" class="btn btn-default">Novo Pedido</a>

    <br /><br />

    <table class="table table-bordered">
        <thead>
            <th>ID</th>
            <th>Total</th>
            <th>Status</th>
            <th>A&ccedil;&atilde;o</th>
        </thead>
        <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->total }}</td>
            <td>{{ $order->status }}</td>
            <td>
                <a href="{{ route('customer.order.index', ['id' => $order->id]) }}" class="btn btn-default btn-sm">Editar</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    {!! $orders->render() !!}
</div>

@endsection
@extends('app')

@section('content')

<div class="container">
    <h3>Pedido #{{ $order->id }} - R$ {{ $order->total }}</h3>
    <h3>Cliente: {{ $order->client->user->name }}</h3>
    <h4>{{ $order->created_at }}</h4>

    <p>
    	<b>Entregar em:</b><br />
    	{{ $order->client->address }} - {{ $order->client->city }} - {{ $order->client->state }}
    </p>

    <br />

    @include('errors._check')

    {!! Form::model($order, ['route' => ['admin.orders.update', $order->id]]) !!}

	<div class="form-group">
	    {!! Form::label('status', 'Status:') !!}
	    {!! Form::select('status', $list_status, null, ['class' => 'form-control', 'id' => 'status']) !!}
	</div>

	<div class="form-group">
	    {!! Form::label('user_deliveryman_id', 'Entregador:') !!}
	    {!! Form::select('user_deliveryman_id', $deliveryman, null, ['class' => 'form-control', 'id' => 'user_deliveryman_id']) !!}
	</div>

    <div class="form-group">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-default">Voltar</a>
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

</div>

@endsection
<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Services\OrderService;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Http\Request;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\AdminOrderRequest;
use CodeDelivery\Http\Controllers\Controller;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */ 
    protected $repository;

    /**
     * @var OrderService
     */	
	protected $orderService;

	public function __construct(OrderRepository $repository, OrderService $orderService) {
        $this->repository = $repository;
		$this->orderService = $orderService;
	}

    public function index() {
    	$orders = $this->repository->paginate(5);
    	return view('admin.orders.index', compact('orders'));
    }

    public function edit($id, UserRepository $userRepository) {
    	$list_status = [
            0 => 'Pendente',
            1 => 'A caminho',
            2 => 'Entregue',
            3 => 'Cancelado'
        ];

        $deliveryman = $userRepository->findWhere(['role' => 'deliveryman'])->lists('name', 'id');
        $order = $this->repository->find($id);
    	return view('admin.orders.edit', compact('order', 'list_status', 'deliveryman'));
    }

    public function update(AdminOrderRequest $request, $id) {
    	$data = $request->all();
    	$this->repository->update($data, $id);
    	
    	return redirect()->route('admin.orders.index');
    }

}

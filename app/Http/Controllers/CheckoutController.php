<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use CodeDelivery\Http\Requests\CheckoutRequest;
use CodeDelivery\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    /**
     * @var OrderRepository
     */ 
    protected $repository;

    /**
     * @var UserRepository
     */ 
    protected $userRepository;

    /**
     * @var ProductRepository
     */ 
    protected $productRepository;

    /**
     * @var OrderService
     */	
	protected $service;

	public function __construct(OrderRepository $repository,
                                UserRepository $userRepository,
                                ProductRepository $productRepository,
                                OrderService $service) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
		$this->service = $service;
	}

    public function index() {
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
    	$orders = $this->repository->scopeQuery(function($query) use ($clientId) {
            return $query->where('client_id', $clientId);
        })->paginate(5);

    	return view('customer.order.index', compact('orders'));
    }

    public function create() {
        $products = $this->productRepository->lista();
    	return view('customer.order.create', compact('products'));
    }

    public function store(CheckoutRequest $request) {
    	$data = $request->all();
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $data['client_id'] = $clientId;
    	$this->service->create($data);
    	
    	return redirect()->route('customer.order.index');
    }

}

<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;

class ClientCheckoutController extends Controller
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
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
    	$orders = $this->repository->with(['items'])->scopeQuery(function($query) use ($clientId) {
            return $query->where('client_id', $clientId);
        })->paginate(5);

    	return $orders;
    }

    public function store(Request $request) {
    	$data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        
    	$o = $this->service->create($data);
        return $this->repository->with('items')->find($o->id);
    }

    public function show($id) {
        $order = $this->repository->with(['client', 'items', 'cupom'])->find($id);

        $order->items->each(function($item) {
            $item->product;
        });

        return $order;
    }

}

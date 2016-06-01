<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Repositories\ProductRepository;
use Illuminate\Http\Request;

use CodeDelivery\Http\Controllers\Controller;

class ClientProductController extends Controller
{
    /**
     * @var ProductRepository
     */ 
    private $repository;

	public function __construct(ProductRepository $repository) {
		$this->repository = $repository;
	}

    public function index() {
    	$products = $this->repository->skipPresenter(false)->all();

    	return $products;
    }

}

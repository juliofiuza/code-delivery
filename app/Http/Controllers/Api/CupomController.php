<?php

namespace CodeDelivery\Http\Controllers\Api;

use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Http\Controllers\Controller;

class CupomController extends Controller
{
    /**
     * @var CupomRepository
     */	
	protected $repository;

	public function __construct(CupomRepository $repository) {
		$this->repository = $repository;
	}

    public function show($code) {
    	return $this->repository->skipPresenter(false)->findByCode($code);
    }

}

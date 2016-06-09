<?php

namespace CodeDelivery\Http\Controllers\Api;

use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Http\Controllers\Controller;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */	
	protected $repository;

	public function __construct(UserRepository $repository) {
		$this->repository = $repository;
	}

    public function authenticated() {
        $id = Authorizer::getResourceOwnerId();
    	return $this->repository->skipPresenter(false)->find($id);
    }

}

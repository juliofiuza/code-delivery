<?php

namespace CodeDelivery\Services;

use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */	
	private $orderRepository;

    /**
     * @var UserRepository
     */	
	private $userRepository;

	public function __construct(OrderRepository $orderRepository, UserRepository $userRepository)
	{
		$this->orderRepository = $orderRepository;
		$this->userRepository = $userRepository;
	}

	public function create(array $data) {
		$data['user']['password'] = bcrypt(123456);

		$user = $this->userRepository->create($data['user']);

		$data['user_id'] = $user->id;
		$this->orderRepository->create($data);
	}

	public function update(array $data, $id) {
		$this->orderRepository->update($data, $id);
		
		$userId = $this->orderRepository->find($id, ['user_id'])->user_id;

		$this->userRepository->update($data['user'], $userId);
	}
}
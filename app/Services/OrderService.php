<?php

namespace CodeDelivery\Services;

use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\CupomRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;

class OrderService
{
    /**
     * @var CupomRepository
     */	
	private $cupomRepository;

    /**
     * @var OrderRepository
     */	
	private $orderRepository;

    /**
     * @var ProductRepository
     */	
	private $productRepository;

	public function __construct(CupomRepository $cupomRepository,
								OrderRepository $orderRepository,
								ProductRepository $productRepository)
	{
		$this->cupomRepository = $cupomRepository;
		$this->orderRepository = $orderRepository;
		$this->productRepository = $productRepository;
	}

	public function create(array $data) {
		\DB::beginTransaction();
		
		try {
			$data['status'] = 0;

			if (isset($data['cupom_code'])) {
				$cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
				$data['cupom_id'] = $cupom->id;

				$cupom->used = 1;
				$cupom->save();
				unset($data['cupom_id']);
			}

			$items = $data['items'];
			unset($data['items']);

            $data['total'] = $total = 0;
            $order = $this->orderRepository->create($data);

			foreach($items as $item) {
				$item['price'] = $this->productRepository->find($item['product_id'])->price;
				$order->items()->create($item);
				$total += $item['price'] * $item['qtd'];
			}

			$order->total = $total;

			if(isset($cupom)) {
				$order->total = $total - $cupom->value;
			}

			$order->save();
			\DB::commit();
			return $order;
		} catch(\Exception $e) {
			\DB::rollback();
			throw $e;
		}
	}

	public function update(array $data, $id) {
		$this->orderRepository->update($data, $id);
		
		$userId = $this->orderRepository->find($id, ['user_id'])->user_id;

		$this->userRepository->update($data['user'], $userId);
	}

	public function updateStatus($id, $idDeliveryman, $status) {
		$order = $this->orderRepository->getByIdAndDeliveryman($id, $idDeliveryman);
		
		if ($order instanceof Order) {
			$order->status = $status;
			$order->save();
			return $order;
		}

		return false;
	}
}
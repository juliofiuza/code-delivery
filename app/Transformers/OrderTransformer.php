<?php

namespace CodeDelivery\Transformers;

use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [];

    protected $availableIncludes = [
        'cupom',
        'items',
        'client',
        'deliveryman'
    ];

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,
            'status' => $model->status,
            'client_id' => $model->client_id,
            'user_deliveryman_id' => $model->user_deliveryman_id,
            'total' => (float)$model->total,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeClient(Order $model) {
        return $this->item($model->client, new ClientTransformer());
    }
    
    public function includeDeliveryman(Order $model) {
        if (!$model->deliveryman) {
            return null;
        }

        return $this->item($model->deliveryman, new UserTransformer());
    }

    public function includeCupom(Order $model) {
        if (!$model->cupom) {
            return null;
        }

        return $this->item($model->cupom, new CupomTransformer());
    }

    public function includeItems(Order $model) {
        return $this->collection($model->items, new OrderItemTransformer());
    }
}

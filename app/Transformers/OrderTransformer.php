<?php

namespace CodeDelivery\Transformers;

use CodeDelivery\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

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
            'total' => (float)$model->total,
            'product_names' => $this->getArrayProductNames($model->items),
            'hash' => $model->hash,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    protected function getArrayProductNames(Collection $items) {
        $names = [];
        foreach ($items as $item) {
            $names[] = $item->product->name;
        }
        return $names;
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

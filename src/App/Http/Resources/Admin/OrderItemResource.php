<?php

namespace App\Http\Resources\Admin;

use Domain\Products\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrderItemResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Orders\Models\Order
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'uuid' => $this->resource->uuid,
            'created_at' => $this->resource->created_at instanceof Carbon
                ? $this->resource->created_at->format('Y-m-d H:i:s')
                : null,
            'order_status_id' => $this->resource->order_status_id,
            'comment_admin' => $this->resource->comment_admin,
            'comment_user' => $this->resource->comment_user,
            'importance_id' => $this->resource->importance_id,
            'admin_id' => $this->resource->admin_id,
            'admin_name' => $this->resource->admin->name ?? null,
            'admin_color' => $this->resource->admin->admin_color ?? null,
            'user_id' => $this->resource->user_id ?? null,
            'user_name' => $this->resource->user->name ?? null,
            'user_email' => $this->resource->user->email ?? null,
            'user_phone' => $this->resource->user->phone ?? null,
            'request_user_name' => $this->resource->request['name'] ?? null,
            'request_user_email' => $this->resource->request['email'] ?? null,
            'request_user_phone' => $this->resource->request['phone'] ?? null,
            'products' => $this->resource->products->map(fn (Product $product) => (new OrderItemProductItemResource($product))->toArray($request)),
            'payment_method_id' => $this->resource->payment_method_id,
            'is_busy_by_other_admin' => $this->resource->is_busy_by_other_admin,
        ];
    }
}

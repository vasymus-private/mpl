<?php

namespace App\Http\Resources\Admin;

use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class OrderResource extends JsonResource
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
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'user_name' => $this->resource->user->name ?? null,
            'user_email' => $this->resource->user->email ?? null,
            'user_phone' => $this->resource->user->phone ?? null,
            'request_user_name' => $this->resource->request['name'] ?? null,
            'request_user_email' => $this->resource->request['email'] ?? null,
            'request_user_phone' => $this->resource->request['phone'] ?? null,
            'order_status_id' => $this->resource->order_status_id,
            'cancelled' => $this->resource->cancelled,
            'cancelled_description' => $this->resource->cancelled_description,
            'payment_method_id' => $this->resource->payment_method_id,
            'comment_user' => $this->resource->comment_user,
            'initial_attachments' => $this->resource->initial_attachments->map(fn (CustomMedia $media) => (new MediaResource($media))->toArray($request)),
            'payment_method_attachments' => $this->resource->payment_method_attachments->map(fn (CustomMedia $media) => (new MediaResource($media))->toArray($request)),
            'admin_id' => $this->resource->admin_id,
            'admin_name' => $this->resource->admin->name ?? null,
            'admin_color' => $this->resource->admin->admin_color ?? null,
            'importance_id' => $this->resource->importance_id,
            'customer_bill_description' => $this->resource->customer_bill_description,
            'customer_bill_status_id' => $this->resource->customer_bill_status_id,
            'customer_invoices' => $this->resource->customer_invoices->map(fn (CustomMedia $media) => (new MediaResource($media))->toArray($request)),
            'provider_bill_status_id' => $this->resource->provider_bill_status_id,
            'provider_bill_description' => $this->resource->provider_bill_description,
            'supplier_invoices' => $this->resource->supplier_invoices->map(fn (CustomMedia $media) => (new MediaResource($media))->toArray($request)),
            'comment_admin' => $this->resource->comment_admin,
            'products' => $this->resource->products->map(fn (Product $product) => (new OrderProductItemResource($product))->toArray($request)),
            'created_at' => $this->resource->created_at instanceof Carbon
                ? $this->resource->created_at->format('Y-m-d H:i:s')
                : null,
            'updated_at' => $this->resource->updated_at instanceof Carbon
                ? $this->resource->updated_at->format('Y-m-d H:i:s')
                : null,
            'is_busy_by_other_admin' => $this->resource->is_busy_by_other_admin,
            'busy_by_name' => $this->resource->busyBy->name ?? null,
        ];
    }
}

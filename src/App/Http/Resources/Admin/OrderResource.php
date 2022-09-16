<?php

namespace App\Http\Resources\Admin;

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
            'order_status_id' => $this->resource->order_status_id,
            'cancelled' => $this->resource->cancelled,
            'cancelled_description' => $this->resource->cancelled_description,
            'email' => '',
            'name' => '',
            'phone' => '',
            'payment_method_id' => $this->resource->payment_method_id,

            'comment_user' => $this->resource->comment_user,
            'initialAttachments' => [],
            'paymentMethodAttachments' => [],

            'admin_id' => $this->resource->admin_id,
            'admin_name' => $this->resource->admin->name ?? null,
            'importance_id' => $this->resource->importance_id,
            'customer_bill_description' => $this->resource->customer_bill_description,
            'customer_bill_status_id' => $this->resource->customer_bill_status_id,

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

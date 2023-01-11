<?php

namespace App\Http\Resources\Admin;

use Domain\Common\Enums\Column;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var \Domain\Users\Models\Admin
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
            'auth' => [
                'user' => [
                    'id' => $this->resource->id,
                    'name' => $this->resource->name,
                    'email' => $this->resource->email,
                    'phone' => $this->resource->phone,
                    'is_anonymous' => $this->resource->is_anonymous2,
                    'is_super_admin' => $this->resource->is_super_admin,
                ],
            ],

            'adminSidebarFlexBasis' => $this->resource->admin_sidebar_flex_basis,

            'adminOrderColumns' => $this->resource->admin_order_columns_arr,
            'adminProductColumns' => $this->resource->admin_product_columns_arr,
            'adminProductVariantColumns' => $this->resource->admin_product_variant_columns_arr,

            'adminProductsColumnSizes' => collect($this->resource->admin_products_column_sizes)->map([$this, '_columnSizeMapCB'])->filter()->values()->all(),
            'adminProductVariationsColumnSizes' => collect($this->resource->admin_product_variations_column_sizes)->map([$this, '_columnSizeMapCB'])->filter()->values()->all(),
            'adminOrdersColumnSizes' => collect($this->resource->admin_orders_column_sizes)->map([$this, '_columnSizeMapCB'])->filter()->values()->all(),
        ];
    }

    /**
     * @param string $value
     * @param int $key
     *
     * @return array|null
     */
    public function _columnSizeMapCB(string $value, int $key): ?array
    {
        $enum = Column::tryFrom($key);
        if (! $enum) {
            return null;
        }

        return [
            'column' => [
                'value' => $enum->value,
                'label' => $enum->label,
            ],
            'width' => $value,
        ];
    }
}

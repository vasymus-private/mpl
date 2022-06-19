<?php

namespace App\Http\Controllers\Admin\Ajax\Product;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\Common\Enums\Column;
use Domain\Orders\Actions\GetDefaultAdminOrderColumnsAction;
use Domain\Products\Actions\GetDefaultAdminProductColumnsAction;
use Domain\Products\Actions\GetDefaultAdminProductVariantColumnsAction;
use Illuminate\Http\Request;
use Support\H;

class SortColumnsController extends BaseAdminController
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array[]
     */
    public function __invoke(Request $request): array
    {
        $validated = $request->validate([
            'adminOrderColumns' => 'array|nullable',
            'adminOrderColumns.*' => [
                'integer',
                sprintf('in:%s', implode(',', Column::toValues())),
            ],
            'adminOrderColumnsDefault' => 'boolean|nullable',
            'adminProductColumns' => 'array|nullable',
            'adminProductColumns.*' => [
                'integer',
                sprintf('in:%s', implode(',', Column::toValues())),
            ],
            'adminProductColumnsDefault' => 'boolean|nullable',
            'adminProductVariantColumns' => 'array|nullable',
            'adminProductVariantColumns.*' => [
                'integer',
                sprintf('in:%s', implode(',', Column::toValues())),
            ],
            'adminProductVariantColumnsDefault' => 'boolean|nullable',
        ]);

        $admin = H::admin();

        if (isset($validated['adminOrderColumns'])) {
            $admin->admin_order_columns = collect($validated['adminOrderColumns'])->map(fn ($value) => Column::from($value))->all();
        }
        if (isset($validated['adminOrderColumnsDefault'])) {
            $admin->admin_order_columns = GetDefaultAdminOrderColumnsAction::cached()->execute();
        }

        if (isset($validated['adminProductColumns'])) {
            $admin->admin_product_columns = collect($validated['adminProductColumns'])->map(fn ($value) => Column::from($value))->all();
        }
        if (isset($validated['adminProductColumnsDefault'])) {
            $admin->admin_product_columns = GetDefaultAdminProductColumnsAction::cached()->execute();
        }

        if (isset($validated['adminProductVariantColumns'])) {
            $admin->admin_product_variant_columns = collect($validated['adminProductVariantColumns'])->map(fn ($value) => Column::from($value))->all();
        }
        if (isset($validated['adminProductVariantColumnsDefault'])) {
            $admin->admin_product_variant_columns = GetDefaultAdminProductVariantColumnsAction::cached()->execute();
        }

        $admin->save();

        return [
            'data' => [
                'adminOrderColumns' => H::admin()->admin_order_columns_arr,
                'adminProductColumns' => H::admin()->admin_product_columns_arr,
                'adminProductVariantColumns' => H::admin()->admin_product_variant_columns_arr,
            ]
        ];
    }
}

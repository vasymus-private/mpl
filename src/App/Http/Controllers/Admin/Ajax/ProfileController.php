<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\AdminProfileUpdateRequest;
use Domain\Common\Enums\Column;
use Domain\Orders\Actions\GetDefaultAdminOrderColumnsAction;
use Domain\Products\Actions\GetDefaultAdminProductColumnsAction;
use Domain\Products\Actions\GetDefaultAdminProductVariantColumnsAction;
use Domain\Users\Actions\GetAdminOrdersColumnSizesAction;
use Domain\Users\Actions\GetAdminProductsColumnDefaultSizesAction;
use Domain\Users\Actions\GetAdminProductVariationsColumnDefaultSizesAction;
use Domain\Users\Models\Admin;

class ProfileController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\AdminProfileUpdateRequest $request
     *
     * @return array[]
     */
    public function update(AdminProfileUpdateRequest $request)
    {
        $hasChanges = false;

        if ($request->has('adminSidebarFlexBasis')) {
            $request->admin->admin_sidebar_flex_basis = $request->adminSidebarFlexBasis;
            $hasChanges = true;
        }

        if ($request->has('adminOrderColumns')) {
            $request->admin->admin_order_columns = collect($request->adminOrderColumns)->map(fn ($value) => Column::from($value))->all();
            $hasChanges = true;
        }
        if ($request->has('adminOrderColumnsDefault')) {
            $request->admin->admin_order_columns = GetDefaultAdminOrderColumnsAction::cached()->execute();
            $hasChanges = true;
        }

        if ($request->has('adminProductColumns')) {
            $request->admin->admin_product_columns = collect($request->adminProductColumns)->map(fn ($value) => Column::from($value))->all();
            $hasChanges = true;
        }
        if ($request->has('adminProductColumnsDefault')) {
            $request->admin->admin_product_columns = GetDefaultAdminProductColumnsAction::cached()->execute();
            $hasChanges = true;
        }

        if ($request->has('adminProductVariantColumns')) {
            $request->admin->admin_product_variant_columns = collect($request->adminProductVariantColumns)->map(fn ($value) => Column::from($value))->all();
            $hasChanges = true;
        }
        if ($request->has('adminProductVariantColumnsDefault')) {
            $request->admin->admin_product_variant_columns = GetDefaultAdminProductVariantColumnsAction::cached()->execute();
            $hasChanges = true;
        }

        if ($request->has('adminProductsColumnSizes')) {
            $request->admin->admin_products_column_sizes = collect($request->adminProductsColumnSizes)->reduce([$this, '_reduceCB'], []);
            $hasChanges = true;
        }
        if ($request->has('adminProductsColumnSizesDefault')) {
            $request->admin->admin_products_column_sizes = GetAdminProductsColumnDefaultSizesAction::cached()->execute();
        }

        if ($request->has('adminProductVariationsColumnSizes')) {
            $request->admin->admin_product_variations_column_sizes = collect($request->adminProductVariationsColumnSizes)->reduce([$this, '_reduceCB'], []);
            $hasChanges = true;
        }
        if ($request->has('adminProductVariationsColumnSizesDefault')) {
            $request->admin->admin_product_variations_column_sizes = GetAdminProductVariationsColumnDefaultSizesAction::cached()->execute();
            $hasChanges = true;
        }

        if ($request->has('adminOrdersColumnSizes')) {
            $request->admin->admin_orders_column_sizes = collect($request->adminOrdersColumnSizes)->reduce([$this, '_reduceCB'], []);
            $hasChanges = true;
        }
        if ($request->has('adminOrdersColumnSizesDefault')) {
            $request->admin->admin_orders_column_sizes = GetAdminOrdersColumnSizesAction::cached()->execute();
            $hasChanges = true;
        }

        if ($hasChanges) {
            $request->admin->save();
        }

        /** @var \Domain\Users\Models\Admin $admin */
        $admin = Admin::query()->findOrFail($request->admin->id);

        return [
            'settings' => [
                'adminSidebarFlexBasis' => $admin->admin_sidebar_flex_basis,
                'adminOrderColumns' => $admin->admin_order_columns_arr,
                'adminProductColumns' => $admin->admin_product_columns_arr,
                'adminProductVariantColumns' => $admin->admin_product_variant_columns_arr,
                'adminProductsColumnSizes' => $admin->admin_products_column_sizes,
                'adminProductVariationsColumnSizes' => $admin->admin_product_variations_column_sizes,
                'adminOrdersColumnSizes' => $admin->admin_orders_column_sizes,
            ],
        ];
    }

    /**
     * @phpstan-param array<int, string> $acc
     * @phpstan-param array $item
     *
     * @phpstan-return array<int, string>
     */
    public function _reduceCB(array $acc, array $item): array
    {
        $acc[$item['column']] = $item['size'];

        return $acc;
    }
}

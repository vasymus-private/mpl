<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\AdminProfileUpdateRequest;
use Domain\Common\Enums\Column;
use Domain\Orders\Actions\GetDefaultAdminOrderColumnsAction;
use Domain\Products\Actions\GetDefaultAdminProductColumnsAction;
use Domain\Products\Actions\GetDefaultAdminProductVariantColumnsAction;
use Support\H;

class ProfileController extends BaseAdminController
{
    public function update(AdminProfileUpdateRequest $request)
    {
        $validated = $request->validated();

        $admin = H::admin();

        $hasChanges = false;

        if (isset($validated['adminOrderColumns'])) {
            $admin->admin_order_columns = collect($validated['adminOrderColumns'])->map(fn ($value) => Column::from($value))->all();
            $hasChanges = true;
        }
        if (isset($validated['adminOrderColumnsDefault'])) {
            $admin->admin_order_columns = GetDefaultAdminOrderColumnsAction::cached()->execute();
            $hasChanges = true;
        }

        if (isset($validated['adminProductColumns'])) {
            $admin->admin_product_columns = collect($validated['adminProductColumns'])->map(fn ($value) => Column::from($value))->all();
            $hasChanges = true;
        }
        if (isset($validated['adminProductColumnsDefault'])) {
            $admin->admin_product_columns = GetDefaultAdminProductColumnsAction::cached()->execute();
            $hasChanges = true;
        }

        if (isset($validated['adminProductVariantColumns'])) {
            $admin->admin_product_variant_columns = collect($validated['adminProductVariantColumns'])->map(fn ($value) => Column::from($value))->all();
            $hasChanges = true;
        }
        if (isset($validated['adminProductVariantColumnsDefault'])) {
            $admin->admin_product_variant_columns = GetDefaultAdminProductVariantColumnsAction::cached()->execute();
            $hasChanges = true;
        }

        if ($request->adminProductsTableSizes) {
            $settings = $admin->settings;
            $settings['adminProductsTableSizes'] = $request->adminProductsTableSizes;
            $admin->settings = $settings;
            $hasChanges = true;
        }

        if ($request->adminProductVariationsTableSizes) {
            $settings = $admin->settings;
            $settings['adminProductVariationsTableSizes'] = $request->adminProductVariationsTableSizes;
            $admin->settings = $settings;
            $hasChanges = true;
        }

        if ($request->adminOrdersTableSizes) {
            $settings = $admin->settings;
            $settings['adminOrdersTableSizes'] = $request->adminOrdersTableSizes;
            $admin->settings = $settings;
            $hasChanges = true;
        }

        if ($hasChanges) {
            $admin->save();
        }

        $admin->save();

        return [
            'data' => [
                'adminOrderColumns' => H::admin()->admin_order_columns_arr,
                'adminProductColumns' => H::admin()->admin_product_columns_arr,
                'adminProductVariantColumns' => H::admin()->admin_product_variant_columns_arr,
            ],
        ];




        if ($request->adminSidebarFlexBasis) {
            $settings = $request->admin->settings;
            $settings['adminSidebarFlexBasis'] = $request->adminSidebarFlexBasis;
            $request->admin->settings = $settings;
            $request->admin->save();
        }

        return [
            'settings' => $request->admin->settings,
        ];
    }
}

<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\Enums\Column;
use Domain\Orders\Actions\GetDefaultAdminOrderColumnsAction;
use Domain\Products\Actions\GetDefaultAdminProductColumnsAction;
use Domain\Products\Actions\GetDefaultAdminProductVariantColumnsAction;
use Illuminate\Support\Facades\Log;
use Support\H;

trait HasSortableColumns
{
    /**
     * @var \Domain\Common\Enums\Column[]
     */
    public array $sortableColumns;

    /**
     * @return void
     */
    protected function initOrdersAsSortableColumns()
    {
        $this->sortableColumns = H::admin()->admin_order_columns;
    }

    /**
     * @return void
     */
    protected function initProductsAsSortableColumns()
    {
        $this->sortableColumns = H::admin()->admin_product_columns;
    }

    /**
     * @return void
     */
    protected function initProductVariantsAsSortableColumns()
    {
        $this->sortableColumns = H::admin()->admin_product_variant_columns;
    }

    /**
     * @param int[] $value
     *
     * @return void
     */
    public function hydrateSortableColumns(array $value = [])
    {
        $this->sortableColumns = collect($value)->map(fn ($v) => Column::from($v))->unique()->values()->all();
    }

    /**
     * @param int[] $values
     *
     * @return bool
     */
    protected function customizeOrdersSortableList(array $values): bool
    {
        $admin = H::admin();
        if (count($values) !== count($admin->admin_order_columns)) {
            return false;
        }

        $sortableColumns = collect($values)->map(fn ($value) => Column::from($value))->all();
        $admin->admin_order_columns = $sortableColumns;
        $admin->save();

        $this->sortableColumns = $admin->admin_order_columns;

        return true;
    }

    /**
     * @return bool
     */
    protected function defaultOrdersSortableList(): bool
    {
        $admin = H::admin();
        $sortableColumns = GetDefaultAdminOrderColumnsAction::cached()->execute();
        $admin->admin_order_columns = $sortableColumns;
        $admin->save();
        $this->sortableColumns = $admin->admin_order_columns;

        return true;
    }

    /**
     * @param int[] $values
     *
     * @return bool
     */
    public function customizeProductsSortableList(array $values): bool
    {
        $admin = H::admin();
        $values = collect($values)->unique();
        if ($values->count() !== count($admin->admin_product_columns)) {
            return false;
        }

        $sortableColumns = collect($values)->map(fn ($value) => Column::from($value))->all();
        $admin->admin_product_columns = $sortableColumns;
        $admin->save();

        $this->sortableColumns = $admin->admin_product_columns;

        return true;
    }

    /**
     * @return bool
     */
    public function defaultProductsSortableList(): bool
    {
        $admin = H::admin();
        $sortableColumns = GetDefaultAdminProductColumnsAction::cached()->execute();
        $admin->admin_product_columns = $sortableColumns;
        $admin->save();
        $this->sortableColumns = $admin->admin_product_columns;

        return true;
    }

    /**
     * @param int[] $values
     *
     * @return bool
     */
    public function customizeProductVariantsSortableList(array $values): bool
    {
        $admin = H::admin();
        if (count($values) !== count($admin->admin_product_variant_columns)) {
            return false;
        }

        $sortableColumns = collect($values)->map(fn ($value) => Column::from($value))->all();
        $admin->admin_product_variant_columns = $sortableColumns;
        $admin->save();

        $this->sortableColumns = $admin->admin_product_variant_columns;

        return true;
    }

    /**
     * @return bool
     */
    public function defaultProductVariantsSortableList(): bool
    {
        $admin = H::admin();
        $sortableColumns = GetDefaultAdminProductVariantColumnsAction::cached()->execute();
        $admin->admin_product_variant_columns = $sortableColumns;
        $admin->save();
        $this->sortableColumns = $admin->admin_product_variant_columns;

        return true;
    }
}

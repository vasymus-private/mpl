<?php
/**
 * @var array[] $products @see {@link \Domain\Products\DTOs\ProductItemAdminDTO[]}
 * @var string|int|null $category_id
 * @var string|int|null $category_name
 * @var bool $editMode
 * @var \App\Http\Livewire\Admin\CategoriesList $this
 */
?>
<div>
    @include('admin.livewire.includes.form-search', [
        'submit' => 'handleSearch',
        'newRoute' => route('admin.products.create'),
        'clearAll' => 'clearAllFilters',
        'prepends' => $this->getPrepends(),
    ])
</div>

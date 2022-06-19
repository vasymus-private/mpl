<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\SearchPrependAdminDTO;
use Domain\Common\Models\Currency;
use Domain\Products\Actions\DeleteProductAction;
use Domain\Products\DTOs\Admin\ProductItemDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductsList extends BaseItemsListComponent
{
    use HasBrands;
    use HasAvailabilityStatuses;
    use HasCurrencies;
    use HasSelectAll;
    use HasSortableColumns;

    /**
     * @var string|int
     */
    public $search = '';

    /**
     * @var string|int
     */
    public $category_id = '';

    /**
     * @var string
     */
    public $category_name = '';

    /**
     * @var string|int
     */
    public $brand_id = '';

    /**
     * @var string
     */
    public $brand_name = '';

    /**
     * @var string|array|null
     */
    public $request_query;

    /**
     * @var bool
     */
    public $editMode = false;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\Admin\ProductItemDTO[]}
     */
    public array $items = [];

    protected array $rules = [
        'items.*.name' => 'required|string|max:250',
        'items.*.ordering' => 'integer|nullable',
        'items.*.is_active' => 'nullable|boolean',
        'items.*.unit' => 'nullable|string|max:250',
        'items.*.price_purchase' => 'nullable|numeric',
        'items.*.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
        'items.*.price_retail' => 'nullable|numeric',
        'items.*.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
        'items.*.admin_comment' => 'nullable|string|max:250',
        'items.*.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",
    ];

    protected function queryString(): array
    {
        return array_merge($this->getPerPageQueryString(), [
            'search' => ['except' => ''],
            'category_id' => ['except' => ''],
            'brand_id' => ['except' => ''],
        ]);
    }

    public function mount()
    {
        $this->mountRequest();
        $this->mountPerPage();
        $this->mountPerPageOptions();
        $this->fetchItems();
        $this->initBrandsOptions();
        $this->initAvailabilityStatusesOptions();
        $this->initCurrenciesOptions();

        $this->initProductsAsSortableColumns();
    }

    public function render()
    {
        return view('admin.livewire.products-list.products-list', [
            'paginator' => new LengthAwarePaginator(
                $this->items,
                $this->total,
                $this->per_page,
                $this->page
            ),
        ]);
    }

    public function saveSelected()
    {
        $checked = collect($this->items)->filter(fn (array $item) => $item['is_checked'])->all();
        if (empty($checked)) {
            $this->editMode = false;
            $this->selectAll = false;

            return;
        }
        $checkedIds = collect($checked)->pluck('id')->toArray();
        $checkedModels = Product::query()->whereIn('id', $checkedIds)->get();
        $checkedModels->each(function (Product $product) use ($checked) {
            $payload = $checked[$product->uuid] ?? [];
            if (! $payload) {
                return true;
            }
            $product->forceFill(
                collect($payload)
                    ->only($this->getUpdateKeys())
                    ->all()
            );
            $product->save();
        });
        $this->editMode = false;
        $this->changeItemsSelectAll(false);
        $this->selectAll = false;
        $this->fetchItems();
    }

    public function deleteSelected()
    {
        $deleteIds = collect($this->items)->filter(fn (array $item) => $item['is_checked'])->pluck('id')->toArray();
        $deleteProducts = Product::query()->whereIn('id', $deleteIds)->get();
        $deleteProducts->each(function (Product $product) {
            $product->clearMediaCollection(Product::MC_MAIN_IMAGE);
            $product->clearMediaCollection(Product::MC_ADDITIONAL_IMAGES);
            $product->clearMediaCollection(Product::MC_FILES);
            $product->delete();
        });
        $this->editMode = false;
        $this->changeItemsSelectAll(false);
        $this->selectAll = false;
        $this->fetchItems();
    }

    public function clearAllFilters()
    {
        $this->search = '';
        $this->category_id = '';
        $this->brand_id = '';
        $this->fetchItems();
    }

    public function clearCategoryFilter()
    {
        $this->category_id = '';
        $this->fetchItems();
    }

    public function clearBrandFilter()
    {
        $this->brand_id = '';
        $this->fetchItems();
    }

    protected function mountRequest()
    {
        $request = request();

        $this->category_id = $request->input('category_id');
        $this->brand_id = $request->input('brand_id');
        $this->search = $request->input('search', '');

        $this->request_query = $request->query();
    }

    /**
     * @inheritDoc
     */
    protected function getItemsQuery(): Builder
    {
        $query = Product::query()
            ->select(["*"])
            ->notVariations()
            ->orderByOrderingAndId();

        if ($this->category_id) {
            $category = Category::query()->findOrFail($this->category_id);
            $this->category_name = $category->name;
            $query->forMainAndRelatedCategories([$this->category_id]);
        }

        if ($this->brand_id) {
            $brand = Brand::query()->findOrFail($this->brand_id);
            $this->brand_name = $brand->name;
            $query->whereBrandId($this->brand_id);
        }

        if ($this->search) {
            $query->whereNameOrSlugLike($this->search);
        }

        return $query;
    }

    /**
     * @param \Domain\Products\Models\Product\Product[] $items
     *
     * @return void
     */
    protected function setItems(array $items)
    {
        $this->items = collect($items)->map(fn (Product $product) => ProductItemDTO::fromModel($product)->toArray())->keyBy('uuid')->all();
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->changeItemsSelectAll(false);
        $this->selectAll = false;
        $this->fetchItems();
    }

    public function toggleActive($id)
    {
        /** @var \Domain\Products\Models\Product\Product|null $product */
        $product = Product::query()->find($id);
        if (! $product) {
            return;
        }

        $product->is_active = ! $product->is_active;
        $product->save();
        $this->items[$product->uuid] = ProductItemDTO::fromModel($product)->toArray();
    }

    public function handleDelete($id)
    {
        /** @var \Domain\Products\Models\Product\Product|null $product */
        $product = Product::query()->find($id);
        if (! $product) {
            return;
        }
        DeleteProductAction::cached()->execute($product);
        $this->fetchItems();
    }

    /**
     * @return array[] @see {@link \Domain\Common\DTOs\SearchPrependAdminDTO}
     */
    public function getPrepends(): array
    {
        $prepends = [];
        if ($this->category_id) {
            $prepends[] = (new SearchPrependAdminDTO([
                'label' => $this->category_name,
                /** @see \App\Http\Livewire\Admin\ProductsList::clearCategoryFilter() */
                'onClear' => 'clearCategoryFilter',
            ]))->toArray();
        }
        if ($this->brand_id) {
            $prepends[] = (new SearchPrependAdminDTO([
                'label' => $this->brand_name,
                /** @see \App\Http\Livewire\Admin\ProductsList::clearBrandFilter() */
                'onClear' => 'clearBrandFilter',
            ]))->toArray();
        }

        return $prepends;
    }

    /**
     * @return string[]
     */
    protected function getUpdateKeys(): array
    {
        return [
            'name',
            'ordering',
            'is_active',
            'unit',
            'price_purchase',
            'price_purchase_currency_id',
            'price_retail',
            'price_retail_currency_id',
            'admin_comment',
            'availability_status_id',
        ];
    }

    /**
     * @param int[] $values
     *
     * @return bool
     */
    public function handleCustomizeSortableList(array $values): bool
    {
        return $this->customizeProductsSortableList($values);
    }

    /**
     * @return bool
     */
    public function handleDefaultSortableList(): bool
    {
        return $this->defaultProductsSortableList();
    }
}

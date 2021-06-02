<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Common\Models\Currency;
use Domain\Products\DTOs\ProductItemAdminDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;
    use HasBrands;
    use HasAvailabilityStatuses;
    use HasCurrencies;

    protected const DEFAULT_PER_PAGE = 20;

    public $search = '';

    public $category_id = '';

    public $category_name = '';

    public $brand_id = '';

    public $brand_name = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'per_page' => ['except' => self::DEFAULT_PER_PAGE],
        'category_id' => ['except' => ''],
        'brand_id' => ['except' => ''],
    ];

    public $total = 0;

    public $last_page;

    public $per_page = self::DEFAULT_PER_PAGE;

    public $request_query;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO[]}
     */
    public $per_page_options = [];

    public $editMode = false;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\ProductItemAdminDTO[]}
     */
    public array $products = [];

    public $selectAll = false;

    protected array $rules = [
        'products.*.name' => 'required|max:199',
        'products.*.ordering' => 'integer|nullable',
        'products.*.is_active' => 'nullable|boolean',
        'products.*.unit' => 'nullable|string|max:199',
        'products.*.price_purchase' => 'nullable|numeric',
        'products.*.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
        'products.*.price_retail' => 'nullable|numeric',
        'products.*.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
        'products.*.admin_comment' => 'nullable|string|max:199',
        'products.*.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",
    ];

    public function mount()
    {
        $this->mountQueryAndPagination();
        $this->per_page_options = collect(OptionDTO::fromItemsArr([5, 10, 20, 50, 100, 200, 500]))
            ->map(fn(OptionDTO $optionDTO) => $optionDTO->toArray())
            ->all();
        $this->setProducts();
        $this->initBrands();
        $this->initAvailabilityStatuses();
        $this->initCurrencies();
    }

    public function render()
    {
        return view('admin.livewire.products-list.products-list', [
            'paginator' => new LengthAwarePaginator(
                $this->products,
                $this->total,
                $this->per_page,
                $this->page
            ),
        ]);
    }

    public function saveSelected()
    {
        $checked = collect($this->products)->filter(fn(array $item) => $item['is_checked'])->all();
        if (empty($checked)) {
            $this->editMode = false;
            $this->selectAll = false;
            return;
        }
        $checkedIds = collect($checked)->pluck('id')->toArray();
        $checkedModels = Product::query()->whereIn('id', $checkedIds)->get();
        $checkedModels->each(function(Product $product) use($checked) {
            $payload = $checked[$product->id] ?? [];
            if (!$payload) {
                return true;
            }
            $product->forceFill(
                collect($payload)
                    ->only(['name', 'ordering', 'is_active', 'unit', 'price_purchase', 'price_purchase_currency_id', 'price_retail', 'price_retail_currency_id', 'admin_comment', 'availability_status_id'])
                    ->all()
            );
            $product->save();
        });
        $this->editMode = false;
        $this->selectAll = false;
        $this->setProducts();
    }

    public function deleteSelected()
    {
        $deleteIds = collect($this->products)->filter(fn(array $item) => $item['is_checked'])->pluck('id')->toArray();
        $deleteProducts = Product::query()->whereIn('id', $deleteIds)->get();
        $deleteProducts->each(function(Product $product) {
            $product->clearMediaCollection(Product::MC_MAIN_IMAGE);
            $product->clearMediaCollection(Product::MC_ADDITIONAL_IMAGES);
            $product->clearMediaCollection(Product::MC_FILES);
            $product->delete();
        });
        $this->editMode = false;
        $this->selectAll = false;
        $this->setProducts();
    }

    public function updatedSelectAll(bool $isChecked)
    {
        $this->products = collect($this->products)->map(function(array $item) use($isChecked) {
            $item['is_checked'] = $isChecked;
            return $item;
        })->all();
    }

    public function setPage($page)
    {
        $this->page = $page;
        $this->setProducts();
    }

    public function handleSearch()
    {
        $this->setProducts();
    }

    public function clearAllFilters()
    {
        $this->search = '';
        $this->category_id = '';
        $this->brand_id = '';
        $this->setProducts();
    }

    public function clearCategoryFilter()
    {
        $this->category_id = '';
        $this->setProducts();
    }

    public function clearBrandFilter()
    {
        $this->brand_id = '';
        $this->setProducts();
    }

    protected function mountQueryAndPagination()
    {
        $request = request();

        $this->category_id = $request->input('category_id');
        $this->brand_id = $request->input('brand_id');
        $this->search = $request->input('search', '');
        $this->per_page = $request->input('per_page', static::DEFAULT_PER_PAGE);

        $this->request_query = $request->query();
    }

    protected function setProducts()
    {
        $query = Product::query()->select(["*"])->notVariations();
        $table = Product::TABLE;

        if ($this->category_id) {
            $category = Category::query()->findOrFail($this->category_id);
            $this->category_name = $category->name;
            $query->where("$table.category_id", $this->category_id);
        }

        if ($this->brand_id) {
            $brand = Brand::query()->findOrFail($this->brand_id);
            $this->brand_name = $brand->name;
            $query->where("$table.brand_id", $this->brand_id);
        }

        if ($this->search) {
            $query->where("$table.name", "LIKE", "%{$this->search}%");
        }

        $copyQuery = clone $query;
        $products = $query->paginate($this->per_page);

        if ($products->lastPage() < $this->page) {
            $this->page = 1;
            $products = $copyQuery->paginate($this->per_page);
        }

        if ($this->request_query) {
            $products->appends($this->request_query);
        }

        $this->total = $products->total();
        $this->last_page = $products->lastPage();

        $this->products = collect($products->items())->map(fn(Product $product) => ProductItemAdminDTO::fromModel($product)->toArray())->keyBy('id')->all();
    }

    public function getAnyProductCheckedProperty(): bool
    {
        return collect($this->products)->contains('is_checked', true);;
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->selectAll = false;
        $this->setProducts();
    }

    public function toggleActive($id)
    {
        $product = Product::query()->find($id);
        if (!$product) {
            return;
        }

        $product->is_active = !$product->is_active;
        $product->save();
        $this->products[$product->id] = ProductItemAdminDTO::fromModel($product)->toArray();
    }

    public function handleDelete($id)
    {
        $product = Product::query()->find($id);
        if (!$product) {
            return;
        }
        $product->clearMediaCollection(Product::MC_MAIN_IMAGE);
        $product->clearMediaCollection(Product::MC_ADDITIONAL_IMAGES);
        $product->clearMediaCollection(Product::MC_FILES);
        $product->delete();
        $this->setProducts();
    }
}

<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Products\DTOs\ProductItemAdminDTO;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination;

    protected const DEFAULT_PER_PAGE = 20;

    public $search = '';

    public $category_id = '';

    public $category_name = '';

    public $brand_id = '';

    public $brand_name = '';

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand}
     */
    public array $brands;

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'per_page' => ['except' => self::DEFAULT_PER_PAGE],
        'category_id' => ['except' => ''],
        'brand_id' => ['except' => ''],
    ];

    public $total = 0;

    public $per_page = self::DEFAULT_PER_PAGE;

    public $request_query;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO[]}
     */
    public $per_page_options = [];

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\ProductItemAdminDTO[]}
     */
    protected array $paginatedProducts = [];

    public function mount()
    {
        $this->mountQueryAndPagination();
        $this->per_page_options = collect(
            OptionDTO::fromPerPageArr([5, 10, 20, 50, 100, 200, 500])
        )->map(fn(OptionDTO $optionDTO) => $optionDTO->toArray())->all();
        $this->setPaginatedProducts();
        $this->brands = Brand::query()->select(["id", "name"])->get()->map(fn(Brand $brand) => OptionDTO::fromBrand($brand)->toArray())->toArray();
    }

    public function render()
    {
        return view('admin.livewire.products-list.products-list', [
            'products' => new LengthAwarePaginator(
                $this->paginatedProducts,
                $this->total,
                $this->per_page,
                $this->page
            ),
        ]);
    }

    public function handleSearch()
    {
        $this->setPaginatedProducts();
    }

    public function clearAllFilters()
    {
        $this->search = '';
        $this->category_id = '';
        $this->brand_id = '';
        $this->setPaginatedProducts();
    }

    public function clearCategoryFilter()
    {
        $this->category_id = '';
        $this->setPaginatedProducts();
    }

    public function clearBrandFilter()
    {
        $this->brand_id = '';
        $this->setPaginatedProducts();
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

    protected function setPaginatedProducts()
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

        $products = $query->paginate($this->per_page);
        if ($this->request_query) $products->appends($this->request_query);

        $this->total = $products->total();
        $this->page = $products->currentPage();

        $this->paginatedProducts = collect($products->items())->map(fn(Product $product) => ProductItemAdminDTO::fromModel($product)->toArray())->keyBy('id')->all();
    }
}

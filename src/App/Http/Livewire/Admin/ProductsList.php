<?php

namespace App\Http\Livewire\Admin;

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

    public $search = '';

    public $category_id = '';

    public $category_name = '';

    public $brand_id = '';

    public $brand_name = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1],
        'category_id' => ['except' => ''],
        'brand_id' => ['except' => ''],
    ];

    protected $prTotal;

    protected $prPerPage;


    /**
     * @var array[] @see {@link \Domain\Products\DTOs\ProductItemAdminDTO[]}
     */
    protected array $tempProducts = [];

    public function mount()
    {
        $query = Product::query()->select(["*"])->notVariations();
        $table = Product::TABLE;

        $request = request();

        $categoryId = $request->input('category_id');
        $brandId = $request->input('brand_id');
        $search = $request->input('search', '');
        $this->prPerPage = $request->input('per_page', 20);

        if ($categoryId) {
            $this->category_id = $categoryId;
            $category = Category::query()->findOrFail($categoryId);
            $this->category_name = $category->name;
            $query->where("$table.category_id", $categoryId);
        }

        if ($brandId) {
            $this->brand_id = $brandId;
            $brand = Brand::query()->findOrFail($brandId);
            $this->brand_name = $brand->name;
            $query->where("$table.brand_id", $brandId);
        }

        if ($search) {
            $query->where("$table.name", "LIKE", "%{$search}%");
        }

        $products = $query->paginate($this->prPerPage);
        $products->appends($request->query());

        $this->tempProducts = collect($products->items())->map(fn(Product $product) => ProductItemAdminDTO::fromModel($product)->toArray())->keyBy('id')->all();
        $this->prTotal = $products->total();
        $this->page = $products->currentPage();
    }

    public function render()
    {
        return view('admin.livewire.products-list.products-list', [
            'products' => new LengthAwarePaginator($this->tempProducts, $this->prTotal, $this->prPerPage, $this->page),
        ]);
    }

    public function handleSearch()
    {

    }

    public function clearAllFilters()
    {

    }

    public function clearCategoryFilter()
    {

    }

    public function clearBrandFilter()
    {

    }
}

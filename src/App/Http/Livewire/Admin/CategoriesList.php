<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\SearchPrependAdminDTO;
use Domain\Products\DTOs\CategoryItemAdminDTO;
use Domain\Products\Models\Category;
use Livewire\Component;

class CategoriesList extends Component
{
    protected const ALL_CATEGORIES_QUERY = "all";

    public $search = '';

    public $category_id = '';

    public $category_name = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'category_id' => ['except' => ''],
    ];

    public $editMode = false;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\CategoryItemAdminDTO}
     */
    public array $categories = [];

    public $selectAll = false;

    protected array $rules = [
        'categories.*.name' => 'required|string|max:199',
        'products.*.ordering' => 'integer|nullable',
        'products.*.is_active' => 'nullable|boolean',
    ];

    public function mount()
    {
        $this->mountRequest();
        $this->setItems();
    }

    public function render()
    {
        return view('admin.livewire.categories-list.categories-list');
    }

    public function setItems()
    {
        $query = Category::query()->select(["*"]);

        if ($this->category_id === static::ALL_CATEGORIES_QUERY) {
            $this->category_name = '';
        } else if ($this->category_id) {
            $parentCategory = Category::query()->findOrFail($this->category_id);
            $this->category_name = $parentCategory->name;
            $query->where(Category::TABLE . ".parent_id", $this->category_id);
        } else {
            $query->parents();
            $this->category_name = 'Раздел: Верхний уровень';
        }

        if ($this->search) {
            $query->where(Category::TABLE . ".name", "LIKE", "%{$this->search}%");
        }

        $this->categories = $query->get()->map(fn(Category $category) => CategoryItemAdminDTO::fromModel($category)->toArray())->keyBy('id')->all();
    }

    public function handleSearch()
    {
        $this->setItems();
    }

    public function clearAllFilters()
    {
        $this->search = '';
        $this->category_id = '';
        $this->setItems();
    }

    public function clearCategoryFilter()
    {
        $this->category_id = '';
        $this->setItems();
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->selectAll = false;
        $this->setItems();
    }

    /**
     * @return array[] @see {@link \Domain\Common\DTOs\SearchPrependAdminDTO}
     */
    public function getPrepends(): array
    {
        $prepends = [];
        if ($this->category_id && $this->category_id !== static::ALL_CATEGORIES_QUERY) {
            $prepends[] = (new SearchPrependAdminDTO([
                'label' => $this->category_name,
                /** @see \App\Http\Livewire\Admin\ProductsList::clearCategoryFilter() */
                'onClear' => 'clearCategoryFilter',
            ]))->toArray();
        }

        return $prepends;
    }

    protected function mountRequest()
    {
        $request = request();

        $this->category_id = $request->input('category_id');
        $this->search = $request->input('search', '');
    }
}

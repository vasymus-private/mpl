<?php

namespace App\Http\Livewire\Admin;

use App\Rules\CategoryDeactivatable;
use Domain\Common\DTOs\SearchPrependAdminDTO;
use Domain\Products\Actions\DeleteCategoryAction;
use Domain\Products\DTOs\CategoryItemAdminDTO;
use Domain\Products\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Validation\Rules\Password;

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

    protected function rules(): array
    {
        return [
            'categories.*.name' => 'required|string|max:199',
            'categories.*.ordering' => 'integer|nullable',
            'categories.*.is_active' => [
                'nullable',
                'boolean',
                new CategoryDeactivatable()
            ],
        ];
    }

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
        $query = Category::query()->select(["*"])->with('subcategories');

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
        $this->category_id = static::ALL_CATEGORIES_QUERY;
        $this->setItems();
    }

    public function cancelEdit()
    {
        $this->editMode = false;
        $this->selectAll = false;
        $this->setItems();
    }

    public function toggleActive($id)
    {
        if (isset($this->categories[$id])) {
            $this->categories[$id]['is_active'] = !$this->categories[$id]['is_active'];
            try {
                $this->validateOnly("categories.*.is_active");
            } catch (ValidationException $exc) {
                $this->categories[$id]['is_active'] = !$this->categories[$id]['is_active'];
                throw $exc;
            }

            /** @var \Domain\Products\Models\Category $category */
            $category = Category::query()->findOrFail($id);
            $category->is_active = !$category->is_active;
            $category->save();

            $this->categories[$id] = CategoryItemAdminDTO::fromModel($category)->toArray();
        }
    }

    /**
     * @return array[] @see {@link \Domain\Common\DTOs\SearchPrependAdminDTO}
     */
    public function getPrepends(): array
    {
        $prepends = [];
        if (!$this->category_id || $this->category_id !== static::ALL_CATEGORIES_QUERY) {
            $prepends[] = (new SearchPrependAdminDTO([
                'label' => $this->category_name,
                /** @see \App\Http\Livewire\Admin\ProductsList::clearCategoryFilter() */
                'onClear' => 'clearCategoryFilter',
            ]))->toArray();
        }

        return $prepends;
    }

    public function saveSelected()
    {
        $this->validate();

        $ids = collect($this->categories)->pluck('id')->values()->toArray();
        $categories = Category::query()->whereIn(Category::TABLE . '.id', $ids)->get();
        $categories->each(function(Category $category) {
            $payload = $this->categories[$category->id] ?? [];
            $category->forceFill(collect($payload)->only($this->getUpdateKeys())->toArray());
            $category->save();
        });

        $this->cancelEdit();
    }

    public function handleDelete($id)
    {
        /** @var \Domain\Products\Models\Category $category */
        $category = Category::query()->findOrFail($id);
        if ($category->has_active_products) {
            return false;
        }
        /** @var \Domain\Products\Actions\DeleteCategoryAction $deleteCategoryAction */
        $deleteCategoryAction = resolve(DeleteCategoryAction::class);
        $deleteCategoryAction->execute($category);
        $this->setItems();
    }

    public function deleteSelected()
    {
        $selectedIds = collect($this->categories)->filter(fn(array $item) => $item['is_checked'])->pluck('id')->values()->toArray();
        if (empty($selectedIds)) {
            return true;
        }
        $categories = Category::query()->whereIn(Category::TABLE . ".id", $selectedIds)->get();

        if ($categories->contains(fn(Category $category) => $category->has_active_products)) {
            return false;
        }
        $categories->each(function(Category $category) {
            /** @var \Domain\Products\Actions\DeleteCategoryAction $deleteCategoryAction */
            $deleteCategoryAction = resolve(DeleteCategoryAction::class);
            $deleteCategoryAction->execute($category);
        });
        $this->setItems();
    }

    public function navigate($categoryId)
    {
        $category = $this->categories[$categoryId] ?? null;
        if (!$category) {
            return null;
        }
        if ($category['hasSubcategories']) {
            $this->category_id = $category['id'];
            $this->handleSearch();
        } else {
            return redirect()->route('admin.products.index', ['category_id' => $category['id']]);
        }
    }

    protected function getUpdateKeys(): array
    {
        return [
            'name',
            'ordering',
            'is_active',
        ];
    }

    protected function mountRequest()
    {
        $request = request();

        $this->category_id = $request->input('category_id');
        $this->search = $request->input('search', '');
    }
}

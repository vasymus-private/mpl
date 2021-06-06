<?php

namespace App\Http\Livewire\Admin;

use App\Rules\CategoryDeactivatable;
use Domain\Products\Actions\DeleteCategoryAction;
use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\DTOs\CategoryProductItemAdminDTO;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class ShowCategory extends Component
{
    use HasTabs;
    use HasSeo;
    use HasCategories;
    use HasGenerateSlug;

    protected const DEFAULT_TAB = 'elements';

    /**
     * @var \Domain\Products\Models\Category
     */
    public Category $item;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\CategoryProductItemAdminDTO}
     */
    public array $products = [];

    /**
     * @var bool
     */
    public bool $generateSlugSyncMode = false;

    /**
     * @var string[]
     */
    public array $tabs = [
        'elements' => 'Элемент',
        'seo' => 'SEO',
        'products' => 'Товары',
    ];

    /**
     * @return string[]|array[]
     */
    protected function rules(): array
    {
        $notIn = [];
        if ($this->item->id) {
            $notIn = GetCategoryAndSubtreeIdsAction::cached()->execute($this->item->id);
        }

        return array_merge(
            $this->getSeoRules(),
            [
                'item.name' => 'required|string|max:199',
                'item.slug' => [
                    'required',
                    'string',
                    'max:199',
                    (new Unique(Category::TABLE, 'slug'))
                        ->when(!!$this->item->id, function(Unique $unique) {
                            return $unique->ignore($this->item->id);
                        }),
                ],
                'item.ordering' => 'integer|nullable',
                'item.is_active' => [
                    'nullable',
                    'boolean',
                    ($this->item->id ? new CategoryDeactivatable() : 'nullable'),
                ],
                'item.parent_id' => [
                    'nullable',
                    (new Exists(Category::TABLE, 'id'))
                        ->when(!empty($notIn), function(Exists $exists) use($notIn) {
                            return $exists->whereNotIn('id', $notIn);
                        }),
                ],
                'item.description' => 'nullable|max:65000',
            ]
        );
    }

    protected $messages = [
        'item.parent_id.exists' => 'У родительской категорией не может быть сама категория или её подкатегории.',
    ];

    public function mount()
    {
        $this->initTabs();
        $this->initSeo();

        $exclude = [];
        if ($this->item->id) {
            $exclude = GetCategoryAndSubtreeIdsAction::cached()->execute($this->item->id);
        }
        $this->initCategories($exclude);
        $this->initGenerateSlug();

        $this->products = $this->item
            ->products()
            ->select(['id', 'name', 'is_active', 'category_id'])
            ->get()
            ->map(fn(Product $product) => CategoryProductItemAdminDTO::fromModel($product)->toArray())
            ->all();
    }

    public function render()
    {
        return view('admin.livewire.show-category.show-category');
    }

    public function save()
    {
        $this->validate();

        $shouldRedirect = false;
        if (!$this->item->id) {
            $shouldRedirect = true;
        }
        $this->saveItem();
        $this->saveSeo();

        if ($shouldRedirect) {
            return redirect()->route('admin.categories.edit', $this->item->id);
        }
    }

    public function deleteItem()
    {
        if ($this->item->has_active_products) {
            $this->addError('delete', sprintf('Категория с id %s не может быть удалена, пока у этой категории и или у её подкатегорий есть активные продукты.', $this->item->id));
            return false;
        }
        $parentId = $this->item->parent_id;
        DeleteCategoryAction::cached()->execute($this->item);
        return redirect()->route('admin.categories.index', ['category_id' => $parentId]);
    }

    public function clearValidationErrors()
    {
        $this->clearValidation();
    }

    public function updatedItemName()
    {
        $this->handleGenerateSlug();
    }

    protected function saveItem()
    {
        $this->item->save();
    }
}

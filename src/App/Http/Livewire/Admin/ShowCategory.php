<?php

namespace App\Http\Livewire\Admin;

use App\Rules\CategoryDeactivatable;
use Domain\Common\DTOs\OptionDTO;
use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\Models\Category;
use Domain\Seo\Models\Seo;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;

class ShowCategory extends Component
{
    /**
     * @var \Domain\Products\Models\Category
     */
    public Category $category;

    /**
     * @var \Domain\Seo\Models\Seo
     */
    public Seo $seo;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category}
     * */
    public array $categories;

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
    ];

    protected function rules(): array
    {
        /** @var \Domain\Products\Actions\GetCategoryAndSubtreeIdsAction $getCategoryAndSubtreeIdsAction */
        $getCategoryAndSubtreeIdsAction = resolve(GetCategoryAndSubtreeIdsAction::class);
        $notIn = [];
        if ($this->category->id) {
            $notIn = $getCategoryAndSubtreeIdsAction->execute($this->category->id);
        }
        return [
            'category.name' => 'required|string|max:199',
            'category.slug' => [
                'required',
                'string',
                'max:199',
                (new Unique(Category::TABLE, 'slug'))
                    ->when(!!$this->category->id, function(Unique $unique) {
                        return $unique->ignore($this->category->id);
                    }),
            ],
            'category.ordering' => 'integer|nullable',
            'category.is_active' => [
                'nullable',
                'boolean',
                new CategoryDeactivatable(),
            ],
            'category.parent_id' => [
                'nullable',
                (new Exists(Category::TABLE, 'id'))
                    ->when(!empty($notIn), function(Exists $exists) use($notIn) {
                        return $exists->whereNotIn('id', $notIn);
                    }),
            ],
            'seo.title' => 'nullable|max:199',
            'seo.h1' => 'nullable|max:199',
            'seo.keywords' => 'nullable|max:65000',
            'seo.description' => 'nullable|max:65000',
        ];
    }

    protected $messages = [
        'category.parent_id.exists' => 'У категории родительской не может быть сама категория или её подкатегории.',
    ];

    public function mount()
    {
        $this->seo = $this->category->seo ?: new Seo();
        $this->categories = Category::getTreeRuntimeCached()->reduce(function (array $acc, Category $category) {
            return $this->categoryToOption($acc, $category, 1);
        }, []);
    }

    public function render()
    {
        return view('admin.livewire.show-category.show-category');
    }

    public function save()
    {
        $this->validate();

        $shouldRedirect = false;
        if (!$this->category->id) {
            $shouldRedirect = true;
        }
        $this->saveItem();
        $this->saveSeo();

        if ($shouldRedirect) {
            return redirect()->route('admin.category.edit', $this->category->id);
        }
    }

    protected function categoryToOption(array $acc, Category $category, int $level = 1): array
    {
        $acc[] = OptionDTO::fromCategory($category, $level)->toArray();
        if ($category->relationLoaded('subcategories')) {
            foreach ($category->subcategories as $subcategory) {
                $acc = $this->categoryToOption($acc, $subcategory, $level + 1);
            }
        }
        return $acc;
    }

    public function updatedCategoryName()
    {
        $this->handleGenerateSlug();
    }

    public function toggleGenerateSlugMode()
    {
        $this->generateSlugSyncMode = !$this->generateSlugSyncMode;
        $this->handleGenerateSlug();
    }

    public function handleGenerateSlug()
    {
        if ($this->generateSlugSyncMode) {
            $this->generateSlug();
        }
    }

    protected function generateSlug()
    {
        $this->category->slug = Str::slug($this->category->name);
    }

    protected function saveItem()
    {
        $this->category->save();
    }

    protected function saveSeo()
    {
        $this->category->seo()->save($this->seo);
    }
}

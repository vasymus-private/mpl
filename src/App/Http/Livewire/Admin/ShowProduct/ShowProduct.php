<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use App\Http\Livewire\Admin\HasAvailabilityStatuses;
use App\Http\Livewire\Admin\HasBrands;
use App\Http\Livewire\Admin\HasCategories;
use App\Http\Livewire\Admin\HasCurrencies;
use App\Http\Livewire\Admin\HasTabs;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Livewire\WithFileUploads;

// TODO not finished refactoring and moving to tab traits
class ShowProduct extends BaseShowProduct
{
    use WithFileUploads;
    use HasCurrencies;
    use HasAvailabilityStatuses;
    use HasCategories;
    use HasTabs;
    use HasBrands;
    use HasCurrencies;
    use HasAvailabilityStatuses;
    use HasElementsTab;
    use HasCharacteristicsTab;
    use HasPhoto;
    use HasDescription;
    use HasSeoTab;
    use HasVariationsTab;
    use HasProductProductTabs;

    protected const MAX_FILE_SIZE_MB = ShowProductConstants::MAX_FILE_SIZE_MB;

    protected const DEFAULT_TAB = 'elements';

    /**
     * @var int[]
     */
    public array $relatedCategories;

    /**
     * @var string[]
     */
    public array $tabs = [
        'elements' => 'Элемент',
        'description' => 'Описание',
        'photo' => 'Фото',
        'characteristics' => 'Характеристики',
        'seo' => 'SEO',
        'accessories' => 'Аксессуары',
        'similar' => 'Похожие',
        'related' => 'Сопряжённые',
        'works' => 'Работы',
        'instruments' => 'Инструменты',
        'variations' => 'Варианты',
        'other' => 'Прочее',
    ];

    /**
     * @return array
     */
    protected function queryString(): array
    {
        return array_merge(
            $this->getHasShowProductQueryString(),
            $this->getHasTabsQueryString(),
            []
        );
    }

    /**
     * @return string[]|array[]
     */
    protected function rules(): array
    {
        return array_merge(
            $this->getElementsTabRules(),
            $this->getCharacteristicsTabRules(),
            $this->getPhotoTabRules(),
            $this->getDescriptionTabRules(),
            $this->getSeoTabRules(),
            $this->getProductProductTabsRules(),
            [
                'item.category_id' => 'nullable|integer|exists:' . Category::class . ',id',
            ]
        );
    }

    public function mount()
    {
        $this->initCommonShowProduct();

        $this->initBrandsOptions();
        $this->initCurrenciesOptions();
        $this->initAvailabilityStatusesOptions();
        $this->initCategoriesOptions();

        $this->initHasTabs();

        $this->initItem();

        $this->initElementsTab();
        $this->initCharacteristicsTab();
        $this->initPhotoTab();
        $this->initDescriptionTab();
        $this->initSeoTab();
        $this->initVariationsTab();
        $this->initProductProductTabs();
    }

    public function render()
    {
        return view('admin.livewire.show-product.show-product');
    }

    public function handleSave()
    {
        $this->validate();

        $this->saveProduct();

        $this->saveProductProduct();

        $this->saveRelatedCategories();

        $this->saveSeo();

        if ($this->isCreating) {
            return redirect()->route('admin.products.edit', $this->item->id);
        }
    }

    protected function saveProduct()
    {
        $elementsAttributes = $this->getElementsTabAttributes();
        $descriptionAttributes = $this->getDescriptionTabAttributes();
        $variationsTabAttributes = $this->getVariationsTabAttributes();
        $saveAttributes = [
            'category_id' => $this->item->category_id,
        ];
        $this->item->forceFill(array_merge($elementsAttributes, $descriptionAttributes, $variationsTabAttributes, $saveAttributes));
        $this->item->save();
    }

    protected function saveRelatedCategories()
    {
        $this->item->relatedCategories()->sync($this->relatedCategories);
    }

    protected function initItem()
    {
        $product = $this->item;

        if ($this->isCreatingFromCopy) {
            $originProduct = $this->getOriginProduct();
            $product = $originProduct ?: $product;
        }

        $this->initRelatedCategories($product);
    }

    protected function initRelatedCategories(Product $product)
    {
        $this->relatedCategories = $product->relatedCategories->pluck('id')->toArray();
    }
}

<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use App\Http\Livewire\Admin\HasAvailabilityStatuses;
use App\Http\Livewire\Admin\HasBrands;
use App\Http\Livewire\Admin\HasCategories;
use App\Http\Livewire\Admin\HasCurrencies;
use App\Http\Livewire\Admin\HasTabs;
use Livewire\WithFileUploads;

class ShowProduct extends BaseShowProduct
{
    use WithFileUploads;
    use HasCurrencies;
    use HasAvailabilityStatuses;
    use HasCategories;
    use HasBrands;
    use HasTabs;
    use HasCurrencies;

    use HasElementsTab;
    use HasDescription;
    use HasPhoto;
    use HasCharacteristicsTab;
    use HasSeoTab;
    use HasProductProductTabs;
    use HasVariationsTab;
    use HasOthersTab;

    protected const MAX_FILE_SIZE_MB = ShowProductConstants::MAX_FILE_SIZE_MB;

    protected const DEFAULT_TAB = 'elements';

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
            $this->getDescriptionTabRules(),
            $this->getPhotoTabRules(),
            $this->getCharacteristicsTabRules(),
            $this->getSeoTabRules(),
            $this->getProductProductTabsRules(),
            $this->getOthersTabRules()
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

        $this->initElementsTab();
        $this->initDescriptionTab();
        $this->initPhotoTab();
        $this->initCharacteristicsTab();
        $this->initSeoTab();
        $this->initProductProductTabs();
        $this->initVariationsTab();
        $this->initOthersTab();
    }

    public function render()
    {
        return view('admin.livewire.show-product.show-product');
    }

    public function handleSave()
    {
        $this->validate();

        $this->saveProduct();

        $this->handleSaveElementsTab();
        $this->handleSaveDescriptionTab();
        $this->handleSavePhotoTab();
        $this->handleSaveCharacteristicsTab();
        $this->handleSaveSeoTab();
        $this->handleSaveProductProductTabs();


        $this->saveRelatedCategories();

        if ($this->isCreating) {
            return redirect()->route('admin.products.edit', $this->item->id);
        }
    }

    protected function saveProduct()
    {
        $elementsTabAttributes = $this->getElementsTabAttributes();
        $descriptionTabAttributes = $this->getDescriptionTabAttributes();
        $photoTabAttributes = $this->getPhotoTabAttributes();
        $characteristicsTabAttributes = $this->getCharacteristicsTabAttributes();
        $variationsTabAttributes = $this->getVariationsTabAttributes();
        $othersTabAttributes = $this->getOthersTabAttributes();

        $this->item->forceFill(
            array_merge(
                $elementsTabAttributes,
                $descriptionTabAttributes,
                $photoTabAttributes,
                $characteristicsTabAttributes,
                $variationsTabAttributes,
                $othersTabAttributes
            )
        );
        $this->item->save();
    }
}

<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use App\Constants;
use App\Http\Livewire\Admin\HasAvailabilityStatuses;
use App\Http\Livewire\Admin\HasBrands;
use App\Http\Livewire\Admin\HasCategories;
use App\Http\Livewire\Admin\HasCurrencies;
use App\Http\Livewire\Admin\HasSortableColumns;
use App\Http\Livewire\Admin\HasTabs;
use Domain\Products\Actions\DeleteProductAction;
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
    use HasSortableColumns;

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
            $this->getVariationsTabRules(),
            $this->getOthersTabRules()
        );
    }

    protected function messages(): array
    {
        return array_merge(
            $this->getElementsTabMessages(),
            $this->getDescriptionTabMessages(),
            $this->getPhotoTabMessages(),
            $this->getCharacteristicsTabMessages(),
            $this->getSeoTabMessages(),
            $this->getProductProductTabsMessages(),
            $this->getVariationsTabMessages(),
            $this->getOthersTabMessages()
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

        $this->initProductVariantsAsSortableColumns();
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
        $this->handleSaveVariationsTab();
        $this->handleSaveOthersTab();

        if ($this->isCreating) {
            return redirect()->route(Constants::ROUTE_ADMIN_PRODUCTS_EDIT, $this->item->id);
        }
    }

    public function deleteItem()
    {
        if ($this->isCreating) {
            return;
        }
        $category_id = $this->item->category_id;
        DeleteProductAction::cached()->execute($this->item);

        return redirect()->route(Constants::ROUTE_ADMIN_PRODUCTS_INDEX, compact('category_id'));
    }

    public function updatedItemCategoryId($value)
    {
        $this->pushToRelatedCategory((string)$value);
    }

    protected function saveProduct()
    {
        $elementsTabAttributes = $this->getElementsTabAttributes();
        $descriptionTabAttributes = $this->getDescriptionTabAttributes();
        $photoTabAttributes = $this->getPhotoTabAttributes();
        $characteristicsTabAttributes = $this->getCharacteristicsTabAttributes();
        $productProductTabsAttributes = $this->getProductProductTabsAttributes();
        $variationsTabAttributes = $this->getVariationsTabAttributes();
        $othersTabAttributes = $this->getOthersTabAttributes();

        $this->item->forceFill(
            array_merge(
                $elementsTabAttributes,
                $descriptionTabAttributes,
                $photoTabAttributes,
                $characteristicsTabAttributes,
                $productProductTabsAttributes,
                $variationsTabAttributes,
                $othersTabAttributes
            )
        );
        $this->item->save();
    }

    /**
     * @param int[] $values
     *
     * @return bool
     */
    public function handleCustomizeSortableList(array $values): bool
    {
        return $this->customizeProductVariantsSortableList($values);
    }

    /**
     * @return bool
     */
    public function handleDefaultSortableList(): bool
    {
        return $this->defaultProductVariantsSortableList();
    }
}

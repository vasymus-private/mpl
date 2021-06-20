<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use App\Http\Livewire\Admin\HasAvailabilityStatuses;
use App\Http\Livewire\Admin\HasCategories;
use App\Http\Livewire\Admin\HasCurrencies;
use App\Http\Livewire\Admin\HasSeo;
use App\Http\Livewire\Admin\HasTabs;
use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Actions\DeleteVariationAction;
use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\DTOs\Admin\ProductProductDTO;
use Domain\Products\DTOs\Admin\VariationDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Category;
use Domain\Products\Models\Pivots\ProductProduct;
use Domain\Products\Models\Product\Product;
use Domain\Seo\Models\Seo;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ShowProduct extends Component
{
    use WithFileUploads;
    use HasCurrencies;
    use HasAvailabilityStatuses;
    use HasSeo;
    use HasCategories;
    use HasTabs;
    use HasCommonShowProduct;

    protected const MAX_FILE_SIZE_MB = ShowProductConstants::MAX_FILE_SIZE_MB;

    protected const DEFAULT_TAB = 'elements';

    protected const INIT_LOADED_PRODUCT_PRODUCT = [
        ProductProduct::TYPE_ACCESSORY => [],
        ProductProduct::TYPE_SIMILAR => [],
        ProductProduct::TYPE_RELATED => [],
        ProductProduct::TYPE_WORK => [],
        ProductProduct::TYPE_INSTRUMENT => [],
    ];

    protected const INIT_SEARCH_FOR_PRODUCT_PRODUCT = [
        ProductProduct::TYPE_ACCESSORY => [
            'category_id' => null,
            'product_name' => null,
        ],
        ProductProduct::TYPE_SIMILAR => [
            'category_id' => null,
            'product_name' => null,
        ],
        ProductProduct::TYPE_RELATED => [
            'category_id' => null,
            'product_name' => null,
        ],
        ProductProduct::TYPE_WORK => [
            'category_id' => null,
            'product_name' => null,
        ],
        ProductProduct::TYPE_INSTRUMENT => [
            'category_id' => null,
            'product_name' => null,
        ],
    ];

    protected array $mapTypeToRelationName = [
        /** @see \Domain\Products\Models\Product\Product::accessory() */
        ProductProduct::TYPE_ACCESSORY => 'accessory',

        /** @see \Domain\Products\Models\Product\Product::similar() */
        ProductProduct::TYPE_SIMILAR => 'similar',

        /** @see \Domain\Products\Models\Product\Product::related() */
        ProductProduct::TYPE_RELATED => 'related',

        /** @see \Domain\Products\Models\Product\Product::works() */
        ProductProduct::TYPE_WORK => 'works',

        /** @see \Domain\Products\Models\Product\Product::instruments() */
        ProductProduct::TYPE_INSTRUMENT => 'instruments',
    ];

    /**
     * @var \Domain\Products\Models\Product\Product
     */
    public Product $item;

    /**
     * @var array[][] @see {@link \Domain\Products\DTOs\Admin\ProductProductDTO}
     */
    public array $productProducts = [
        ProductProduct::TYPE_ACCESSORY => [],
        ProductProduct::TYPE_SIMILAR => [],
        ProductProduct::TYPE_RELATED => [],
        ProductProduct::TYPE_WORK => [],
        ProductProduct::TYPE_INSTRUMENT => [],
    ];

    /**
     * @var array[][] @see {@link \Domain\Products\DTOs\Admin\ProductProductDTO}
     */
    public array $loadedForProductProduct = self::INIT_LOADED_PRODUCT_PRODUCT;

    /**
     * @var array[]
     */
    public array $searchForProductProduct = self::INIT_SEARCH_FOR_PRODUCT_PRODUCT;

    /**
     * @var bool
     */
    public bool $is_with_variations;

    /**
     * @var int[]
     */
    public array $relatedCategories;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\Admin\VariationDTO}
     */
    public array $variations;

    /**
     * @var array @see {@link \Domain\Products\DTOs\Admin\VariationDTO}
     */
    public array $currentVariation;

    /**
     * @var bool
     */
    public bool $variationsEditMode = false;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempVariationMainImage;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempVariationAdditionalImage;

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

    public $variationsSelectAll = false;

    /**
     * @var string[]
     */
    protected $listeners = [
        ShowProductConstants::EVENT_HANDLE_REDIRECT => 'handleRedirect',
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

    protected function variationsRules(): array
    {
        return [
            'variations.*.name' => 'required|string|max:199',
            'variations.*.is_active' => 'nullable|boolean',
            'variations.*.ordering' => 'integer|nullable',
            'variations.*.coefficient' => 'nullable|numeric',
            'variations.*.price_purchase' => 'nullable|numeric',
            'variations.*.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
            'variations.*.price_retail' => 'nullable|numeric',
            'variations.*.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
            'variations.*.unit' => 'nullable|string|max:199',
            'variations.*.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",
        ];
    }

    protected function currentVariationRules(): array
    {
        return [
            'currentVariation.name' => 'required|string|max:199',
            'currentVariation.ordering' => 'integer|nullable',
            'currentVariation.is_active' => 'nullable|boolean',
            'currentVariation.coefficient' => 'nullable|numeric',
            'currentVariation.price_purchase' => 'nullable|numeric',
            'currentVariation.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
            'currentVariation.unit' => 'nullable|max:199',
            'currentVariation.price_retail' => 'nullable|numeric',
            'currentVariation.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
            'currentVariation.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",
            'currentVariation.preview' => 'nullable|max:65000',
            'tempVariationMainImage' => 'nullable|max:'  . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb,
            'tempVariationAdditionalImage' => 'nullable|max:'  . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb,
        ];
    }

    /**
     * @return string[]|array[]
     */
    protected function rules(): array
    {
        return array_merge(
            $this->getSeoRules(),
            [
                'item.accessory_name' => 'required|max:199',
                'item.similar_name' => 'required|max:199',
                'item.related_name' => 'required|max:199',
                'item.work_name' => 'required|max:199',
                'item.instruments_name' => 'required|max:199',

                'productProducts.*.*.toDelete' => 'nullable|boolean',
                'loadedForProductProduct.*.*.isSelected' => 'nullable|boolean',

                'searchForProductProduct.*.category_id' => 'nullable|integer|exists:' . Category::class . ',id',
                'searchForProductProduct.*.product_name' => 'nullable',

                'item.category_id' => 'nullable|integer|exists:' . Category::class . ',id',
            ]
        );
    }

    public function mount()
    {
        $this->initCommonShowProduct();

        $this->initCurrenciesOptions();
        $this->initAvailabilityStatusesOptions();
        $this->initCategoriesOptions();

        $this->initHasTabs();

        $this->initItem();
    }

    public function render()
    {
        return view('admin.livewire.show-product.show-product');
    }

    public function handleSave()
    {
        $this->validate();

        $this->emit(ShowProductConstants::EVENT_SAVE_ELEMENTS);
        $this->emit(ShowProductConstants::EVENT_SAVE_DESCRIPTIONS);
        $this->emit(ShowProductConstants::EVENT_SAVE_PHOTO);
        $this->emit(ShowProductConstants::EVENT_SAVE_CHARACTERISTICS);

        $this->saveProduct();

        $this->saveSeo();

        $this->saveProductProduct();

        $this->saveRelatedCategories();

        if ($this->isCreating) {
            $this->emit(ShowProductConstants::EVENT_HANDLE_REDIRECT, true);
        }
    }

    /**
     * @param bool $shouldRedirect
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function handleRedirect(bool $shouldRedirect = false)
    {
        if ($shouldRedirect) {
            return redirect()->route('admin.products.edit', $this->item->id);
        }
    }

    public function saveVariations()
    {
        $this->validate($this->variationsRules());

        $dbVariations = $this->item->variations()->get();
        $dbVariations->each(function (Product $dbVariation) {
            /** @var array|null $variation @see {@link \Domain\Products\DTOs\Admin\VariationDTO} */
            $variation = collect($this->variations)->first(fn(array $var) => (string)$var['id'] === (string)$dbVariation->id);
            if (!$variation) {
                return true;
            }
            $dbVariation->forceFill(collect($variation)->only([
                'name',
                'is_active',
                'ordering',
                'price_purchase',
                'price_purchase_currency_id',
                'unit',
                'coefficient',
                'price_retail',
                'price_retail_currency_id',
                'availability_status_id',
            ])->toArray());
            $dbVariation->save();
        });
        $this->initVariations($this->item);
        $this->handleSetVariationsEditMode(false);
        $this->variationsSelectAll = false;
    }

    public function saveCurrentVariation()
    {
        $this->validate($this->currentVariationRules());

        $currentVariationDto = (new VariationDTO($this->currentVariation));

        $attributes = $currentVariationDto->only(
            'name',
            'ordering',
            'is_active',
            'coefficient',
            'price_purchase',
            'price_purchase_currency_id',
            'unit',
            'price_retail',
            'price_retail_currency_id',
            'availability_status_id',
            'preview'
        )
            ->toArray();
        $attributes = array_merge($attributes, ['parent_id' => $this->item->id]);

        if ($currentVariationDto->id) {
            $product = Product::query()->variations()->findOrFail($currentVariationDto->id);
            $product->forceFill($attributes);
            $product->save();
        } else {
            $product = Product::forceCreate($attributes);
        }

        if (empty($currentVariationDto->main_image)) {
            $mainImageMedia = $product->getFirstMedia(Product::MC_MAIN_IMAGE);
            if ($mainImageMedia) $mainImageMedia->delete();
        }

        if (!empty($currentVariationDto->main_image) && empty($currentVariationDto->main_image['id'])) {
            $this->addMedia(new FileDTO($currentVariationDto->main_image), Product::MC_MAIN_IMAGE, $product);
        }

        $additionalImagesIds = [];
        foreach ($currentVariationDto->additional_images as $additionalImage) {
            if (empty($additionalImage['id'])) {
                $newAdditionalImage = $this->addMedia(new FileDTO($additionalImage), Product::MC_ADDITIONAL_IMAGES, $product);
                $additionalImagesIds[] = $newAdditionalImage->id;
            } else {
                $additionalImagesIds[] = $additionalImage['id'];
            }
        }

        $product->getMedia(Product::MC_ADDITIONAL_IMAGES)->each(function(CustomMedia $media) use($additionalImagesIds) {
            if (!in_array($media->id, $additionalImagesIds)) $media->delete();
        });

        $this->initVariations($this->item);

        return true;
    }

    public function setCurrentVariation(?int $id = null)
    {
        if (!$id) {
            $this->currentVariation = (new VariationDTO())->toArray();
        } else {
            /** @var \Domain\Products\Models\Product\Product $variation */
            $variation = $this->item->variations()->with('media')->findOrFail($id);
            $this->currentVariation = VariationDTO::fromModel($variation)->toArray();
        }
    }

    public function cancelCurrentVariation()
    {
        $this->currentVariation = (new VariationDTO())->toArray();
        $this->tempVariationMainImage = null;
        $this->tempVariationAdditionalImage = null;
    }

    public function toggleVariationActive($id)
    {
        /** @var \Domain\Products\Models\Product\Product|null $variation */
        $variation = $this->item->variations()->find($id);
        if (!$variation) {
            return;
        }

        $variation->is_active = !$variation->is_active;
        $variation->save();
        $this->variations[$id] = VariationDTO::fromModel($variation)->toArray();
    }

    public function deleteVariationMainImage()
    {
        $this->currentVariation['main_image'] = [];
    }

    public function deleteVariationAdditionalImage($index)
    {
        $this->currentVariation['additional_images'] = collect($this->currentVariation['additional_images'])->values()->filter(fn(array $additionalImage, int $key) => (string)$index !== (string)$key)->toArray();
    }

    public function setWithVariations(bool $with)
    {
        $this->is_with_variations = $with;
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = Product::query()->findOrFail($this->item->id);
        $product->is_with_variations = $with;
        $product->save();
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempVariationMainImage(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->currentVariation['main_image'] = $fileDTO->toArray();
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempVariationAdditionalImage(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->currentVariation['additional_images'][] = $fileDTO->toArray();
    }

    public function updatedVariationsSelectAll(bool $value)
    {
        $this->handleCheckAllVariations($value);
    }

    public function handleSetVariationsEditMode(?bool $mode = null)
    {
        $this->variationsEditMode = $mode !== null ? $mode : !$this->variationsEditMode;
    }

    public function handleDeleteSelectedVariations()
    {
        $selectedVariationIds = collect($this->variations)
            ->filter(fn(array $item) => !!$item['is_checked'] && !!$item['id'])
            ->pluck('id')
            ->values()
            ->toArray();
        if (!empty($selectedVariationIds)) {
            $deleteVariations = $this->item->variations()->whereIn('id', $selectedVariationIds)->get();
            $deleteVariations->each(function(Product $variation) {
                DeleteVariationAction::cached()->execute($variation);
            });
        }

        $this->initVariations($this->item);
        $this->handleSetVariationsEditMode(false);
        $this->variationsSelectAll = false;
    }

    public function deleteVariation($id)
    {
        /** @var \Domain\Products\Models\Product\Product|null $variation */
        $variation = $this->item->variations()->find($id);
        if (!$variation) {
            return;
        }
        DeleteVariationAction::cached()->execute($variation);
        $this->variations = collect($this->variations)->filter(fn(array $variation) => (string)$variation['id'] !== (string)$id)->all();
    }

    public function copyVariation($copyId)
    {
        /** @var \Domain\Products\Models\Product\Product|null $original */
        $original = $this->item->variations()->find($copyId);

        if (!$original) {
            return;
        }

        $attributes = collect($original->toArray())->only($this->getCopyVariationAttributes())->toArray();
        $copy = new Product();
        $copy->forceFill($attributes);
        $copy->save();

        /** @var \Domain\Common\Models\CustomMedia|null $mainImageMedia */
        $mainImageMedia = $original->getFirstMedia(Product::MC_MAIN_IMAGE);
        if ($mainImageMedia) {
            $mainImage = FileDTO::fromCustomMedia($mainImageMedia);
            $this->addMedia($mainImage, Product::MC_MAIN_IMAGE, $copy);
        }

        $additionalImages = $original->getMedia(Product::MC_ADDITIONAL_IMAGES);
        foreach ($additionalImages as $additionalImageMedia) {
            $additionalImage = FileDTO::fromCustomMedia($additionalImageMedia);
            $this->addMedia($additionalImage, Product::MC_ADDITIONAL_IMAGES, $copy);
        }

        $this->initVariations($this->item);
    }

    public function handleCancelVariationsEditMode()
    {
        $this->handleSetVariationsEditMode(false);
        $this->initVariations($this->item);
    }

    public function handleCheckAllVariations(bool $isChecked)
    {
        $this->variations = collect($this->variations)->map(function(array $item) use($isChecked) {
            $item['is_checked'] = $isChecked;
            return $item;
        })->all();
    }

    public function loadProductProduct(int $for)
    {
        if (!in_array($for, ProductProduct::ALL_TYPES)) return;

        $filters = $this->searchForProductProduct[$for];
        $category_id = (int)$filters['category_id'];
        $product_name = (string)$filters['product_name'];

        if (!$category_id && !$product_name) return;

        $productQuery = Product::query();

        if ($category_id) {
            /** @var \Domain\Products\Actions\GetCategoryAndSubtreeIdsAction $getCategoryAndSubtreeIdsAction */
            $getCategoryAndSubtreeIdsAction = resolve(GetCategoryAndSubtreeIdsAction::class);
            $categoryAndSubtreeIds = $getCategoryAndSubtreeIdsAction->execute($category_id);

            $productQuery->forMainAndRelatedCategories($categoryAndSubtreeIds);
        }

        if ($product_name) {
            $productQuery->where(Product::TABLE . ".name", "like", "%{$product_name}%");
        }

        $this->loadedForProductProduct[$for] = collect($productQuery->paginate(20)->items())->map(fn(Product $product) => ProductProductDTO::fromModel($product, "loadedForProductProduct.{$for}.{$product->id}.")->toArray())->keyBy('id')->all();
    }

    protected function saveProduct()
    {
        $saveAttributes = [
            'is_with_variations' => (bool)$this->is_with_variations,
            'accessory_name' => $this->item->accessory_name,
            'similar_name' => $this->item->similar_name,
            'related_name' => $this->item->related_name,
            'work_name' => $this->item->work_name,
            'instruments_name' => $this->item->instruments_name,
            'category_id' => $this->item->category_id,
        ];
        /** @var \Domain\Products\Models\Product\Product $item */
        $item = $this->isCreating
            ? new Product()
            : Product::query()->findOrFail($this->item->id);
        $item->forceFill($saveAttributes);
        $item->save();

        $this->item = $item;
    }

    protected function saveProductProduct()
    {
        foreach ($this->mapTypeToRelationName as $type => $relation) {
            $currentIds = collect($this->productProducts[$type])
                ->filter(fn(array $item) => !$item['toDelete'])
                ->pluck('id')
                ->values()
                ->toArray();
            $selectedIds = collect($this->loadedForProductProduct[$type])
                ->filter(fn(array $item) => $item['isSelected'])
                ->pluck('id')
                ->values()
                ->toArray();
            $ids = array_merge($currentIds, $selectedIds);
            $sync = collect($ids)->reduce(function(array $acc, int $id) use($type) {
                $acc[$id] = ["type" => $type];
                return $acc;
            }, []);
            $this->item->{$relation}()->sync($sync);
        }
        $this->initProductProduct($this->item);
        $this->initLoadedForProductProduct();
        $this->initSearchForProductProduct();
    }

    protected function saveRelatedCategories()
    {
        $this->item->relatedCategories()->sync($this->relatedCategories);
    }

    protected function initItem()
    {
        if ($this->isCreatingFromCopy) {
            $copyProduct = $this->getCopyProduct();
            if ($copyProduct !== null) {
                $this->initAsCopiedItem($copyProduct);
                return;
            }
        }

        $this->initSeo();

        $this->initProductProduct($this->item);

        $this->initRelatedCategories($this->item);

        $this->initIsWithVariations($this->item);

        $this->initVariations($this->item);
    }

    protected function initAsCopiedItem(Product $origin)
    {
        // fill item with attributes
        $attributes = collect($origin->toArray())
            ->only($this->getCopyItemAttributes())
            ->toArray();
        $item = new Product();
        $item->forceFill($attributes);
        $this->item = $item;

        // seo
        $seo = $origin->seo ?: new Seo();
        $seo->seoable_id = null;
        $seo->seoable_type = null;
        $this->seo = $seo;

        $this->initProductProduct($origin);

        $this->initRelatedCategories($origin);

        $this->initIsWithVariations($origin);

        $this->initVariations($origin);
    }

    protected function initLoadedForProductProduct()
    {
        $this->loadedForProductProduct = static::INIT_LOADED_PRODUCT_PRODUCT;
    }

    protected function initSearchForProductProduct()
    {
        $this->searchForProductProduct = static::INIT_SEARCH_FOR_PRODUCT_PRODUCT;
    }

    protected function initVariations(Product $product)
    {
        $this->variations = $product->variations()
            ->with('media')
            ->get()
            ->map(
                fn(Product $variation) =>
                    $this->isCreatingFromCopy
                        ? VariationDTO::copyFromModel($variation)->toArray()
                        : VariationDTO::fromModel($variation)->toArray()
            )
            ->keyBy('id')
            ->toArray();
        $this->currentVariation = (new VariationDTO())->toArray();
    }

    protected function initProductProduct(Product $product)
    {
        foreach ($this->mapTypeToRelationName as $type => $relation) {
            $product->load("$relation.media");
            /** @var \Illuminate\Support\Collection $rel */
            $rel = $product->{$relation};
            $this->productProducts[$type] = $rel->map(
                fn(Product $productProduct) => ProductProductDTO::fromModel(
                    $productProduct, "productProducts.{$type}.{$productProduct->id}."
                )->toArray()
            )
                ->keyBy('id')
                ->all();
        }
    }

    /**
     * @return string[]
     */
    protected function getCopyVariationAttributes(): array
    {
        return [
            'name',
            'parent_id',
            'ordering',
            'is_active',
            'coefficient',
            'unit',
            'availability_status_id',
            'price_purchase',
            'price_purchase_currency_id',
            'price_retail',
            'price_retail_currency_id',
            'preview',
        ];
    }

    protected function initRelatedCategories(Product $product)
    {
        $this->relatedCategories = $product->relatedCategories->pluck('id')->toArray();
    }

    protected function initIsWithVariations(Product $product)
    {
        $this->is_with_variations = (bool)$product->is_with_variations;
    }
}

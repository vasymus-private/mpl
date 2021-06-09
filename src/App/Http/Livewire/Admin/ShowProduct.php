<?php

namespace App\Http\Livewire\Admin;

use App\Constants;
use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\DTOs\InformationalPriceDTO;
use Domain\Products\DTOs\ProductProductAdminDTO;
use Domain\Products\DTOs\VariationAdminDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Pivots\ProductProduct;
use Domain\Products\Models\Product\Product;
use Domain\Seo\Models\Seo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Support\H;
use Livewire\WithFileUploads;

class ShowProduct extends Component
{
    use WithFileUploads;
    use HasBrands;
    use HasCurrencies;
    use HasAvailabilityStatuses;
    use HasTabs;
    use HasSeo;
    use HasGenerateSlug;
    use HasCategories;

    protected const MAX_FILE_SIZE_MB = 30;

    protected const DEFAULT_TAB = 'elements';

    protected ?string $currentRouteName = null;

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
     * @var array[] @see {@link \Domain\Products\DTOs\InformationalPriceDTO}
     */
    public array $infoPrices;

    /**
     * @var array|null @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $mainImage = [];

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $additionalImages;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $instructions;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempMainImage;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempAdditionalImage;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempInstruction;

    /**
     * @var array[][] @see {@link \Domain\Products\DTOs\ProductProductAdminDTO}
     */
    public array $productProducts = [
        ProductProduct::TYPE_ACCESSORY => [],
        ProductProduct::TYPE_SIMILAR => [],
        ProductProduct::TYPE_RELATED => [],
        ProductProduct::TYPE_WORK => [],
        ProductProduct::TYPE_INSTRUMENT => [],
    ];

    /**
     * @var array[][] @see {@link \Domain\Products\DTOs\ProductProductAdminDTO}
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
     * @var array[] @see {@link \Domain\Products\DTOs\VariationAdminDTO}
     */
    public array $variations;

    /**
     * @var array @see {@link \Domain\Products\DTOs\VariationAdminDTO}
     */
    public array $currentVariation;

    /**
     * @var bool
     */
    public bool $variationsEditMode = false;

    /**
     * @var bool
     */
    public bool $variationsanyVariationCheckedAll = false;

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

    public $copy_id = '';

    protected $queryString = [
        'copy_id' => ['except' => ''],
    ];

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
                'item.name' => 'required|string|max:199',
                'item.is_active' => 'nullable|boolean',
                'item.slug' => 'nullable|string|max:199',
                'item.ordering' => 'integer|nullable',
                'item.brand_id' => 'integer|nullable|exists:' . Brand::class . ",id",
                'item.coefficient' => 'nullable|numeric',
                'item.coefficient_description' => 'nullable|string|max:199',
                'item.coefficient_description_show' => 'nullable|boolean',
                'item.price_name' => 'nullable|string|max:199',

                'infoPrices.*.price' => 'required|numeric',
                'infoPrices.*.name' => 'required|string|max:199',

                'item.admin_comment' => 'nullable|string|max:199',

                'tempMainImage' => 'nullable|max:'  . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb,
                'tempAdditionalImage' => 'nullable|max:'  . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb,
                'tempInstruction' => 'nullable|max:' . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb

                'mainImage.name' => 'nullable|max:199',
                'additionalImages.*.name' => 'nullable|max:199',
                'instructions.*.name' => 'nullable|max:199',

                'item.price_purchase' => 'nullable|numeric',
                'item.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
                'item.price_retail' => 'nullable|numeric',
                'item.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',

                'item.unit' => 'nullable|string|max:199',
                'item.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",

                'item.preview' => 'nullable|max:65000',
                'item.description' => 'nullable|max:65000',

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
        $this->currentRouteName = Route::currentRouteName();
        $this->initBrandsOptions();
        $this->initCurrenciesOptions();
        $this->initAvailabilityStatusesOptions();
        $this->initCategoriesOptions();

        $this->initTabs();

        $this->initGenerateSlug();

        $this->initItem();

        dd($this);
    }

    public function render()
    {
        return view('admin.livewire.show-product.show-product');
    }

    public function save()
    {
        $this->validate();

        $shouldRedirect = false;
        if (!$this->item->id) {
            $shouldRedirect = true;
        }

        $this->saveProduct();

        $this->saveInfoPrices();

        $this->saveMainImage();

        $this->saveAdditionalImages();

        $this->saveInstructions();

        $this->saveSeo();

        $this->saveProductProduct();

        $this->saveRelatedCategories();

        if ($this->isCreatingFromCopy()) {
            // TODO save variations
            // $this->saveVariations();
        }

        if ($shouldRedirect) {
            return redirect()->route('admin.products.edit', $this->item->id);
        }
    }

    public function saveVariations()
    {
        $this->validate($this->variationsRules());

        $dbVariations = $this->item->variations()->get();
        $dbVariations->each(function (Product $dbVariation) {
            /** @var array|null $variation @see {@link \Domain\Products\DTOs\VariationAdminDTO} */
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

        $currentVariationDto = (new VariationAdminDTO($this->currentVariation));

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

        if (!empty($currentVariationDto->main_image)) {
            $this->addMedia(new FileDTO($currentVariationDto->main_image), Product::MC_MAIN_IMAGE, $product);
        } else {
            $mainImageMedia = $product->getFirstMedia(Product::MC_MAIN_IMAGE);
            if ($mainImageMedia) $mainImageMedia->delete();
        }

        foreach ($currentVariationDto->additional_images as $additionalImage) {
            $this->addMedia(new FileDTO($additionalImage), Product::MC_ADDITIONAL_IMAGES, $product);
        }

        $additionalImageIds = collect($this->currentVariation['additional_images'])->pluck('id')->toArray();
        $product->getMedia(Product::MC_ADDITIONAL_IMAGES)->each(function(CustomMedia $media) use($additionalImageIds) {
            if (!in_array($media->id, $additionalImageIds)) $media->delete();
        });

        $this->initVariations($this->item);

        return true;
    }

    public function setCurrentVariation(?int $id = null)
    {
        if (!$id) {
            $this->currentVariation = (new VariationAdminDTO())->toArray();
        } else {
            /** @var \Domain\Products\Models\Product\Product $variation */
            $variation = $this->item->variations()->with('media')->findOrFail($id);
            $this->currentVariation = VariationAdminDTO::fromModel($variation)->toArray();
        }
    }

    public function cancelCurrentVariation()
    {
        $this->currentVariation = (new VariationAdminDTO())->toArray();
        $this->tempVariationMainImage = null;
        $this->tempVariationAdditionalImage = null;
    }

    public function addInfoPrice()
    {
        $infoPriceDTO = InformationalPriceDTO::create();
        $this->infoPrices[$infoPriceDTO->temp_uuid] = $infoPriceDTO->toArray();
    }

    public function deleteInfoPrice($uuid)
    {
        $infoPrice = $this->infoPrices[$uuid] ?? null;
        if (!$infoPrice) {
            return;
        }

        unset($this->infoPrices[$uuid]);
    }

    public function deleteMainImage()
    {
        $this->mainImage = [];
    }

    public function deleteAdditionalImage($index)
    {
        $this->additionalImages = collect($this->additionalImages)->values()->filter(fn(array $additinalImage, int $key) => (string)$index !== (string)$key)->toArray();
    }

    public function deleteVariationMainImage()
    {
        $this->currentVariation['main_image'] = [];
    }

    public function deleteVariationAdditionalImage($index)
    {
        $this->currentVariation['additional_images'] = collect($this->currentVariation['additional_images'])->values()->filter(fn(array $additinalImage, int $key) => (string)$index !== (string)$key)->toArray();
    }

    public function deleteInstruction($index)
    {
        $this->instructions = collect($this->instructions)->values()->filter(fn(array $instruction, int $key) => (string)$index !== (string)$key)->toArray();
    }

    public function setWithVariations(bool $with)
    {
        $this->is_with_variations = $with;
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = Product::query()->findOrFail($this->item->id);
        $product->is_with_variations = $with;
        $product->save();
    }

    public function updatedItemName()
    {
        $this->handleGenerateSlug();
    }

    /**
     * @param mixed $name
     * @param mixed $value
     *
     * @see {@link https://github.com/livewire/livewire/issues/823#issuecomment-751321838}
     */
    public function updated($name, $value)
    {
        data_set($this, $name, H::trimAndNullEmptyString($value)); // trim only left side
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempMainImage(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->mainImage = $fileDTO->toArray();
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempAdditionalImage(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->additionalImages[] = $fileDTO->toArray();
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

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempInstruction(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->instructions[] = $fileDTO->toArray();
    }

    public function updatedVariationsSelectAll(bool $value)
    {
        $this->handleCheckAllVariations($value);
    }

    public function getAnyVariationCheckedProperty(): bool
    {
        return collect($this->variations)->contains('is_checked', true);
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
            $this->item->variations()->whereIn('id', $selectedVariationIds)->delete();
        }

        $this->initVariations($this->item);
        $this->handleSetVariationsEditMode(false);
        $this->variationsSelectAll = false;
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

        $this->loadedForProductProduct[$for] = collect($productQuery->paginate(20)->items())->map(fn(Product $product) => ProductProductAdminDTO::fromModel($product, "loadedForProductProduct.{$for}.{$product->id}.")->toArray())->keyBy('id')->all();
    }

    protected function saveProduct()
    {
        $this->item->save();
    }

    protected function saveInfoPrices()
    {
        foreach ($this->infoPrices as $infoPrice) {
            /** @var \Domain\Products\Models\InformationalPrice $infoPriceModel */
            $infoPriceModel = InformationalPrice::query()->findOrNew($infoPrice['id']);
            $infoPriceDto = InformationalPriceDTO::create($infoPrice);
            $infoPriceModel->name = $infoPriceDto->name;
            $infoPriceModel->price = $infoPriceDto->price;
            $infoPriceModel->product_id = $this->item->id;
            $infoPriceModel->save();
        }
    }

    protected function saveMainImage()
    {
        if (!$this->mainImage) {
            /** @var CustomMedia|null $media */
            $media = $this->item->getFirstMedia(Product::MC_MAIN_IMAGE);
            if ($media) $media->delete();
            return;
        }

        if ($this->mainImage['id'] !== null && !$this->isCreatingFromCopy()) {
            /** @var CustomMedia|null $media */
            $media = $this->item->getFirstMedia(Product::MC_MAIN_IMAGE);
            if ($media) {
                $media->name = $this->mainImage['name'];
                $media->save();
            }
        } else {
            $mainImage = new FileDTO($this->mainImage);
            $this->addMedia($mainImage, Product::MC_MAIN_IMAGE);
        }
    }

    protected function saveAdditionalImages()
    {
        $additionalImages = [];

        foreach ($this->additionalImages as $additionalImage) {
            if ($additionalImage['id'] !== null && !$this->isCreatingFromCopy()) {
                /** @var \Domain\Common\Models\CustomMedia $media */
                $media = $this->item->getMedia(Product::MC_ADDITIONAL_IMAGES)->first(fn(CustomMedia $media) => $additionalImage['id'] === $media->id);
                $media->name = $additionalImage['name'] ?: $additionalImage['file_name'];
                $media->save();
                $additionalImages[] = $additionalImage;
            } else {
                $media = $this->addMedia(new FileDTO($additionalImage), Product::MC_ADDITIONAL_IMAGES);
                $additionalImages[] = FileDTO::fromCustomMedia($media)->toArray();
            }
        }

        $additionalImagesIds = collect($additionalImages)->pluck("id")->toArray();
        $this->item->getMedia(Product::MC_ADDITIONAL_IMAGES)->each(function(CustomMedia $media) use($additionalImagesIds) {
            if (!in_array($media->id, $additionalImagesIds)) $media->delete();
        });
        $this->additionalImages = $additionalImages;
    }

    protected function saveInstructions()
    {
        $instructions = [];

        foreach ($this->instructions as $instruction) {
            if ($instruction['id'] !== null && !$this->isCreatingFromCopy()) {
                /** @var \Domain\Common\Models\CustomMedia $media */
                $media = $this->item->getMedia(Product::MC_FILES)->first(fn(CustomMedia $media) => $instruction['id'] === $media->id);
                $media->name = $instruction['name'] ?: $instruction['file_name'];
                $media->save();
                $instructions[] = $instruction;
            } else {
                $media = $this->addMedia(new FileDTO($instruction), Product::MC_FILES);
                $instructions[] = FileDTO::fromCustomMedia($media)->toArray();
            }
        }

        $instructionsIds = collect($instructions)->pluck("id")->toArray();
        $this->item->getMedia(Product::MC_FILES)->each(function(CustomMedia $media) use($instructionsIds) {
            if (!in_array($media->id, $instructionsIds)) $media->delete();
        });
        $this->instructions = $instructions;
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

    protected function addMedia(FileDTO $fileDTO, string $collectionName, ?Product $for = null): CustomMedia
    {
        $for = $for ?: $this->item;
        $fileAdder = $for
            ->addMedia($fileDTO->path)
            ->preservingOriginal()
            ->usingFileName($fileDTO->file_name)
            ->usingName($fileDTO->name ?? $fileDTO->file_name)
        ;
        /** @var \Domain\Common\Models\CustomMedia $customMedia */
        $customMedia = $fileAdder->toMediaCollection($collectionName);
        return $customMedia;
    }

    protected function initItem()
    {
        if ($this->isCreatingFromCopy()) {
            $copyProduct = $this->getCopyProduct();
            if ($copyProduct !== null) {
                $this->initAsCopiedItem($copyProduct);
                return;
            }
        }

        $this->initSeo();

        $this->initInfoPrices($this->item);

        $this->initInstructions($this->item);

        $this->initImages($this->item);

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

        $this->initInfoPrices($origin);

        $this->initInstructions($origin);

        $this->initImages($origin);

        $this->initProductProduct($origin);

        $this->initRelatedCategories($origin);

        $this->initIsWithVariations($origin);

        $this->initVariations($origin);
    }

    protected function initProductProduct(Product $product)
    {
        foreach ($this->mapTypeToRelationName as $type => $relation) {
            $product->load("$relation.media");
            /** @var \Illuminate\Support\Collection $rel */
            $rel = $product->{$relation};
            $this->productProducts[$type] = $rel->map(
                fn(Product $productProduct) => ProductProductAdminDTO::fromModel(
                    $productProduct, "productProducts.{$type}.{$productProduct->id}."
                )->toArray()
            )
                ->keyBy('id')
                ->all();
        }
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
            ->map(fn(Product $variation) => VariationAdminDTO::fromModel($variation)->toArray())
            ->keyBy('id')
            ->toArray();
        $this->currentVariation = (new VariationAdminDTO())->toArray();
    }

    protected function initInfoPrices(Product $product)
    {
        $this->infoPrices = $product->infoPrices->map(fn(InformationalPrice $informationalPrice) => InformationalPriceDTO::fromModel($informationalPrice)->toArray())->keyBy('temp_uuid')->toArray();
    }

    protected function initInstructions(Product $product)
    {
        $this->instructions = $product->getMedia(Product::MC_FILES)->map(fn(CustomMedia $media) => FileDTO::fromCustomMedia($media)->toArray())->toArray();
    }

    protected function initImages(Product $product)
    {
        /** @var \Domain\Common\Models\CustomMedia $mainImageMedia */
        $mainImageMedia = $product->getFirstMedia(Product::MC_MAIN_IMAGE);
        $this->mainImage = $mainImageMedia ? FileDTO::fromCustomMedia($mainImageMedia)->toArray() : [];

        $this->additionalImages = $product->getMedia(Product::MC_ADDITIONAL_IMAGES)->map(fn(CustomMedia $media) => FileDTO::fromCustomMedia($media)->toArray())->toArray();
    }

    /**
     * @return string[]
     */
    protected function getCopyItemAttributes(): array
    {
        return [
            'name',
            'slug',
            'category_id',
            'ordering',
            'is_active',
            'is_with_variations',
            'brand_id',
            'coefficient',
            'coefficient_description',
            'coefficient_description_show',
            'price_name',
            'admin_comment',
            'price_purchase',
            'price_purchase_currency_id',
            'unit',
            'price_retail',
            'price_retail_currency_id',
            'availability_status_id',
            'preview',
            'description',
            'accessory_name',
            'similar_name',
            'related_name',
            'work_name',
            'instruments_name',
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

    protected function isCreatingFromCopy(): bool
    {
        return $this->copy_id &&
            $this->currentRouteName === Constants::ROUTE_ADMIN_PRODUCTS_CREATE &&
            $this->getCopyProduct() !== null;
    }

    protected function getCopyProduct(): ?Product
    {
        return Cache::store('array')->rememberForever(sprintf("%s-%s-%s", static::class, 'copy-product', $this->copy_id), fn() => Product::query()->find($this->copy_id));
    }
}

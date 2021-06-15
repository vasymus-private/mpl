<?php

namespace App\Http\Livewire\Admin;

use App\Constants;
use Domain\Common\Actions\MoveOrderingItemAction;
use Domain\Common\DTOs\FileDTO;
use Domain\Common\DTOs\OptionDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Actions\DeleteVariationAction;
use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\DTOs\Admin\CharCategoryDTO;
use Domain\Products\DTOs\Admin\CharDTO;
use Domain\Products\DTOs\InformationalPriceDTO;
use Domain\Products\DTOs\Admin\ProductProductDTO;
use Domain\Products\DTOs\Admin\VariationDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\Char;
use Domain\Products\Models\CharCategory;
use Domain\Products\Models\CharType;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Pivots\ProductProduct;
use Domain\Products\Models\Product\Product;
use Domain\Seo\Models\Seo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
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

    public ?string $currentRouteName = null;

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
     * @var array[] @see {@link \Domain\Products\DTOs\Admin\CharCategoryDTO}
     */
    public array $charCategories;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO}
     */
    public array $charRateOptions;

    protected const DEFAULT_NEW_CHAR_CATEGORY = [
        'name' => '',
    ];

    protected const DEFAULT_NEW_CHAR = [
        'name' => '',
        'category_id' => null,
    ];

    /**
     * @var array @see {@link \Domain\Products\DTOs\Admin\CharCategoryDTO}
     */
    public array $newCharCategory = self::DEFAULT_NEW_CHAR_CATEGORY;

    /**
     * @var array @see {@link \Domain\Products\DTOs\Admin\CharDTO}
     */
    public array $newChar = self::DEFAULT_NEW_CHAR;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\CharType}
     */
    public array $charTypes;

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

    public bool $isCreating;

    public bool $isCreatingFromCopy;

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

    protected function getNewCharCategoryRules(): array
    {
        return [
            'newCharCategory.name' => 'required|string|max:199',
        ];
    }

    protected function getNewCharRules(): array
    {
        return [
            'newChar.name' => 'required|string|max:199',
            'newChar.category_id' => [
                'required',
                (new Exists(CharCategory::TABLE, 'id'))->where('product_id', $this->item->id)
            ],
            'newChar.type_id' => [
                'required',
                (new Exists(CharType::TABLE, 'id'))
            ],
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
                'item.slug' => [
                    'nullable',
                    'string',
                    'max:199',
                    (new Unique(Product::TABLE, 'slug'))->when($this->item->id, function (Unique $unique) {
                        return $unique->whereNot('id', $this->item->id);
                    })
                ],
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
        $this->isCreating = $this->currentRouteName === Constants::ROUTE_ADMIN_PRODUCTS_CREATE;
        $this->isCreatingFromCopy = $this->copy_id && $this->currentRouteName === Constants::ROUTE_ADMIN_PRODUCTS_CREATE && $this->getCopyProduct() !== null;

        $this->initBrandsOptions();
        $this->initCurrenciesOptions();
        $this->initAvailabilityStatusesOptions();
        $this->initCategoriesOptions();
        $this->initCharRateOptions();

        $this->initTabs();

        $this->initGenerateSlug();

        $this->charTypes = CharType::query()->get()->map(fn(CharType $charType) => OptionDTO::fromCharType($charType)->toArray())->all();
        $this->initItem();
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

        $this->saveChars();

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

    public function deleteAdditionalImage($index)
    {
        $this->additionalImages = collect($this->additionalImages)->values()->filter(fn(array $additionalImage, int $key) => (string)$index !== (string)$key)->toArray();
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
        $this->item->is_with_variations = (bool)$this->is_with_variations;
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

        if ($this->mainImage['id'] !== null && !$this->isCreatingFromCopy) {
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
        $additionalImages = $this->saveAdditionalMedias(Product::MC_ADDITIONAL_IMAGES, $this->additionalImages);

        $this->additionalImages = $additionalImages;
    }

    protected function saveInstructions()
    {
        $instructions = $this->saveAdditionalMedias(Product::MC_FILES, $this->instructions);

        $this->instructions = $instructions;
    }

    /**
     * @param string $collectionName
     * @param array[] $fileDTOs @see {@link \Domain\Common\DTOs\FileDTO}
     *
     * @return array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    protected function saveAdditionalMedias(string $collectionName, array $fileDTOs): array
    {
        $medias = [];

        foreach ($fileDTOs as $fileDTO) {
            if ($fileDTO['id'] !== null && !$this->isCreatingFromCopy) {
                /** @var \Domain\Common\Models\CustomMedia $media */
                $media = $this->item->getMedia($collectionName)->first(fn(CustomMedia $customMedia) => $fileDTO['id'] === $customMedia->id);
                $media->name = $fileDTO['name'] ?: $fileDTO['file_name'];
                $media->save();
                $medias[] = $fileDTO;
            } else {
                $media = $this->addMedia(new FileDTO($fileDTO), $collectionName);
                $medias[] = $this->isCreatingFromCopy
                    ? FileDTO::copyFromCustomMedia($media)->toArray()
                    : FileDTO::fromCustomMedia($media)->toArray();
            }
        }

        if (!$this->isCreatingFromCopy) {
            $mediasIds = collect($medias)->pluck('id')->toArray();
            $this->item->getMedia($collectionName)->each(function(CustomMedia $customMedia) use($mediasIds) {
                if (!in_array($customMedia->id, $mediasIds)) {
                    $customMedia->delete();
                }
            });
        }

        return $medias;
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
        if ($this->isCreatingFromCopy) {
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

        $this->initChars($this->item);
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

        $this->initInfoPrices($origin);

        $this->initInstructions($origin);

        $this->initImages($origin);

        $this->initProductProduct($origin);

        $this->initRelatedCategories($origin);

        $this->initIsWithVariations($origin);

        $this->initVariations($origin);

        $this->initChars($origin);
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

    protected function initInfoPrices(Product $product)
    {
        $this->infoPrices = $product->infoPrices
            ->map(
                fn(InformationalPrice $informationalPrice) =>
                    $this->isCreatingFromCopy
                        ? InformationalPriceDTO::copyFromModel($informationalPrice)->toArray()
                        : InformationalPriceDTO::fromModel($informationalPrice)->toArray()
            )
            ->keyBy('temp_uuid')
            ->toArray();
    }

    protected function initInstructions(Product $product)
    {
        $this->instructions = $product
            ->getMedia(Product::MC_FILES)
            ->map(
                fn(CustomMedia $media) =>
                    $this->isCreatingFromCopy
                        ? FileDTO::copyFromCustomMedia($media)->toArray()
                        : FileDTO::fromCustomMedia($media)->toArray()
            )
            ->toArray();
    }

    protected function initImages(Product $product)
    {
        /** @var \Domain\Common\Models\CustomMedia $mainImageMedia */
        $mainImageMedia = $product->getFirstMedia(Product::MC_MAIN_IMAGE);
        $this->mainImage = $mainImageMedia
            ? (
                $this->isCreatingFromCopy
                    ? FileDTO::copyFromCustomMedia($mainImageMedia)->toArray()
                    : FileDTO::fromCustomMedia($mainImageMedia)->toArray()
            )
            : [];

        $this->additionalImages = $product
            ->getMedia(Product::MC_ADDITIONAL_IMAGES)
            ->map(
                fn(CustomMedia $media) =>
                    $this->isCreatingFromCopy
                        ? FileDTO::copyFromCustomMedia($media)->toArray()
                        : FileDTO::fromCustomMedia($media)->toArray()
            )
            ->toArray();
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

    protected function getCopyProduct(): ?Product
    {
        return Cache::store('array')->rememberForever(sprintf("%s-%s-%s", static::class, 'copy-product', $this->copy_id), fn() => Product::query()->find($this->copy_id));
    }

    protected function initCharRateOptions()
    {
        //$this->charRateOptions = collect(OptionDTO::fromRateSize())->map(fn(OptionDTO $optionDTO) => $optionDTO->toArray())->all();
        $this->charRateOptions = collect(OptionDTO::fromItemsArr(range(0, CharType::RATE_SIZE)))->map(fn(OptionDTO $optionDTO) => $optionDTO->toArray())->all();
    }

    protected function initChars(Product $product)
    {
        $initOrdering = CharCategory::DEFAULT_ORDERING;

        $this->charCategories = $product->charCategories
            ->map(function(CharCategory $charCategory) use(&$initOrdering) {
                if ($initOrdering >= $charCategory->ordering) {
                    $charCategory->ordering = $initOrdering = $initOrdering + 100;
                }
                return CharCategoryDTO::fromModel($charCategory)->toArray();
            })
            ->sortBy('ordering')
            ->values()
            ->all();
    }

    public function charCategoryOrdering($index, bool $isUp = true)
    {
        $this->charCategories = MoveOrderingItemAction::cached()->execute($this->charCategories, (int)$index, $isUp);
    }

    public function charOrdering($charCategoryIndex, $index, bool $isUp = true)
    {
        $chars = $this->charCategories[$charCategoryIndex]['chars'] ?? null;
        if (!$chars) {
            $this->skipRender();
            return;
        }
        $chars = MoveOrderingItemAction::cached()->execute($chars, (int)$index, $isUp);
        $this->charCategories[$charCategoryIndex]['chars'] = $chars;
    }

    public function deleteCharCategory($index)
    {
        unset($this->charCategories[$index]);
        $this->charCategories = array_values($this->charCategories);
    }

    public function deleteChar($charCategoryIndex, $index)
    {
        $charCategory = $this->charCategories[$charCategoryIndex];
        if (!$charCategory) {
            $this->skipRender();
            return;
        }
        $chars = $charCategory['chars'];
        unset($chars[$index]);
        $chars = array_values($chars);
        $charCategory['chars'] = $chars;
        $this->charCategories[$charCategoryIndex] = $charCategory;
    }

    public function addNewCharCategory()
    {
        $this->validate($this->getNewCharCategoryRules());

        $largestOrdering = max(collect($this->charCategories)->max('ordering'), 0);

        $charCategory = CharCategory::forceCreate([
            'product_id' => $this->item->id,
            'name' => $this->newCharCategory['name'],
            'ordering' => $largestOrdering + 100,
        ]);

        $this->charCategories[] = CharCategoryDTO::fromModel($charCategory)->toArray();
        $this->newCharCategory = static::DEFAULT_NEW_CHAR_CATEGORY;

        return true;
    }

    public function addNewChar()
    {
        // todo not working
        $this->validate($this->getNewCharRules());

        $charCategoryId = $this->newChar['category_id'];
        $charCategory = collect($this->charCategories)->first(fn(array $item) => (string)$item['id'] === (string)$charCategoryId);

        if ($charCategory === null) {
            $this->skipRender();
            return;
        }
        $largestOrdering = max(collect($charCategory['chars'])->max('ordering'), 0);

        $char = Char::forceCreate([
            'product_id' => $this->item->id,
            'name' => $this->newChar['name'],
            'ordering' => $largestOrdering + 100,
            'type_id' => (int)$this->newChar['type_id'],
            'category_id' => $charCategoryId,
        ]);

        $charCategory['chars'][] = CharDTO::fromModel($char)->toArray();
        $this->newChar = static::DEFAULT_NEW_CHAR;
        foreach ($this->charCategories as $index => $item) {
            if ((string)$item['id'] === (string)$charCategoryId) {
                $this->charCategories[$index] = $charCategory;
                break;
            }
        }

        return true;
    }

    protected function saveChars()
    {
        $charsIds = [];
        $charCategoriesIds = [];
        foreach ($this->charCategories as $charCategoryItem) {
            if ($this->isCreatingFromCopy) {
                $charCategory = CharCategory::forceCreate([
                    'name' => $charCategoryItem['name'],
                    'product_id' => $this->item->id,
                    'ordering' => $charCategoryItem['ordering'],
                ]);
            } else {
                $charCategory = CharCategory::query()->findOrFail($charCategoryItem['id']);
                $charCategory->ordering = $charCategoryItem['ordering'];
            }
            $charCategoriesIds[] = $charCategory->id;

            foreach ($charCategoryItem['chars'] as $charItem) {
                if ($this->isCreatingFromCopy) {
                    $char = Char::forceCreate([
                        'name' => $charItem['name'],
                        'value' => $charItem['value'],
                        'ordering' => $charItem['ordering'],
                        'type_id' => $charItem['type_id'],
                        'category_id' => $charCategory->id,
                    ]);
                } else {
                    $char = Char::query()->findOrFail($charItem['id']);
                    $char->value = $charItem['value'];
                    $char->ordering = $charItem['ordering'];
                    $char->save();
                }
                $charsIds[] = $char->id;
            }
        }
        $charCategories = $this->item->charCategories()->get();
        $chars = $this->item->chars()->get();

        $chars->each(function(Char $char) use($charsIds) {
            if (!in_array($char->id, $charsIds)) {
                $char->delete();
            }
        });

        $charCategories->each(function(CharCategory $charCategory) use($charCategoriesIds) {
            if (!in_array($charCategory->id, $charCategoriesIds)) {
                $charCategory->delete();
            }
        });
    }

    /**
     * @return array[] @see {@link \Domain\Common\DTOs\OptionDTO}
     */
    public function getCharCategoryOptions(): array
    {
        return collect($this->charCategories)
            ->map(fn(array $charCategory) => (new OptionDTO([
                'value' => $charCategory['id'],
                'label' => $charCategory['name'],
            ]))->toArray())
            ->all();
    }
}

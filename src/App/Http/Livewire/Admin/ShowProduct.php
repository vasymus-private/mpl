<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\FileDTO;
use Domain\Common\DTOs\OptionDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\DTOs\InformationalPriceDTO;
use Domain\Products\DTOs\ProductProductAdminDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Pivots\ProductProduct;
use Domain\Products\Models\Product\Product;
use Domain\Seo\Models\Seo;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Support\H;
use Livewire\WithFileUploads;

class ShowProduct extends Component
{
    use WithFileUploads;

    protected const MAX_FILE_SIZE_MB = 30;

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

    public string $activeTab;

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
     * @var \Domain\Products\Models\Product\Product
     */
    public Product $product;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\InformationalPriceDTO}
     */
    public array $infoPrices;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Brand}
     */
    public array $brands;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
     */
    public array $currencies;

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
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\AvailabilityStatus}
     */
    public array $availabilityStatuses;

    /**
     * @var \Domain\Seo\Models\Seo
     */
    public Seo $seo;

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
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\Category}
     * */
    public array $categories;

    /**
     * @var int[]
     */
    public array $relatedCategories;

    protected array $rules = [
        'product.name' => 'required|string|max:199',
        'product.is_active' => 'nullable|boolean',
        'product.slug' => 'required|string|max:199',
        'product.ordering' => 'integer|nullable',
        'product.brand_id' => 'integer|nullable|exists:' . Brand::class . ",id",
        'product.coefficient' => 'nullable|numeric',
        'product.coefficient_description' => 'nullable|string|max:199',
        'product.coefficient_description_show' => 'nullable|boolean',
        'product.price_name' => 'nullable|string|max:199',

        'infoPrices.*.price' => 'required|numeric',
        'infoPrices.*.name' => 'required|string|max:199',

        'product.admin_comment' => 'nullable|string|max:199',

        'tempMainImage' => 'nullable|max:'  . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb,
        'tempAdditionalImage' => 'nullable|max:'  . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb,
        'tempInstruction' => 'nullable|max:' . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb

        'mainImage.name' => 'nullable|max:199',
        'additionalImages.*.name' => 'nullable|max:199',
        'instructions.*.name' => 'nullable|max:199',

        'product.price_purchase' => 'nullable|numeric',
        'product.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
        'product.price_retail' => 'nullable|numeric',
        'product.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',

        'product.unit' => 'nullable|max:199',
        'product.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",

        'product.preview' => 'nullable|max:65000',
        'product.description' => 'nullable|max:65000',

        'product.accessory_name' => 'required|max:199',
        'product.similar_name' => 'required|max:199',
        'product.related_name' => 'required|max:199',
        'product.work_name' => 'required|max:199',
        'product.instruments_name' => 'required|max:199',

        'seo.title' => 'nullable|max:199',
        'seo.h1' => 'nullable|max:199',
        'seo.keywords' => 'nullable|max:65000',
        'seo.description' => 'nullable|max:65000',

        'productProducts.*.*.toDelete' => 'nullable|boolean',
        'loadedForProductProduct.*.*.isSelected' => 'nullable|boolean',

        'searchForProductProduct.*.category_id' => 'nullable|integer|exists:' . Category::class . ',id',
        'searchForProductProduct.*.product_name' => 'nullable',

        'product.category_id' => 'nullable|integer|exists:' . Category::class . ',id',
    ];

    protected static function getActiveTabCacheKey(int $productId = null): string
    {
        return auth()->id() . '-' . $productId . '-show-product-active-tab';
    }

    public function mount()
    {
        $this->brands = Brand::query()->select(["id", "name"])->get()->map(fn(Brand $brand) => OptionDTO::fromBrand($brand)->toArray())->toArray();
        $this->infoPrices = $this->product->infoPrices->map(fn(InformationalPrice $informationalPrice) => InformationalPriceDTO::fromModel($informationalPrice)->toArray())->keyBy('temp_uuid')->toArray();
        $this->instructions = $this->product->getMedia(Product::MC_FILES)->map(fn(CustomMedia $media) => FileDTO::fromCustomMedia($media)->toArray())->toArray();
        $this->currencies = Currency::query()->get()->map(fn(Currency $currency) => OptionDTO::fromCurrency($currency)->toArray())->all();
        $this->availabilityStatuses = AvailabilityStatus::query()->get()->map(fn(AvailabilityStatus $availabilityStatus) => OptionDTO::fromAvailabilityStatus($availabilityStatus)->toArray())->all();

        /** @var \Domain\Common\Models\CustomMedia $mainImageMedia */
        $mainImageMedia = $this->product->getFirstMedia(Product::MC_MAIN_IMAGE);
        $this->mainImage = $mainImageMedia ? FileDTO::fromCustomMedia($mainImageMedia)->toArray() : [];

        $this->additionalImages = $this->product->getMedia(Product::MC_ADDITIONAL_IMAGES)->map(fn(CustomMedia $media) => FileDTO::fromCustomMedia($media)->toArray())->toArray();

        $this->activeTab = Cache::get(static::getActiveTabCacheKey($this->product->id), self::DEFAULT_TAB);

        $this->seo = $this->product->seo ?: new Seo();

        $this->initProductProduct();

        $this->categories = Category::getTreeRuntimeCached()->reduce(function (array $acc, Category $category) {
            return $this->categoryToOption($acc, $category, 1);
        }, []);

        $this->relatedCategories = $this->product->relatedCategories->pluck('id')->toArray();
    }

    public function render()
    {
        return view('admin.livewire.show-product.show-product');
    }

    public function selectTab(string $tab)
    {
        if (in_array($tab, array_keys($this->tabs))) {
            Cache::put(static::getActiveTabCacheKey($this->product->id), $tab, new \DateInterval('PT15M'));
        }
    }

    public function save()
    {
        $this->validate();

        $this->saveProduct();

        $this->saveInfoPrices();

        $this->saveMainImage();

        $this->saveAdditionalImages();

        $this->saveInstructions();

        $this->saveSeo();

        $this->saveProductProduct();

        $this->saveRelatedCategories();
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

    public function deleteInstruction($index)
    {
        $this->instructions = collect($this->instructions)->values()->filter(fn(array $instruction, int $key) => (string)$index !== (string)$key)->toArray();
    }

    /**
     * @param mixed $name
     * @param mixed $value
     *
     * @see {@link https://github.com/livewire/livewire/issues/823#issuecomment-751321838}
     */
    public function updated($name, $value)
    {
        data_set($this, $name, H::trimAndNullEmptyString($value));
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
    public function updatedTempInstruction(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->instructions[] = $fileDTO->toArray();
    }

    protected function saveProduct()
    {
        $this->product->save();
    }

    protected function saveInfoPrices()
    {
        foreach ($this->infoPrices as $infoPrice) {
            /** @var \Domain\Products\Models\InformationalPrice $infoPriceModel */
            $infoPriceModel = InformationalPrice::query()->findOrNew($infoPrice['id']);
            $infoPriceDto = InformationalPriceDTO::create($infoPrice);
            $infoPriceModel->name = $infoPriceDto->name;
            $infoPriceModel->price = $infoPriceDto->price;
            $infoPriceModel->product_id = $this->product->id;
            $infoPriceModel->save();
        }
    }

    protected function saveMainImage()
    {
        if (!$this->mainImage) {
            /** @var CustomMedia|null $media */
            $media = $this->product->getFirstMedia(Product::MC_MAIN_IMAGE);
            if ($media) $media->forceDelete();
            return;
        }

        if ($this->mainImage['id'] !== null) {
            /** @var CustomMedia|null $media */
            $media = $this->product->getFirstMedia(Product::MC_MAIN_IMAGE);
            if ($media) {
                $media->name = $this->mainImage['name'];
                $media->save();
            }
        } else {
            $mainImage = new FileDTO($this->mainImage);
            $this->addMediaFrom($mainImage, Product::MC_MAIN_IMAGE);
        }
    }

    protected function saveAdditionalImages()
    {
        $additionalImages = [];

        foreach ($this->additionalImages as $additionalImage) {
            if ($additionalImage['id'] !== null) {
                /** @var \Domain\Common\Models\CustomMedia $media */
                $media = $this->product->getMedia(Product::MC_ADDITIONAL_IMAGES)->first(fn(CustomMedia $media) => $additionalImage['id'] === $media->id);
                $media->name = $additionalImage['name'] ?: $additionalImage['file_name'];
                $media->save();
                $additionalImages[] = $additionalImage;
            } else {
                $media = $this->addMediaFrom(new FileDTO($additionalImage), Product::MC_ADDITIONAL_IMAGES);
                $additionalImages[] = FileDTO::fromCustomMedia($media)->toArray();
            }
        }

        $additionalImagesIds = collect($additionalImages)->pluck("id")->toArray();
        $this->product->getMedia(Product::MC_ADDITIONAL_IMAGES)->each(function(CustomMedia $media) use($additionalImagesIds) {
            if (!in_array($media->id, $additionalImagesIds)) $media->forceDelete();
        });
        $this->additionalImages = $additionalImages;
    }

    protected function saveInstructions()
    {
        $instructions = [];

        foreach ($this->instructions as $instruction) {
            if ($instruction['id'] !== null) {
                /** @var \Domain\Common\Models\CustomMedia $media */
                $media = $this->product->getMedia(Product::MC_FILES)->first(fn(CustomMedia $media) => $instruction['id'] === $media->id);
                $media->name = $instruction['name'] ?: $instruction['file_name'];
                $media->save();
                $instructions[] = $instruction;
            } else {
                $media = $this->addMediaFrom(new FileDTO($instruction), Product::MC_FILES);
                $instructions[] = FileDTO::fromCustomMedia($media)->toArray();
            }
        }

        $instructionsIds = collect($instructions)->pluck("id")->toArray();
        $this->product->getMedia(Product::MC_FILES)->each(function(CustomMedia $media) use($instructionsIds) {
            if (!in_array($media->id, $instructionsIds)) $media->forceDelete();
        });
        $this->instructions = $instructions;
    }

    protected function saveSeo()
    {
        $this->product->seo()->save($this->seo);
    }

    protected function saveProductProduct()
    {
        foreach ($this->mapTypeToRelationName as $type => $relation) {
            $currentIds = collect($this->productProducts[$type])->filter(fn(array $item) => !$item['toDelete'])->pluck('id')->toArray();
            $selectedIds = collect($this->loadedForProductProduct[$type])->filter(fn(array $item) => $item['isSelected'])->pluck('id')->toArray();
            $ids = array_merge($currentIds, $selectedIds);
            $sync = collect($ids)->reduce(function(array $acc, int $id) use($type) {
                $acc[$id] = ["type" => $type];
                return $acc;
            }, []);
            $this->product->{$relation}()->sync($sync);
        }
        $this->initProductProduct(true);
        $this->initLoadedForProductProduct();
        $this->initSearchForProductProduct();
    }

    protected function saveRelatedCategories()
    {
        $this->product->relatedCategories()->sync($this->relatedCategories);
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

    protected function addMediaFrom(FileDTO $fileDTO, string $from): CustomMedia
    {
        $fileAdder = $this->product
            ->addMedia($fileDTO->path)
            ->preservingOriginal()
            ->usingFileName($fileDTO->file_name)
            ->usingName($fileDTO->name ?? $fileDTO->file_name)
        ;
        /** @var \Domain\Common\Models\CustomMedia $customMedia */
        $customMedia = $fileAdder->toMediaCollection($from);
        return $customMedia;
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

    protected function initProductProduct(bool $refresh = false)
    {
        foreach ($this->mapTypeToRelationName as $type => $relation) {
            if ($refresh) $this->product->load($relation);
            /** @var \Illuminate\Support\Collection $rel */
            $rel = $this->product->{$relation};
            $this->productProducts[$type] = $rel->map(fn(Product $product) => ProductProductAdminDTO::fromModel($product, "productProducts.{$type}.{$product->id}.")->toArray())->keyBy('id')->all();
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
}

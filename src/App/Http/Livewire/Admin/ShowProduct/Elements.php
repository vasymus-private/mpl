<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use App\Http\Livewire\Admin\HasAvailabilityStatuses;
use App\Http\Livewire\Admin\HasBrands;
use App\Http\Livewire\Admin\HasCurrencies;
use App\Http\Livewire\Admin\HasGenerateSlug;
use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Products\DTOs\InformationalPriceDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Product\Product;
use Illuminate\Validation\Rules\Unique;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;

class Elements extends Component
{
    use HasCommonShowProduct;
    use HasBrands;
    use HasCurrencies;
    use HasAvailabilityStatuses;
    use HasGenerateSlug;

    protected const MAX_FILE_SIZE_MB = ShowProductConstants::MAX_FILE_SIZE_MB;

    /**
     * @var \Domain\Products\Models\Product\Product
     */
    public Product $item;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\InformationalPriceDTO}
     */
    public array $infoPrices;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $instructions;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempInstruction;

    /**
     * @var string[]
     */
    protected $listeners = [
        ShowProductConstants::EVENT_SAVE_ELEMENTS => 'saveElements',
    ];

    /**
     * @return array
     */
    protected function queryString(): array
    {
        return array_merge($this->getHasShowProductQueryString(), []);
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
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
            'item.admin_comment' => 'nullable|string|max:199',
            'item.price_purchase' => 'nullable|numeric',
            'item.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
            'item.price_retail' => 'nullable|numeric',
            'item.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
            'item.unit' => 'nullable|string|max:199',
            'item.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",

            'infoPrices.*.price' => 'required|numeric',
            'infoPrices.*.name' => 'required|string|max:199',

            'instructions.*.name' => 'nullable|max:199',

            'tempInstruction' => 'nullable|max:' . (1024 * self::MAX_FILE_SIZE_MB), // 1024 -> 1024 kb = 1 mb
        ];
    }

    public function mount()
    {
        $this->initCommonShowProduct();
        $this->initBrandsOptions();
        $this->initCurrenciesOptions();
        $this->initAvailabilityStatusesOptions();

        $this->initGenerateSlug();

        $this->initItem();
    }

    public function render()
    {
        return view('admin.livewire.show-product.elements');
    }

    public function saveElements()
    {
        $this->validate();

        $this->saveProduct();

        $this->saveInfoPrices();

        $this->saveInstructions();
    }

    public function updatedItemName()
    {
        $this->handleGenerateSlug();
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

    public function deleteInstruction($index)
    {
        $this->instructions = collect($this->instructions)->values()->filter(fn(array $instruction, int $key) => (string)$index !== (string)$key)->toArray();
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempInstruction(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->instructions[] = $fileDTO->toArray();
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

        $this->initInfoPrices($this->item);
        $this->initInstructions($this->item);
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

        $this->initInfoPrices($origin);
        $this->initInstructions($origin);
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

    protected function saveProduct()
    {
        $saveAttributes = [
            'name' => $this->item->name,
            'is_active' => $this->item->is_active,
            'slug' => $this->item->slug,
            'ordering' => $this->item->ordering,
            'brand_id' => $this->item->brand_id,
            'coefficient' => $this->item->coefficient,
            'coefficient_description' => $this->item->coefficient_description,
            'coefficient_description_show' => $this->item->coefficient_description_show,
            'price_name' => $this->item->price_name,
            'admin_comment' => $this->item->admin_comment,
            'price_purchase' => $this->item->price_purchase,
            'price_purchase_currency_id' => $this->item->price_purchase_currency_id,
            'price_retail' => $this->item->price_retail,
            'price_retail_currency_id' => $this->item->price_retail_currency_id,
            'unit' => $this->item->unit,
            'availability_status_id' => $this->item->availability_status_id,
        ];
        /** @var \Domain\Products\Models\Product\Product $item */
        $item = $this->isCreating
            ? new Product()
            : Product::query()->findOrFail($this->item->id);
        $item->forceFill($saveAttributes);
        $item->save();

        $this->item = $item;
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

    protected function saveInstructions()
    {
        $instructions = $this->saveAdditionalMedias(Product::MC_FILES, $this->instructions);

        $this->instructions = $instructions;
    }
}

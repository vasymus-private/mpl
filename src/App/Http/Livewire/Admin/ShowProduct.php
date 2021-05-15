<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\InstructionDTO;
use Domain\Common\DTOs\OptionDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Products\DTOs\InformationalPriceDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Product\Product;
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
     * @var array[] @see {@link \Domain\Common\DTOs\InstructionDTO}
     */
    public array $instructions;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempInstruction;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\AvailabilityStatus}
     */
    public array $availabilityStatuses;

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

        'tempInstruction' => 'nullable|max:' . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb

        'instructions.*.name' => 'nullable|max:199',

        'product.price_purchase' => 'nullable|numeric',
        'product.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
        'product.price_retail' => 'nullable|numeric',
        'product.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',

        'product.unit' => 'nullable|max:199',
        'product.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",
    ];

    public function mount()
    {
        $this->brands = Brand::query()->select(["id", "name"])->get()->map(fn(Brand $brand) => OptionDTO::fromBrand($brand)->toArray())->toArray();
        $this->infoPrices = $this->product->infoPrices->map(fn(InformationalPrice $informationalPrice) => InformationalPriceDTO::fromModel($informationalPrice)->toArray())->keyBy('temp_uuid')->toArray();
        $this->instructions = $this->product->getMedia(Product::MC_FILES)->map(fn(CustomMedia $media) => InstructionDTO::fromCustomMedia($media)->toArray())->toArray();
        $this->currencies = Currency::query()->get()->map(fn(Currency $currency) => OptionDTO::fromCurrency($currency)->toArray())->all();
        $this->availabilityStatuses = AvailabilityStatus::query()->get()->map(fn(AvailabilityStatus $availabilityStatus) => OptionDTO::fromAvailabilityStatus($availabilityStatus)->toArray())->all();

        $this->activeTab = Cache::get('show-product-active-tab', self::DEFAULT_TAB);
    }

    public function render()
    {
        return view('admin.livewire.show-product.show-product');
    }

    public function selectTab(string $tab)
    {
        if (in_array($tab, array_keys($this->tabs))) {
            Cache::put('show-product-active-tab', $tab, new \DateInterval('PT15M'));
        }
    }

    public function save()
    {
        $this->validate();

        $this->saveProduct();

        $this->saveInfoPrices();

        $this->saveInstructions();
    }

    public function deleteInfoPrice($uuid)
    {
        $infoPrice = $this->infoPrices[$uuid] ?? null;
        if (!$infoPrice) {
            return;
        }

        unset($this->infoPrices[$uuid]);
    }

    public function addInfoPrice()
    {
        $infoPriceDTO = InformationalPriceDTO::create();
        $this->infoPrices[$infoPriceDTO->temp_uuid] = $infoPriceDTO->toArray();
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
    public function updatedTempInstruction(TemporaryUploadedFile $value)
    {
        $instructionDTO = InstructionDTO::fromTemporaryUploadedFile($value);
        $this->instructions[] = $instructionDTO->toArray();
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
                continue;
            }

            $media = $this->addMediaFromInstruction(new InstructionDTO($instruction));
            $instructions[] = InstructionDTO::fromCustomMedia($media)->toArray();
        }

        $instructionsIds = collect($instructions)->pluck("id")->toArray();
        $this->product->getMedia(Product::MC_FILES)->each(function(CustomMedia $media) use($instructionsIds) {
            if (!in_array($media->id, $instructionsIds)) $media->forceDelete();
        });
        $this->instructions = $instructions;
    }

    protected function addMediaFromInstruction(InstructionDTO $instructionDTO): CustomMedia
    {
        $fileAdder = $this->product
            ->addMedia($instructionDTO->path)
            ->preservingOriginal()
            ->usingFileName($instructionDTO->file_name)
            ->usingName($instructionDTO->file_name)
        ;
        /** @var \Domain\Common\Models\CustomMedia $customMedia */
        $customMedia = $fileAdder->toMediaCollection(Product::MC_FILES);
        return $customMedia;
    }
}

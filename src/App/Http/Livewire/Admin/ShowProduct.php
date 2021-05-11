<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\InstructionDTO;
use Domain\Common\DTOs\OptionDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Support\H;
use Livewire\WithFileUploads;

class ShowProduct extends Component
{
    use WithFileUploads;

    /**
     * @var \Domain\Products\Models\Product\Product
     */
    public Product $product;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\InformationalPrice[]
     */
    public Collection $infoPrices;

    /**
     * @var array[]|\Domain\Common\DTOs\OptionDTO[]
     */
    public array $brands;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Domain\Common\Models\Currency[]
     */
    public Collection $currencies;

    /**
     * @var array[]
     */
    public array $instructions;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempInstruction;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public Collection $availabilityStatuses;

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

        'instructions.*.name' => 'nullable',

        'product.price_purchase' => 'nullable|numeric',
        'product.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
        'product.price_retail' => 'nullable|numeric',
        'product.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',

        'product.unit' => 'required|string|max:199',
        'product.availability_status_id' => 'integer|nullable|exists:' . AvailabilityStatus::class . ",id",
    ];

    public function mount()
    {
        $this->brands = Brand::query()->select(["id", "name"])->get()->map(fn(Brand $brand) => OptionDTO::fromBrand($brand)->toArray())->toArray();
        $this->infoPrices = $this->product->infoPrices;
        $this->instructions = $this->product->getMedia(Product::MC_FILES)->map(fn(CustomMedia $media) => InstructionDTO::fromCustomMedia($media)->toArray())->toArray();
        $this->currencies = Currency::query()->get();
        $this->availabilityStatuses = AvailabilityStatus::query()->get();
    }

    public function save()
    {
        $this->validate();

        $this->saveProduct();

        $this->saveInfoPrices();

        $this->saveInstructions();
    }

    public function deleteInfoPrice($id)
    {
        $this->resetErrorBag();
        $this->resetValidation();
        /** @var \Domain\Products\Models\InformationalPrice $infoPrice */
        $infoPrice = $this->infoPrices->first(fn(InformationalPrice $ip) => (string)$ip->id === (string)$id);
        if ($infoPrice) {
            $infoPrice->delete();
            $this->infoPrices = $this->infoPrices->filter(fn(InformationalPrice $ip) => (string)$ip->id !== (string)$id);
        }
    }

    public function addInfoPrice()
    {
        $this->infoPrices->add(new InformationalPrice());
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

    public function render()
    {
        return view('admin.livewire.show-product');
    }

    protected function saveProduct()
    {
        $this->product->save();
    }

    protected function saveInfoPrices()
    {
        foreach ($this->infoPrices as $infoPrice) {
            $infoPrice->product_id = $this->product->id;
            $infoPrice->save();
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
        return $fileAdder->toMediaCollection(Product::MC_FILES);
    }
}

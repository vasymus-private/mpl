<?php

namespace App\Http\Livewire\Admin\ShowProduct;

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
use Livewire\TemporaryUploadedFile;

/**
 * @mixin \App\Http\Livewire\Admin\ShowProduct\ShowProduct
 * @mixin \App\Http\Livewire\Admin\ShowProduct\BaseShowProduct
 */
trait HasElementsTab
{
    use HasGenerateSlug;

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
     * @return array
     */
    protected function getElementsTabRules(): array
    {
        return [
            'item.name' => 'required|string|max:199',
            'item.is_active' => 'nullable|boolean',
            'item.slug' => [
                'required',
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
            'item.coefficient_variation_description' => [
                $this->isAnyVariationHasCoefficient() ? 'required' : 'nullable',
                'string',
                'max:199',
            ],
            'item.coefficient_description_show' => 'nullable|boolean',
            'item.price_name' => 'nullable|string|max:199',
            'item.admin_comment' => 'nullable|string|max:199',
            'item.price_purchase' => 'required|numeric',
            'item.price_purchase_currency_id' => 'required|int|exists:' . Currency::class . ',id',
            'item.price_retail' => 'required|numeric',
            'item.price_retail_currency_id' => 'required|int|exists:' . Currency::class . ',id',
            'item.unit' => 'nullable|string|max:199',
            'item.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",

            'infoPrices.*.price' => 'required|numeric',
            'infoPrices.*.name' => 'required|string|max:199',

            'instructions.*.name' => 'nullable|max:199',

            'tempInstruction' => 'nullable|max:' . (1024 * self::MAX_FILE_SIZE_MB), // 1024 -> 1024 kb = 1 mb
        ];
    }

    /**
     * @return string[]
     */
    protected function getElementsTabMessages(): array
    {
        return [
            'item.name.required' => 'Не заполнено поле `наименование`.',
            'item.slug.unique' => '`Символьный код` не уникален.',
            'item.coefficient_variation_description.required' => 'Если есть варианты с коэффициентом, то `Описание столбца коэффициента вариантов` обязательно.',
        ];
    }

    protected function initElementsTab()
    {
        $this->initGenerateSlug();

        $product = $this->item;

        if ($this->isCreatingFromCopy) {
            $originProduct = $this->getOriginProduct();
            $product = $originProduct ?: $product;
        }

        $this->initInfoPrices($product);
        $this->initInstructions($product);
    }

    protected function handleSaveElementsTab()
    {
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

    protected function getElementsTabAttributes(): array
    {
        return [
            'name' => $this->item->name,
            'is_active' => $this->item->is_active,
            'slug' => $this->item->slug,
            'ordering' => $this->item->ordering,
            'brand_id' => $this->item->brand_id,
            'coefficient' => $this->item->coefficient,
            'coefficient_description' => $this->item->coefficient_description,
            'coefficient_variation_description' => $this->item->coefficient_variation_description,
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

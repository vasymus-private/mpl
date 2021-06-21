<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Actions\DeleteVariationAction;
use Domain\Products\DTOs\Admin\VariationDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Product\Product;
use Livewire\TemporaryUploadedFile;

trait HasVariationsTab
{
    /**
     * @var bool
     */
    public bool $is_with_variations;

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
     * @var bool
     */
    public $variationsSelectAll = false;

    /**
     * @return string[]
     */
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

    /**
     * @return string[]
     */
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
            'tempVariationMainImage' => 'nullable|max:'  . (1024 * ShowProductConstants::MAX_FILE_SIZE_MB), // 1024 - 1mb,
            'tempVariationAdditionalImage' => 'nullable|max:'  . (1024 * ShowProductConstants::MAX_FILE_SIZE_MB), // 1024 - 1mb,
        ];
    }

    protected function initVariationsTab()
    {
        $product = $this->item;

        if ($this->isCreatingFromCopy) {
            $originProduct = $this->getOriginProduct();
            $product = $originProduct ?: $product;
        }

        $this->initIsWithVariations($product);

        $this->initVariations($product);
    }

    protected function getVariationsTabAttributes(): array
    {
        return [
            'is_with_variations' => (bool)$this->is_with_variations,
        ];
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

    protected function initIsWithVariations(Product $product)
    {
        $this->is_with_variations = (bool)$product->is_with_variations;
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
}

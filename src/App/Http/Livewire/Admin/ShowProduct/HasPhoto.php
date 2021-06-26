<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\Product\Product;
use Livewire\TemporaryUploadedFile;

/**
 * @mixin \App\Http\Livewire\Admin\ShowProduct\ShowProduct
 * @mixin \App\Http\Livewire\Admin\ShowProduct\BaseShowProduct
 */
trait HasPhoto
{
    /**
     * @var array|null @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $mainImage = [];

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $additionalImages = [];

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempMainImage;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempAdditionalImage;

    /**
     * @return array
     */
    protected function getPhotoTabRules(): array
    {
        return [
            'tempMainImage' => 'nullable|max:'  . (1024 * ShowProductConstants::MAX_FILE_SIZE_MB), // 1024 - 1mb,
            'tempAdditionalImage' => 'nullable|max:'  . (1024 * ShowProductConstants::MAX_FILE_SIZE_MB), // 1024 - 1mb,

            'mainImage.name' => 'nullable|max:199',
            'additionalImages.*.name' => 'nullable|max:199',
        ];
    }

    /**
     * @return string[]
     */
    protected function getPhotoTabMessages(): array
    {
        return [

        ];
    }

    protected function initPhotoTab()
    {
        $product = $this->item;

        if ($this->isCreatingFromCopy) {
            $originProduct = $this->getOriginProduct();
            $product = $originProduct ?: $product;
        }

        $this->initImages($product);
    }

    protected function handleSavePhotoTab()
    {
        $this->saveMainImage();

        $this->saveAdditionalImages();
    }

    protected function getPhotoTabAttributes(): array
    {
        return [];
    }

    public function deleteMainImage()
    {
        $this->mainImage = [];
    }

    public function deleteAdditionalImage($index)
    {
        $this->additionalImages = collect($this->additionalImages)->values()->filter(fn(array $additionalImage, int $key) => (string)$index !== (string)$key)->toArray();
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

    protected function saveMainImage()
    {
        if (!$this->mainImage) {
            /** @var CustomMedia|null $media */
            $media = $this->item->getFirstMedia(Product::MC_MAIN_IMAGE);
            if ($media) {
                $media->delete();
            }
            return;
        }

        if ($this->isCreatingFromCopy || $this->mainImage['id'] === null) {
            $mainImage = new FileDTO($this->mainImage);
            $this->addMedia($mainImage, Product::MC_MAIN_IMAGE);
            return;
        }

        /** @var CustomMedia|null $media */
        $media = $this->item->getFirstMedia(Product::MC_MAIN_IMAGE);
        if ($media) {
            $media->name = $this->mainImage['name'];
            $media->save();
        }
    }

    protected function saveAdditionalImages()
    {
        $additionalImages = $this->saveAdditionalMedias(Product::MC_ADDITIONAL_IMAGES, $this->additionalImages);

        $this->additionalImages = $additionalImages;
    }
}

<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\Product\Product;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Photo extends BaseShowProduct
{
    use WithFileUploads;

    protected const MAX_FILE_SIZE_MB = ShowProductConstants::MAX_FILE_SIZE_MB;

    /**
     * @var array|null @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $mainImage = [];

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $additionalImages;

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
    protected function rules(): array
    {
        return [
            'tempMainImage' => 'nullable|max:'  . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb,
            'tempAdditionalImage' => 'nullable|max:'  . (1024 * self::MAX_FILE_SIZE_MB), // 1024 - 1mb,

            'mainImage.name' => 'nullable|max:199',
            'additionalImages.*.name' => 'nullable|max:199',
        ];
    }

    /**
     * @return array
     */
    protected function queryString(): array
    {
        return array_merge($this->getHasShowProductQueryString(), []);
    }

    protected function getComponentName(): string
    {
        return ShowProductConstants::COMPONENT_NAME_PHOTO;
    }

    public function mount()
    {
//        dump($this->item->uuid);
        $this->initCommonShowProduct();

        $this->initItem();
    }

    public function render()
    {
        return view('admin.livewire.show-product.photo');
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

    protected function initItem()
    {
        if ($this->isCreatingFromCopy) {
            $copyProduct = $this->getCopyProduct();
            if ($copyProduct !== null) {
                $this->initAsCopiedItem($copyProduct);
                return;
            }
        }

        $this->initImages($this->item);
    }

    protected function initAsCopiedItem(Product $origin)
    {
        parent::initAsCopiedItem($origin);

        $this->initImages($origin);
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

    public function handleSave()
    {
        $this->validateBeforeHandleSave();
        $this->getRefreshedItemOrNew();

        $this->saveMainImage();

        $this->saveAdditionalImages();
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
}

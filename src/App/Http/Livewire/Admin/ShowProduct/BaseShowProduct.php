<?php

namespace App\Http\Livewire\Admin\ShowProduct;

use App\Constants;
use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Support\H;

abstract class BaseShowProduct extends Component
{
    /**
     * @var \Domain\Products\Models\Product\Product
     */
    public Product $item;

    /**
     * @var string|null
     */
    public ?string $currentRouteName = null;

    /**
     * @var string|int|null
     */
    public $copy_id = '';

    /**
     * @var bool
     */
    public bool $isCreating;

    /**
     * @var bool
     */
    public bool $isCreatingFromCopy;

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

    protected function getRefreshedItemOrNew(): Product
    {
        return Product::query()->firstOrNew(['uuid' => $this->item->uuid]);
    }

    /**
     * @return array
     */
    protected function getHasShowProductQueryString(): array
    {
        return [
            'copy_id' => ['except' => ''],
        ];
    }

    protected function initAsCopiedItem(Product $origin)
    {
        // fill item with attributes
        $attributes = collect($origin->toArray())
            ->only($this->getCopyItemAttributes())
            ->toArray();
        $this->item->forceFill($attributes);
    }

    /**
     * @return void
     */
    protected function initCommonShowProduct()
    {
        $this->currentRouteName = Route::currentRouteName();
        $this->isCreating = $this->currentRouteName === Constants::ROUTE_ADMIN_PRODUCTS_CREATE;
        $this->isCreatingFromCopy = $this->copy_id && $this->currentRouteName === Constants::ROUTE_ADMIN_PRODUCTS_CREATE && $this->getOriginProduct() !== null;
    }

    /**
     * @return \Domain\Products\Models\Product\Product|null
     */
    protected function getOriginProduct(): ?Product
    {
        return Cache::store('array')->rememberForever(sprintf("%s-%s", 'copy-product', $this->copy_id), fn() => Product::query()->find($this->copy_id));
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
     * @param \Domain\Common\DTOs\FileDTO $fileDTO
     * @param string $collectionName
     * @param \Domain\Products\Models\Product\Product|null $for
     *
     * @return \Domain\Common\Models\CustomMedia
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
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

    /**
     * @param string $collectionName
     * @param array[] $fileDTOs @see {@link \Domain\Common\DTOs\FileDTO}
     *
     * @return array[] @see {@link \Domain\Common\DTOs\FileDTO}
     *
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    protected function saveAdditionalMedias(string $collectionName, array $fileDTOs): array
    {
        $medias = [];

        foreach ($fileDTOs as $fileDTO) {
            if ($this->isCreatingFromCopy) {
                $this->addMedia(new FileDTO($fileDTO), $collectionName);
                $medias[] = $fileDTO;
                continue;
            }

            if ($fileDTO['id'] !== null) {
                /** @var \Domain\Common\Models\CustomMedia $media */
                $media = $this->item->getMedia($collectionName)->first(fn(CustomMedia $customMedia) => $fileDTO['id'] === $customMedia->id);
                $media->name = $fileDTO['name'] ?: $fileDTO['file_name'];
                $media->save();
                $medias[] = $fileDTO;
            } else {
                $media = $this->addMedia(new FileDTO($fileDTO), $collectionName);
                $medias[] = FileDTO::fromCustomMedia($media)->toArray();
            }
        }

        if (!$this->isCreating) {
            $mediasIds = collect($medias)->pluck('id')->toArray();
            $this->item->getMedia($collectionName)->each(function(CustomMedia $customMedia) use($mediasIds) {
                if (!in_array($customMedia->id, $mediasIds)) {
                    $customMedia->delete();
                }
            });
        }

        return $medias;
    }

    protected function emitValidationStatus(bool $isValid, array $errors = [])
    {
        $this->emitTo(ShowProductConstants::COMPONENT_NAME_SHOW_PRODUCT, ShowProductConstants::EVENT_VALIDATION_NOTIFICATION, [
            'name' => $this->getComponentName(),
            'isValid' => $isValid,
            'errors' => $errors,
        ]);
    }

    protected function validateBeforeHandleSave()
    {
        try {
            $this->validate();
            $this->emitValidationStatus(true);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            $this->emitValidationStatus(false, $exception->errors());
            throw $exception;
        }
    }
}

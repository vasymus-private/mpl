<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use App\Constants;
use Domain\Common\Actions\BaseAction;
use Domain\Common\Models\CustomMedia;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateProductAction extends BaseAction
{
    private SaveSeoAction $saveSeoAction;

    private SyncAndSaveInfoPricesAction $syncAndSaveInfoPricesAction;

    public function __construct(
        SaveSeoAction $saveSeoAction,
        SyncAndSaveInfoPricesAction $syncAndSaveInfoPricesAction
    ) {
        $this->saveSeoAction = $saveSeoAction;
        $this->syncAndSaveInfoPricesAction = $syncAndSaveInfoPricesAction;
    }

    /**
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     * @param \Domain\Products\Models\Product\Product|null $target
     *
     * @return \Domain\Products\Models\Product\Product
     */
    public function execute(ProductDTO $productDTO, Product $target = null): Product
    {
        return DB::transaction(function() use($productDTO, $target) {
            $target = $target ?: new Product();

            if ($productDTO->name !== null) {
                $target->name = $productDTO->name;
            }

            if ($productDTO->slug !== null) {
                $target->slug = $productDTO->slug;
            }

            if ($productDTO->ordering !== null) {
                $target->ordering = $productDTO->ordering;
            }

            if ($productDTO->is_active !== null) {
                $target->is_active = $productDTO->is_active;
            }

            if ($productDTO->unit !== null) {
                $target->unit = $productDTO->unit;
            }

            if ($productDTO->price_purchase !== null) {
                $target->price_purchase = $productDTO->price_purchase;
            }

            if ($productDTO->price_purchase_currency_id !== null) {
                $target->price_purchase_currency_id = $productDTO->price_purchase_currency_id;
            }

            if ($productDTO->price_retail !== null) {
                $target->price_retail = $productDTO->price_retail;
            }

            if ($productDTO->price_retail_currency_id !== null) {
                $target->price_retail_currency_id = $productDTO->price_retail_currency_id;
            }

            if ($productDTO->admin_comment !== null) {
                $target->admin_comment = $productDTO->admin_comment;
            }

            if ($productDTO->availability_status_id !== null) {
                $target->availability_status_id = $productDTO->availability_status_id;
            }

            if ($productDTO->brand_id !== null) {
                $target->brand_id = $productDTO->brand_id;
            }

            if ($productDTO->category_id !== null) {
                $target->category_id = $productDTO->category_id;
            }

            if ($productDTO->is_with_variations !== null) {
                $target->is_with_variations = $productDTO->is_with_variations;
            }

            if ($productDTO->coefficient !== null) {
                $target->coefficient = $productDTO->coefficient;
            }

            if ($productDTO->coefficient_description !== null) {
                $target->coefficient_description = $productDTO->coefficient_description;
            }

            if ($productDTO->coefficient_description_show !== null) {
                $target->coefficient_description_show = $productDTO->coefficient_description_show;
            }

            if ($productDTO->coefficient_variation_description !== null) {
                $target->coefficient_variation_description = $productDTO->coefficient_variation_description;
            }

            if ($productDTO->price_name !== null) {
                $target->price_name = $productDTO->price_name;
            }

            if ($productDTO->preview !== null) {
                $target->preview = $productDTO->preview;
            }

            if ($productDTO->description !== null) {
                $target->description = $productDTO->description;
            }

            if ($productDTO->accessory_name !== null) {
                $target->accessory_name = $productDTO->accessory_name;
            }

            if ($productDTO->similar_name !== null) {
                $target->similar_name = $productDTO->similar_name;
            }

            if ($productDTO->related_name !== null) {
                $target->related_name = $productDTO->related_name;
            }

            if ($productDTO->work_name !== null) {
                $target->work_name = $productDTO->work_name;
            }

            if ($productDTO->instruments_name !== null) {
                $target->instruments_name = $productDTO->instruments_name;
            }

            if (! $target->id) {
                $target->save();
            }

            if ($productDTO->seo !== null) {
                $this->saveSeoAction->execute($target, $productDTO->seo);
            }

            $this->syncAndSaveInfoPricesAction->execute($target, $productDTO->infoPrices);

            $this->saveInstructions($target, $productDTO->instructions);

            // todo

            $target->save();

            return $target;
        });
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[] $mediaDTOs
     *
     * @return void
     */
    private function saveInstructions(Product $target, array $mediaDTOs)
    {
        /** @var \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO[][] $sorted */
        $sorted = collect($mediaDTOs)->reduce(function(array $acc, MediaDTO $item) {
            if ($item->is_copy || !$item->id) {
                $acc['new'][] = $item;
                return $acc;
            }

            $acc['exist'][$item->id] = $item;

            return $acc;
        }, [
            'new' => [],
            'exist' => [],
        ]);

        $notDeleteIds = collect($sorted['exist'])->pluck('id')->filter(fn($id) => (bool)$id)->all();

        $target->getMedia(Product::MC_FILES)->each(function (CustomMedia $customMedia) use ($notDeleteIds, $sorted) {
            if (in_array($customMedia->id, $notDeleteIds)) {
                $updateMediaDTO = $sorted['exist'][$customMedia->id];
                $customMedia->name = $updateMediaDTO->name;
                $customMedia->file_name = $updateMediaDTO->file_name;
                $customMedia->order_column = $updateMediaDTO->order_column;
                $customMedia->save();
                return;
            }

            $customMedia->delete();
        });

        foreach ($sorted['new'] as $mediaDTO) {
            if ($mediaDTO->file) {
                $target
                    ->addMedia($mediaDTO->file)
                    ->usingFileName($mediaDTO->file_name)
                    ->usingName($mediaDTO->name ?? $mediaDTO->file_name)
                    ->toMediaCollection(Product::MC_FILES);
                continue;
            }

            if (!$mediaDTO->is_copy || !$mediaDTO->id) {
                continue;
            }

            /** @var \Domain\Common\Models\CustomMedia|null $original */
            $original = CustomMedia::query()->find($mediaDTO->id);
            if (!$original) {
                continue;
            }

            if (in_array($original->disk, Constants::MEDIA_CLOUD_DISKS)) {
                $remoteUrl = $original->getFullUrl();
                $target
                    ->addMediaFromUrl($remoteUrl)
                    ->usingFileName($mediaDTO->file_name)
                    ->usingName($mediaDTO->name ?? $mediaDTO->file_name)
                    ->toMediaCollection(Product::MC_FILES);

                continue;
            }

            // todo
        }
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     *
     * @return void
     */
    private function saveMainImage(Product $target, ProductDTO $productDTO)
    {
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     *
     * @return void
     */
    private function saveAdditionalImages(Product $target, ProductDTO $productDTO)
    {
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     *
     * @return void
     */
    private function saveCharCategoriesAndChars(Product $target, ProductDTO $productDTO)
    {
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     *
     * @return void
     */
    private function saveOtherProducts(Product $target, ProductDTO $productDTO)
    {
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     *
     * @return void
     */
    private function saveVariations(Product $target, ProductDTO $productDTO)
    {
    }
}

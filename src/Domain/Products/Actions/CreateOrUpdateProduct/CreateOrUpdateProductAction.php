<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Actions\SaveSeoAction;
use Domain\Common\Actions\SyncAndSaveMediasAction;
use Domain\Common\DTOs\MediaDTO;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO;
use Domain\Products\Models\Pivots\ProductProduct;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateProductAction extends BaseAction
{
    /**
     * @var \Domain\Common\Actions\SaveSeoAction
     */
    private SaveSeoAction $saveSeoAction;

    /**
     * @var \Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveInfoPricesAction
     */
    private SyncAndSaveInfoPricesAction $syncAndSaveInfoPricesAction;

    /**
     * @var \Domain\Common\Actions\SyncAndSaveMediasAction
     */
    private SyncAndSaveMediasAction $syncAndSaveMediasAction;

    /**
     * @var \Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveCharCategoriesAndCharsAction
     */
    private SyncAndSaveCharCategoriesAndCharsAction $syncAndSaveCharCategoriesAndCharsAction;

    /**
     * @var \Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveVariationsAction
     */
    private SyncAndSaveVariationsAction $syncAndSaveVariationsAction;

    /**
     * @param \Domain\Common\Actions\SaveSeoAction $saveSeoAction
     * @param \Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveInfoPricesAction $syncAndSaveInfoPricesAction
     * @param \Domain\Common\Actions\SyncAndSaveMediasAction $syncAndSaveMediasAction
     * @param \Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveCharCategoriesAndCharsAction $syncAndSaveCharCategoriesAndCharsAction
     * @param \Domain\Products\Actions\CreateOrUpdateProduct\SyncAndSaveVariationsAction $syncAndSaveVariationsAction
     */
    public function __construct(
        SaveSeoAction                           $saveSeoAction,
        SyncAndSaveInfoPricesAction             $syncAndSaveInfoPricesAction,
        SyncAndSaveMediasAction                 $syncAndSaveMediasAction,
        SyncAndSaveCharCategoriesAndCharsAction $syncAndSaveCharCategoriesAndCharsAction,
        SyncAndSaveVariationsAction $syncAndSaveVariationsAction
    ) {
        $this->saveSeoAction = $saveSeoAction;
        $this->syncAndSaveInfoPricesAction = $syncAndSaveInfoPricesAction;
        $this->syncAndSaveMediasAction = $syncAndSaveMediasAction;
        $this->syncAndSaveCharCategoriesAndCharsAction = $syncAndSaveCharCategoriesAndCharsAction;
        $this->syncAndSaveVariationsAction = $syncAndSaveVariationsAction;
    }

    /**
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     * @param \Domain\Products\Models\Product\Product|null $target
     *
     * @return \Domain\Products\Models\Product\Product
     */
    public function execute(ProductDTO $productDTO, Product $target = null): Product
    {
        return DB::transaction(function () use ($productDTO, $target) {
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
                $target->brand_id = $productDTO->brand_id !== 0 ? $productDTO->brand_id : null;
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

            $target->relatedCategories()->sync($productDTO->relatedCategoriesIds);

            $this->saveSeoAction->execute($target, $productDTO->seo);

            $this->syncAndSaveInfoPricesAction->execute($target, $productDTO->infoPrices);

            $this->saveInstructions($target, $productDTO->instructions);

            $this->saveMainImage($target, $productDTO->mainImage);

            $this->saveAdditionalImages($target, $productDTO->additionalImages);

            $this->syncAndSaveCharCategoriesAndCharsAction->execute($target, $productDTO->charCategories);

            $this->saveOtherProducts($target, $productDTO);

            $this->syncAndSaveVariationsAction->execute($target, $productDTO->variations);

            $target->save();

            return $target;
        });
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Common\DTOs\MediaDTO[] $mediaDTOs
     *
     * @return void
     */
    private function saveInstructions(Product $target, array $mediaDTOs)
    {
        $this->syncAndSaveMediasAction->execute($target, $mediaDTOs, Product::MC_FILES);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Common\DTOs\MediaDTO|null $mediaDTO
     *
     * @return void
     */
    private function saveMainImage(Product $target, MediaDTO $mediaDTO = null)
    {
        $this->syncAndSaveMediasAction->execute($target, $mediaDTO ? [ $mediaDTO ] : [], Product::MC_MAIN_IMAGE);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Common\DTOs\MediaDTO[] $mediaDTOs
     *
     * @return void
     */
    private function saveAdditionalImages(Product $target, array $mediaDTOs)
    {
        $this->syncAndSaveMediasAction->execute($target, $mediaDTOs, Product::MC_ADDITIONAL_IMAGES);
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     *
     * @return void
     */
    private function saveOtherProducts(Product $target, ProductDTO $productDTO)
    {
        $getReduceCB = fn (int $type) => function (array $acc, int $id) use ($type) {
            $acc[$id] = ["type" => $type];

            return $acc;
        };

        $syncAccessory = collect($productDTO->accessories)->reduce($getReduceCB(ProductProduct::TYPE_ACCESSORY), []);
        $target->accessory()->sync($syncAccessory);

        $syncSimilar = collect($productDTO->similar)->reduce($getReduceCB(ProductProduct::TYPE_SIMILAR), []);
        $target->similar()->sync($syncSimilar);

        $syncRelated = collect($productDTO->related)->reduce($getReduceCB(ProductProduct::TYPE_RELATED), []);
        $target->related()->sync($syncRelated);

        $syncWorks = collect($productDTO->works)->reduce($getReduceCB(ProductProduct::TYPE_WORK), []);
        $target->works()->sync($syncWorks);

        $syncInstruments = collect($productDTO->instruments)->reduce($getReduceCB(ProductProduct::TYPE_INSTRUMENT), []);
        $target->instruments()->sync($syncInstruments);
    }
}

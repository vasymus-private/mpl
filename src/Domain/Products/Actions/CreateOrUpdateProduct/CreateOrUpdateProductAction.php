<?php

namespace Domain\Products\Actions\CreateOrUpdateProduct;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO;
use Domain\Products\Models\Product\Product;

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

        // todo

        $target->save();

        return $target;
    }

    /**
     * @param \Domain\Products\Models\Product\Product $target
     * @param \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO $productDTO
     *
     * @return void
     */
    private function saveInstructions(Product $target, ProductDTO $productDTO)
    {
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

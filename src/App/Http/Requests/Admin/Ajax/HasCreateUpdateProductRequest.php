<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Common\Models\Currency;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\CharCategory;
use Domain\Products\Models\CharType;
use Domain\Products\Models\Product\Product;
use Support\H;

/**
 * @property-read string|null $name
 * @property-read string|null $slug
 * @property-read int|null $ordering
 * @property-read bool|null $is_active
 * @property-read string|null $unit
 * @property-read float|null $price_purchase
 * @property-read int|null $price_purchase_currency_id
 * @property-read float|null $price_retail
 * @property-read int|null $price_retail_currency_id
 * @property-read string|null $admin_comment
 * @property-read int|null $availability_status_id
 * @property-read int|null $brand_id
 * @property-read int|null $category_id
 * @property-read bool|null $is_with_variations
 * @property-read float|null $coefficient
 * @property-read string|null $coefficient_description
 * @property-read bool|null $coefficient_description_show
 * @property-read string|null $coefficient_variation_description
 * @property-read string|null $price_name
 * @property-read string|null $preview
 * @property-read string|null $description
 * @property-read string|null $accessory_name
 * @property-read string|null $similar_name
 * @property-read string|null $related_name
 * @property-read string|null $work_name
 * @property-read string|null $instruments_name
 * @property-read int[]|null $relatedCategoriesIds
 * @property-read array|null $seo
 * @property-read array|null $infoPrices
 * @property-read array|null $instructions
 * @property-read array|null $mainImage
 * @property-read array|null $additionalImages
 * @property-read array|null $charCategories
 * @property-read array|null $chars
 * @property-read int[]|null $accessories
 * @property-read int[]|null $similar
 * @property-read int[]|null $related
 * @property-read int[]|null $works
 * @property-read int[]|null $instruments
 * @property-read array|null $variations
 */
trait HasCreateUpdateProductRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $currenciesIdsStr = Currency::cachedAll()->implode('id', ',');
        $availabilityStatusIdsStr = AvailabilityStatus::cachedAll()->implode('id', ',');
        $brandIdsStr = Brand::cachedAll()->implode('id', ',');
        $categoriesIdsStr = Category::cachedAll()->implode('id', ',');
        $charTypeIds = CharType::cachedAll()->implode('id', ',');
        $charCategoryIds = CharCategory::cachedAll()->implode('id', ',');
        $productIds = Product::cachedAll()->implode('id', ',');

        return [
            'name' => 'required|string|max:250',
            'slug' => 'required|string|max:250',
            'ordering' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'unit' => 'nullable|string|max:250',
            'price_purchase' => 'nullable|numeric',
            'price_purchase_currency_id' => sprintf('nullable|integer|in:%s', $currenciesIdsStr),
            'price_retail' => 'nullable|numeric',
            'price_retail_currency_id' => sprintf('nullable|integer|in:%s', $currenciesIdsStr),
            'admin_comment' => 'nullable|string|max:250',
            'availability_status_id' => sprintf('nullable|integer|in:%s', $availabilityStatusIdsStr),
            'brand_id' => sprintf('nullable|integer|in:%s', $brandIdsStr),
            'category_id' => sprintf('nullable|integer|in:%s', $categoriesIdsStr),
            'is_with_variations' => 'nullable|boolean',
            'coefficient' => 'nullable|numeric',
            'coefficient_description' => 'nullable|string|max:250',
            'coefficient_description_show' => 'nullable|boolean',
            'coefficient_variation_description' => 'nullable|string|max:250',
            'price_name' => 'nullable|string|max:250',

            'preview' => 'nullable|string|max:65000',
            'description' => 'nullable|string|max:65000',

            'accessory_name' => 'nullable|string|max:250',
            'similar_name' => 'nullable|string|max:250',
            'related_name' => 'nullable|string|max:250',
            'work_name' => 'nullable|string|max:250',
            'instruments_name' => 'nullable|string|max:250',

            'relatedCategoriesIds' => 'nullable|array',
            'relatedCategoriesIds.*' => sprintf('nullable|integer|in:%s', $categoriesIdsStr),

            'seo' => 'nullable|array',
            'seo.title' => 'nullable|string|max:250',
            'seo.h1' => 'nullable|string|max:250',
            'seo.keywords' => 'nullable|string|max:65000',
            'seo.description' => 'nullable|string|max:65000',

            'infoPrices' => 'nullable|array',
            'infoPrices.*.id' => 'nullable|integer',
            'infoPrices.*.name' => 'nullable|string|max:250',
            'infoPrices.*.price' => 'nullable|numeric',

            'instructions' => 'nullable|array',
            'instructions.*.id' => 'nullable|integer',
            'instructions.*.uuid' => 'string',
            'instructions.*.name' => 'nullable|string|max:250',
            'instructions.*.file_name' => 'nullable|string|max:250',
            'instructions.*.order_column' => 'nullable|integer',
            'instructions.*.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'mainImage' => 'nullable|array',
            'mainImage.id' => 'nullable|integer',
            'mainImage.uuid' => 'string',
            'mainImage.name' => 'nullable|string|max:250',
            'mainImage.file_name' => 'nullable|string|max:250',
            'mainImage.order_column' => 'nullable|integer',
            'mainImage.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'additionalImages' => 'nullable|array',
            'additionalImages.*.id' => 'nullable|integer',
            'additionalImages.*.uuid' => 'string',
            'additionalImages.*.name' => 'nullable|string|max:250',
            'additionalImages.*.file_name' => 'nullable|string|max:250',
            'additionalImages.*.order_column' => 'nullable|integer',
            'additionalImages.*.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'charCategories' => 'nullable|array',
            'charCategories.*.id' => 'nullable|integer',
            'charCategories.*.uuid' => 'string',
            'charCategories.*.name' => 'nullable|string|max:250',
            'charCategories.*.ordering' => 'nullable|integer',

            'chars' => 'nullable|array',
            'chars.*.id' => 'nullable|integer',
            'chars.*.name' => 'nullable|string|max:250',
            'chars.*.value' => 'nullable|string|max:250',
            'chars.*.type_id' => sprintf('nullable|integer|in:%s', $charTypeIds),
            'chars.*.ordering' => 'nullable|integer',
            'chars.*.category_id' => sprintf('nullable|integer|in:%s', $charCategoryIds),
            'chars.*.category_uuid' => 'nullable|string',

            'accessories' => 'nullable|array',
            'accessories.*' => sprintf('nullable|integer|in:%s', $productIds),

            'similar' => 'nullable|array',
            'similar.*' => sprintf('nullable|integer|in:%s', $productIds),

            'related' => 'nullable|array',
            'related.*' => sprintf('nullable|integer|in:%s', $productIds),

            'works' => 'nullable|array',
            'works.*' => sprintf('nullable|integer|in:%s', $productIds),

            'instruments' => 'nullable|array',
            'instruments.*' => sprintf('nullable|integer|in:%s', $productIds),

            'variations' => 'nullable|array',
            'variations.*.id' => 'nullable|integer',
            'variations.*.uuid' => 'string',
            'variations.*.name' => 'nullable|string|max:250',
            'variations.*.is_active' => 'nullable|boolean',
            'variations.*.ordering' => 'nullable|integer',
            'variations.*.coefficient' => 'nullable|numeric',
            'variations.*.coefficient_description' => 'nullable|string|max:250',
            'variations.*.unit' => 'nullable|string|max:250',
            'variations.*.availability_status_id' => sprintf('nullable|integer|in:%s', $availabilityStatusIdsStr),
            'variations.*.price_purchase' => 'nullable|numeric',
            'variations.*.price_purchase_currency_id' => sprintf('nullable|integer|in:%s', $currenciesIdsStr),
            'variations.*.price_retail' => 'nullable|numeric',
            'variations.*.price_retail_currency_id' => sprintf('nullable|integer|in:%s', $currenciesIdsStr),
            'variations.*.preview' => 'nullable|string|max:65000',

            'variations.*.mainImage' => 'nullable|array',
            'variations.*.mainImage.id' => 'nullable|integer',
            'variations.*.mainImage.uuid' => 'string',
            'variations.*.mainImage.name' => 'nullable|string|max:250',
            'variations.*.mainImage.file_name' => 'nullable|string|max:250',
            'variations.*.mainImage.order_column' => 'nullable|integer',
            'variations.*.mainImage.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'variations.*.additionalImages' => 'nullable|array',
            'variations.*.additionalImages.*.id' => 'nullable|integer',
            'variations.*.additionalImages.*.uuid' => 'string',
            'variations.*.additionalImages.*.name' => 'nullable|string|max:250',
            'variations.*.additionalImages.*.file_name' => 'nullable|string|max:250',
            'variations.*.additionalImages.*.order_column' => 'nullable|integer',
            'variations.*.additionalImages.*.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),
        ];
    }

    /**
     * @return \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO
     */
    public function prepare(): ProductDTO
    {

    }
}

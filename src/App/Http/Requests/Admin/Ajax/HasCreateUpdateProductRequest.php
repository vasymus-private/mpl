<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Common\Models\Currency;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Support\H;

/**
 * @property string|null $name
 * @property string|null $slug
 * @property int|null $ordering
 * @property bool|null $is_active
 * @property string|null $unit
 * @property float|null $price_purchase
 * @property int|null $price_purchase_currency_id
 * @property float|null $price_retail
 * @property int|null $price_retail_currency_id
 * @property string|null $admin_comment
 * @property int|null $availability_status_id
 * @property int|null $parent_id
 * @property int|null $brand_id
 * @property int|null $category_id
 * @property bool|null $is_with_variations
 * @property float|null $coefficient
 * @property string|null $coefficient_description
 * @property bool|null $coefficient_description_show
 * @property string|null $coefficient_variation_description
 * @property string|null $price_name
 * @property string|null $preview
 * @property string|null $description
 * @property string|null $accessory_name
 * @property string|null $similar_name
 * @property string|null $related_name
 * @property string|null $work_name
 * @property string|null $instruments_name
 * @property array|null $seo
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
        return [
            'name' => 'required|string|max:250',
            'slug' => 'required|string|max:250',
            'ordering' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'unit' => 'nullable|string|max:250',
            'price_purchase' => 'nullable|numeric',
            'price_purchase_currency_id' => sprintf('nullable|integer|in:%s', Currency::cachedAll()->implode('id', ',')),
            'price_retail' => 'nullable|numeric',
            'price_retail_currency_id' => sprintf('nullable|integer|in:%s', Currency::cachedAll()->implode('id', ',')),
            'admin_comment' => 'nullable|string|max:250',
            'availability_status_id' => sprintf('nullable|integer|in:%s', AvailabilityStatus::cachedAll()->implode('id', ',')),
            'brand_id' => sprintf('nullable|integer|in:%s', Brand::cachedAll()->implode('id', ',')),
            'category_id' => sprintf('nullable|integer|in:%s', Category::cachedAll()->implode('id', ',')),
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
            'relatedCategoriesIds.*' => sprintf('nullable|integer|in:%s', Category::cachedAll()->implode('id', ',')),

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
        ];
    }

    /**
     * @return \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO
     */
    public function prepare(): ProductDTO
    {
    }
}

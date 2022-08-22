<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Common\Models\Currency;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;

/**
 * @property string|null $name
 * @property string|null $slug
 * @property integer|null $ordering
 * @property bool|null $is_active
 * @property string|null $unit
 * @property float|null $price_purchase
 * @property integer|null $price_purchase_currency_id
 * @property float|null $price_retail
 * @property integer|null $price_retail_currency_id
 * @property string|null $admin_comment
 * @property integer|null $availability_status_id
 * @property integer|null $parent_id
 * @property integer|null $brand_id
 * @property integer|null $category_id
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
            'brand_id' => sprintf('nullable|integer|in:%s', Brand::cachedAll()->implode('id', '')),
            'category_id' => sprintf('nullable|integer|in:%s', Category::cachedAll()->implode('id', '')),
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
        ];
    }
}

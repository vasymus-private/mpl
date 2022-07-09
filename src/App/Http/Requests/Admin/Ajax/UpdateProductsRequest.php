<?php

namespace App\Http\Requests\Admin\Ajax;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string|null $name
 * @property string|null $slug
 * @property number|null $ordering
 * @property bool|null $is_active
 * @property string|null $unit
 * @property number|null $price_purchase
 * @property number|null $price_purchase_currency_id
 * @property number|null $price_retail
 * @property number|null $price_retail_currency_id
 * @property string|null $admin_comment
 * @property number|null $availability_status_id
 * @property number|null $parent_id
 * @property number|null $brand_id
 * @property number|null $category_id
 * @property bool|null $is_with_variations
 * @property number|null $coefficient
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
class UpdateProductsRequest extends FormRequest
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
            'name' => 'nullable|string',
            'slug' => 'nullable|string',
            'ordering' => 'nullable|number',
            'is_active' => 'nullable|boolean',
            'unit' => 'nullable|string',
            'price_purchase' => 'nullable|number',
            'price_purchase_currency_id' => 'nullable|number',
            'price_retail' => 'nullable|number',
            'price_retail_currency_id' => 'nullable|number',
            'admin_comment' => 'nullable|string',
            'availability_status_id' => 'nullable|number',
            'parent_id' => 'nullable|number',
            'brand_id' => 'nullable|number',
            'category_id' => 'nullable|number',
            'is_with_variations' => 'nullable|boolean',
            'coefficient' => 'nullable|number',
            'coefficient_description' => 'nullable|string',
            'coefficient_description_show' => 'nullable|boolean',
            'coefficient_variation_description' => 'nullable|string',
            'price_name' => 'nullable|string',
            'preview' => 'nullable|string',
            'description' => 'nullable|string',
            'accessory_name' => 'nullable|string',
            'similar_name' => 'nullable|string',
            'related_name' => 'nullable|string',
            'work_name' => 'nullable|string',
            'instruments_name' => 'nullable|string',

            'seo' => 'nullable|array',
            'seo.title' => 'nullable|string',
            'seo.h1' => 'nullable|string',
            'seo.keywords' => 'nullable|string',
            'seo.description' => 'nullable|string',
        ];
    }
}

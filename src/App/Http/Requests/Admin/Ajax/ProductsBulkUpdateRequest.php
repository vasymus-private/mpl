<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Common\Models\Currency;
use Domain\Products\DTOs\Admin\Inertia\ProductsListUpdateDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Support\H;

/**
 * @property-read array[] $products
 */
class ProductsBulkUpdateRequest extends FormRequest
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
        $categoriesIdsStr = Category::cachedAll()->implode('id', ',');

        return [
            'products.*.id' => 'required|integer',
            'products.*.name' => 'required|string|max:250',
            'products.*.ordering' => 'integer|nullable',
            'products.*.is_active' => 'nullable|boolean',
            'products.*.unit' => 'nullable|string|max:250',
            'products.*.price_purchase' => 'nullable|numeric',
            'products.*.price_purchase_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
            'products.*.price_retail' => 'nullable|numeric',
            'products.*.price_retail_currency_id' => 'nullable|int|exists:' . Currency::class . ',id',
            'products.*.admin_comment' => 'nullable|string|max:250',
            'products.*.availability_status_id' => 'required|integer|exists:' . AvailabilityStatus::class . ",id",
            'category_id' => sprintf('nullable|integer|in:%s', $categoriesIdsStr),
            'relatedCategoriesIds' => 'nullable|array',
            'relatedCategoriesIds.*' => sprintf('nullable|integer|in:%s', $categoriesIdsStr),
        ];
    }

    /**
     * @return \Domain\Products\DTOs\Admin\Inertia\ProductsListUpdateDTO[]
     * @phpstan-return array<int, \Domain\Products\DTOs\Admin\Inertia\ProductsListUpdateDTO>
     */
    public function payload(): array
    {
        return collect($this->products)
            ->map(fn (array $item) => new ProductsListUpdateDTO([
                'id' => (int)$item['id'],
                'name' => (string)$item['name'],
                'ordering' => isset($item['ordering']) ? (int)$item['ordering'] : null,
                'is_active' => isset($item['is_active']) ? (bool)$item['is_active'] : null,
                'unit' => isset($item['unit']) ? (string)$item['unit'] : null,
                'price_purchase' => isset($item['price_purchase']) ? (float)$item['price_purchase'] : null,
                'price_purchase_currency_id' => H::nullableIntValue('price_purchase_currency_id', $item),
                'price_retail' => isset($item['price_retail']) ? (float)$item['price_retail'] : null,
                'price_retail_currency_id' => H::nullableIntValue('price_retail_currency_id', $item),
                'admin_comment' => isset($item['admin_comment']) ? (string)$item['admin_comment'] : null,
                'availability_status_id' => H::nullableIntValue('availability_status_id', $item),
                'category_id' => H::nullableIntValue('category_id', $item),
                'relatedCategoriesIds' => isset($item['relatedCategoriesIds'])
                    ? collect($item['relatedCategoriesIds'])->map(fn ($id) => (int)$id)->all()
                    : [],
            ]))
            ->keyBy('id')
            ->all();
    }
}

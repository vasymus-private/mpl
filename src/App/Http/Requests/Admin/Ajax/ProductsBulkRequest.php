<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Common\Models\Currency;
use Domain\Products\DTOs\Admin\ProductListUpdateDTO;
use Domain\Products\Models\AvailabilityStatus;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array[] $products
 */
class ProductsBulkRequest extends FormRequest
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
        ];
    }

    /**
     * @return \Domain\Products\DTOs\Admin\ProductListUpdateDTO[]
     * @phpstan-return <int, \Domain\Products\DTOs\Admin\ProductListUpdateDTO>
     */
    public function productsPayload(): array
    {
        return collect($this->products)->reduce(function (array $acc, array $item) {
            $dto = new ProductListUpdateDTO([
                'id' => (int)$item['id'],
                'name' => (string)$item['name'],
                'ordering' => isset($item['ordering']) ? (int)$item['ordering'] : null,
                'is_active' => isset($item['is_active']) ? (bool)$item['is_active'] : null,
                'unit' => isset($item['unit']) ? (string)$item['unit'] : null,
                'price_purchase' => isset($item['price_purchase']) ? (float)$item['price_purchase'] : null,
                'price_purchase_currency_id' => isset($item['price_purchase_currency_id']) ? (int)$item['price_purchase_currency_id'] : null,
                'price_retail' => isset($item['price_retail']) ? (float)$item['price_retail'] : null,
                'price_retail_currency_id' => isset($item['price_retail_currency_id']) ? (int)$item['price_retail_currency_id'] : null,
                'admin_comment' => isset($item['admin_comment']) ? (string)$item['admin_comment'] : null,
                'availability_status_id' => isset($item['availability_status_id']) ? (int)$item['availability_status_id'] : null,
            ]);

            $acc[$dto->id] = $dto;

            return $acc;
        }, []);
    }
}

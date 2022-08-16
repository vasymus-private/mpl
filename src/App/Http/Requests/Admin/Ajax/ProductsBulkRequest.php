<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Products\DTOs\Admin\ProductListUpdateDTO;
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
            'products.*.name' => 'required|string|max:250',
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
            ]);

            $acc[$dto->id] = $dto;

            return $acc;
        }, []);
    }
}

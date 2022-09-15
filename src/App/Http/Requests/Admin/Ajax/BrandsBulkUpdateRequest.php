<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Products\DTOs\Admin\Inertia\BrandsListUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array[] $brands
 */
class BrandsBulkUpdateRequest extends FormRequest
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
            'brands.*.id' => 'required|integer',
            'brands.*.name' => 'required|string|max:250',
            'brands.*.ordering' => 'integer|nullable',
            'brands.*.preview' => 'nullable|string|max:65000',
        ];
    }

    /**
     * @return \Domain\Products\DTOs\Admin\Inertia\BrandsListUpdateDTO[]
     * @phpstan-return array<int, \Domain\Products\DTOs\Admin\Inertia\BrandsListUpdateDTO>
     */
    public function payload(): array
    {
        return collect($this->brands)
            ->map(fn (array $item) => new BrandsListUpdateDTO([
                'id' => (int)$item['id'],
                'name' => (string)$item['name'],
                'ordering' => isset($item['ordering']) ? (int)$item['ordering'] : null,
                'preview' => isset($item['preview']) ? (string)$item['preview'] : null,
            ]))
            ->keyBy('id')
            ->all();
    }
}

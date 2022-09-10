<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Products\DTOs\Admin\Inertia\CategoriesListUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array[] $categories
 */
class CategoriesBulkRequest extends FormRequest
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
            'categories.*.id' => 'required|integer',
            'categories.*.name' => 'required|string|max:250',
            'categories.*.ordering' => 'integer|nullable',
            'categories.*.is_active' => 'nullable|boolean',
        ];
    }

    /**
     * @return \Domain\Products\DTOs\Admin\Inertia\CategoriesListUpdateDTO[]
     * @phpstan-return array<int, \Domain\Products\DTOs\Admin\Inertia\CategoriesListUpdateDTO>
     */
    public function payload(): array
    {
        return collect($this->categories)
            ->map(fn(array $item) => new CategoriesListUpdateDTO([
                'id' => (int)$item['id'],
                'name' => (string)$item['name'],
                'ordering' => isset($item['ordering']) ? (int)$item['ordering'] : null,
                'is_active' => isset($item['is_active']) ? (bool)$item['is_active'] : null,
            ]))
            ->keyBy('id')
            ->all();
    }
}

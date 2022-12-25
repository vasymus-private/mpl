<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Products\DTOs\Admin\Inertia\CreateEditCategory\CategoryDTO;
use Domain\Common\DTOs\SeoDTO;
use Domain\Products\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class CreateUpdateCategoryRequest extends FormRequest
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
            'parent_id' => [
                'nullable',
                Rule::exists(Category::TABLE, 'id')
                    ->when(
                        $this->category(),
                        fn (Exists $query) => $query->whereNot('id', [$this->category()->id])
                    ),
            ],
            'description' => 'nullable|string|max:65000',

            'seo' => 'nullable|array',
            'seo.title' => 'nullable|string|max:250',
            'seo.h1' => 'nullable|string|max:250',
            'seo.keywords' => 'nullable|string|max:65000',
            'seo.description' => 'nullable|string|max:65000',
        ];
    }

    /**
     * @return \Domain\Products\Models\Category|null
     */
    public function category(): ?Category
    {
        /** @var \Domain\Products\Models\Category|null $category */
        $category = $this->admin_category;

        return $category;
    }

    /**
     * @return \Domain\Products\DTOs\Admin\Inertia\CreateEditCategory\CategoryDTO
     */
    public function prepare(): CategoryDTO
    {
        $payload = $this->all();

        return new CategoryDTO([
            'name' => isset($payload['name'])
                ? (string)$payload['name']
                : null,
            'slug' => isset($payload['slug'])
                ? (string)$payload['slug']
                : null,
            'ordering' => isset($payload['ordering'])
                ? (int)$payload['ordering']
                : null,
            'is_active' => isset($payload['is_active'])
                ? (bool)$payload['is_active']
                : null,
            'parent_id' => isset($payload['parent_id'])
                ? (int)$payload['parent_id']
                : null,
            'description' => isset($payload['description'])
                ? (string)$payload['description']
                : null,
            'seo' => isset($payload['seo'])
                ? new SeoDTO($payload['seo'])
                : null,
        ]);
    }
}

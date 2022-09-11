<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Products\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * @property-read array[] $ids
 */
class CategoriesBulkDeleteRequest extends FormRequest
{
    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Category[]|null
     */
    protected $categories;

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
            'ids' => 'required|array',
            'ids.*' => sprintf('exists:%s,id', Category::class),
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $this->getCategories()->each(function (Category $category) use ($validator) {
                if (! $category->has_active_products) {
                    return;
                }

                $validator->errors()->add(sprintf('category.%s', $category->id), sprintf('Категория с id %s не может быть удалена, пока у этой категории и или у её подкатегорий есть активные продукты.', $category->id));
            });
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Category[]
     */
    public function getCategories()
    {
        if ($this->categories) {
            return $this->categories;
        }

        $this->categories = Category::query()->whereIn('id', $this->ids)->get();

        return $this->categories;
    }
}

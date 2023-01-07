<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Articles\Models\Article;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array[] $ids
 */
class ArticlesBulkDeleteRequest extends FormRequest
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
            'ids' => 'required|array',
            'ids.*' => sprintf('exists:%s,id', Article::class),
        ];
    }
}

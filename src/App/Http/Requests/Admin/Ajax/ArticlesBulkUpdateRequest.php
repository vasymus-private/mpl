<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Articles\DTOs\ArticleListUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array[] $articles
 */
class ArticlesBulkUpdateRequest extends FormRequest
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
            'articles.*.id' => 'required|integer',
            'articles.*.name' => 'required|string|max:250',
            'articles.*.is_active' => 'nullable|boolean',
        ];
    }

    /**
     * @return \Domain\Articles\DTOs\ArticleListUpdateDTO[]
     * @phpstan-return array<int, \Domain\Articles\DTOs\ArticleListUpdateDTO>
     */
    public function payload(): array
    {
        return collect($this->articles)
            ->map(fn (array $item) => new ArticleListUpdateDTO([
                'id' => (int)$item['id'],
                'name' => (string)$item['name'],
                'is_active' => isset($item['is_active']) ? (int)$item['is_active'] : null,
            ]))
            ->keyBy('id')
            ->all();
    }
}

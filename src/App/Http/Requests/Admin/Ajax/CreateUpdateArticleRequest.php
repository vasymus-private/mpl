<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Articles\DTOs\ArticleDTO;
use Domain\Articles\Models\Article;
use Domain\Common\DTOs\SeoDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * @property-read string|null $name
 * @property-read string|null $slug
 * @property-read bool|null $is_active
 * @property-read int|null $parent_id
 * @property-read string|null $description
 * @property-read array|null $seo
 */
class CreateUpdateArticleRequest extends FormRequest
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
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string|max:65000',
            'parent_id' => sprintf('nullable|integer|exists:%s,id', Article::class),

            'seo' => 'nullable|array',
            'seo.title' => 'nullable|string|max:250',
            'seo.h1' => 'nullable|string|max:250',
            'seo.keywords' => 'nullable|string|max:65000',
            'seo.description' => 'nullable|string|max:65000',
        ];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if (! $this->parent_id) {
                return;
            }

            if (! $this->current()) {
                return;
            }

            if ((string)$this->current()->id !== (string)$this->parent_id) {
                return;
            }

            $validator->errors()->add('parent_id', 'Parent Article shouldn\'t be itself.');
        });
    }

    /**
     * @return \Domain\Articles\DTOs\ArticleDTO
     */
    public function prepare(): ArticleDTO
    {
        $payload = $this->all();

        return new ArticleDTO([
            'name' => isset($payload['name'])
                ? (string)$payload['name']
                : null,
            'slug' => isset($payload['slug'])
                ? (string)$payload['slug']
                : null,
            'parent_id' => array_key_exists('parent_id', $payload)
                ? (int)$payload['parent_id']
                : null,
            'is_active' => isset($payload['is_active'])
                ? (bool)$payload['is_active']
                : null,
            'description' => isset($payload['description'])
                ? (string)$payload['description']
                : null,
            'seo' => isset($payload['seo'])
                ? new SeoDTO($payload['seo'])
                : null,
        ]);
    }

    /**
     * @return \Domain\Articles\Models\Article|null
     */
    public function current(): ?Article
    {
        /** @var \Domain\Articles\Models\Article $article */
        $article = $this->admin_article;

        return $article;
    }
}

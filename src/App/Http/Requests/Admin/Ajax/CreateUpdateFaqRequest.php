<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Common\DTOs\SeoDTO;
use Domain\FAQs\DTOs\FaqDTO;
use Domain\FAQs\Models\FAQ;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * @property-read string|null $name
 * @property-read string|null $slug
 * @property-read bool|null $is_active
 * @property-read int|null $parent_id
 * @property-read string|null $question
 * @property-read string|null $answer
 * @property-read array|null $seo
 */
class CreateUpdateFaqRequest extends FormRequest
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
            'question' => 'nullable|string|max:65000',
            'answer' => 'nullable|string|max:65000',
            'parent_id' => sprintf('nullable|integer|exists:%s,id', FAQ::class),

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
        $validator->after(function(Validator $validator) {
            if (!$this->parent_id) {
                return;
            }

            if (!$this->current()) {
                return;
            }

            if ((string)$this->current()->id !== (string)$this->parent_id) {
                return;
            }

            $validator->errors()->add('parent_id', 'Parent FAQ shouldn\'t be itself.');
        });
    }

    /**
     * @return \Domain\FAQs\DTOs\FaqDTO
     */
    public function prepare(): FaqDTO
    {
        $payload = $this->all();

        return new FaqDTO([
            'name' => isset($payload['name'])
                ? (string)$payload['name']
                : null,
            'slug' => isset($payload['slug'])
                ? (string)$payload['slug']
                : null,
            'parent_id' => isset($payload['parent_id'])
                ? (int)$payload['parent_id']
                : null,
            'is_active' => isset($payload['is_active'])
                ? (bool)$payload['is_active']
                : null,
            'question' => isset($payload['question'])
                ? (string)$payload['question']
                : null,
            'answer' => isset($payload['answer'])
                ? (string)$payload['answer']
                : null,
            'seo' => isset($payload['seo'])
                ? new SeoDTO($payload['seo'])
                : null,
        ]);
    }

    /**
     * @return \Domain\FAQs\Models\FAQ|null
     */
    protected function current(): ?FAQ
    {
        /** @var \Domain\FAQs\Models\FAQ $faq */
        $faq = $this->admin_faq;
        return $faq;
    }
}

<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\FAQs\DTOs\FaqListUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array[] $faqs
 */
class FaqBulkUpdateRequest extends FormRequest
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
            'faqs.*.id' => 'required|integer',
            'faqs.*.name' => 'required|string|max:250',
            'faqs.*.is_active' => 'nullable|boolean',
        ];
    }

    /**
     * @return \Domain\FAQs\DTOs\FaqListUpdateDTO[]
     * @phpstan-return array<int, \Domain\FAQs\DTOs\FaqListUpdateDTO>
     */
    public function payload(): array
    {
        return collect($this->faqs)
            ->map(fn (array $item) => new FaqListUpdateDTO([
                'id' => (int)$item['id'],
                'name' => (string)$item['name'],
                'is_active' => isset($item['is_active']) ? (bool)$item['is_active'] : null,
            ]))
            ->keyBy('id')
            ->all();
    }
}

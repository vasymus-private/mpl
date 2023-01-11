<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Users\DTOs\BlacklistItemUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array[] $blacklistItems
 */
class BlacklistBulkUpdateRequest extends FormRequest
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
            'blacklistItems.*.id' => 'required|integer',
            'blacklistItems.*.email' => 'nullable|string|max:250',
            'blacklistItems.*.ip' => 'nullable|string|max:250',
        ];
    }

    /**
     * @return \Domain\Users\DTOs\BlacklistItemUpdateDTO[]
     * @phpstan-return array<int, \Domain\Users\DTOs\BlacklistItemUpdateDTO>
     */
    public function payload(): array
    {
        return collect($this->blacklistItems)
            ->map(fn (array $item) => new BlacklistItemUpdateDTO([
                'id' => (int)$item['id'],
                'ip' => isset($item['ip']) ? (string)$item['ip'] : null,
                'email' => isset($item['email']) ? (string)$item['email'] : null,
            ]))
            ->keyBy('id')
            ->all();
    }
}

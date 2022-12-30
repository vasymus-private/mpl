<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\GalleryItems\DTOs\GalleryItemListUpdateDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array[] $galleryItems
 */
class GalleryItemBulkUpdateRequest extends FormRequest
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
            'galleryItems.*.id' => 'required|integer',
            'galleryItems.*.name' => 'required|string|max:250',
            'galleryItems.*.is_active' => 'nullable|boolean',
        ];
    }

    /**
     * @return \Domain\GalleryItems\DTOs\GalleryItemListUpdateDTO[]
     * @phpstan-return array<int, \Domain\GalleryItems\DTOs\GalleryItemListUpdateDTO>
     */
    public function payload(): array
    {
        return collect($this->galleryItems)
            ->map(fn (array $item) => new GalleryItemListUpdateDTO([
                'id' => (int)$item['id'],
                'name' => (string)$item['name'],
                'is_active' => isset($item['is_active']) ? (int)$item['is_active'] : null,
            ]))
            ->keyBy('id')
            ->all();
    }
}

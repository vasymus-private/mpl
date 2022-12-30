<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Common\DTOs\MediaDTO;
use Domain\Common\DTOs\SeoDTO;
use Domain\GalleryItems\DTOs\GalleryItemDTO;
use Domain\GalleryItems\Models\GalleryItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Support\H;

/**
 * @property-read string|null $name
 * @property-read string|null $slug
 * @property-read bool|null $is_active
 * @property-read int|null $parent_id
 * @property-read string|null $description
 * @property-read array|null $seo
 * @property-read array|null $mainImage
 */
class CreateUpdateGalleryItemsRequest extends FormRequest
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
            'name' => 'nullable|string|max:250',
            'slug' => 'nullable|string|max:250',
            'is_active' => 'nullable|boolean',
            'description' => 'nullable|string|max:65000',
            'parent_id' => sprintf('nullable|integer|exists:%s,id', GalleryItem::class),
            'ordering' => 'nullable|integer',

            'seo' => 'nullable|array',
            'seo.title' => 'nullable|string|max:250',
            'seo.h1' => 'nullable|string|max:250',
            'seo.keywords' => 'nullable|string|max:65000',
            'seo.description' => 'nullable|string|max:65000',

            'mainImage' => 'nullable|array',
            'mainImage.id' => 'nullable|integer',
            'mainImage.uuid' => 'string',
            'mainImage.name' => 'nullable|string|max:250',
            'mainImage.file_name' => 'nullable|string|max:250',
            'mainImage.order_column' => 'nullable|integer',
            'mainImage.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),
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

            $validator->errors()->add('parent_id', 'Parent Gallery Item shouldn\'t be itself.');
        });
    }

    /**
     * @return \Domain\GalleryItems\DTOs\GalleryItemDTO
     */
    public function prepare(): GalleryItemDTO
    {
        $payload = $this->all();

        $mediaCB = fn (array $media) => MediaDTO::create($media);

        return new GalleryItemDTO([
            'name' => isset($payload['name'])
                ? (string)$payload['name']
                : null,
            'slug' => isset($payload['slug'])
                ? (string)$payload['slug']
                : null,
            'parent_id' => array_key_exists('parent_id', $payload)
                ? (int)$payload['parent_id']
                : null,
            'ordering' => array_key_exists('ordering', $payload)
                ? (int)$payload['ordering']
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
            'mainImage' => isset($payload['mainImage'])
                ? $mediaCB($payload['mainImage'])
                : null,
        ]);
    }

    /**
     * @return \Domain\GalleryItems\Models\GalleryItem|null
     */
    protected function current(): ?GalleryItem
    {
        /** @var \Domain\GalleryItems\Models\GalleryItem|null $galleryItem */
        $galleryItem = $this->admin_gallery_item;

        return $galleryItem;
    }
}

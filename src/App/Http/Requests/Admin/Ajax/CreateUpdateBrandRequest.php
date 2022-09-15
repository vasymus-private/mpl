<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Products\DTOs\Admin\Inertia\BrandDTO;
use Domain\Products\DTOs\Admin\Inertia\MediaDTO;
use Domain\Products\DTOs\Admin\Inertia\SeoDTO;
use Illuminate\Foundation\Http\FormRequest;
use Support\H;

class CreateUpdateBrandRequest extends FormRequest
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
            'preview' => 'nullable|string|max:65000',
            'description' => 'nullable|string|max:65000',

            'mainImage' => 'nullable|array',
            'mainImage.id' => 'nullable|integer',
            'mainImage.uuid' => 'string',
            'mainImage.name' => 'nullable|string|max:250',
            'mainImage.file_name' => 'nullable|string|max:250',
            'mainImage.order_column' => 'nullable|integer',
            'mainImage.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'seo' => 'nullable|array',
            'seo.title' => 'nullable|string|max:250',
            'seo.h1' => 'nullable|string|max:250',
            'seo.keywords' => 'nullable|string|max:65000',
            'seo.description' => 'nullable|string|max:65000',
        ];
    }

    /**
     * @return \Domain\Products\DTOs\Admin\Inertia\BrandDTO
     */
    public function prepare(): BrandDTO
    {
        $payload = $this->all();

        $mediaCB = fn (array $media) => new MediaDTO([
            'id' => isset($media['id']) ? (int)$media['id'] : null,
            'uuid' => isset($media['uuid']) ? (string)$media['uuid'] : null,
            'name' => isset($media['name']) ? (string)$media['name'] : null,
            'file_name' => isset($media['file_name']) ? (string)$media['file_name'] : null,
            'order_column' => isset($media['order_column']) ? (int)$media['order_column'] : null,
            'file' => $media['file'] ?? null,
        ]);

        return new BrandDTO([
            'name' => isset($payload['name'])
                ? (string)$payload['name']
                : null,
            'slug' => isset($payload['slug'])
                ? (string)$payload['slug']
                : null,
            'ordering' => isset($payload['ordering'])
                ? (int)$payload['ordering']
                : null,
            'preview' => isset($payload['preview'])
                ? (string)$payload['preview']
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
}

<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Common\Models\Currency;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharCategoryDTO;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\CharDTO;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\InfoPriceDTO;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\MediaDTO;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO;
use Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\VariationDTO;
use Domain\Products\DTOs\Admin\Inertia\SeoDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\CharType;
use Domain\Products\Models\Product\Product;
use Illuminate\Foundation\Http\FormRequest;
use Support\H;

/**
 * @property-read string|null $name
 * @property-read string|null $slug
 * @property-read int|null $ordering
 * @property-read bool|null $is_active
 * @property-read string|null $unit
 * @property-read float|null $price_purchase
 * @property-read int|null $price_purchase_currency_id
 * @property-read float|null $price_retail
 * @property-read int|null $price_retail_currency_id
 * @property-read string|null $admin_comment
 * @property-read int|null $availability_status_id
 * @property-read int|null $brand_id
 * @property-read int|null $category_id
 * @property-read bool|null $is_with_variations
 * @property-read float|null $coefficient
 * @property-read string|null $coefficient_description
 * @property-read bool|null $coefficient_description_show
 * @property-read string|null $coefficient_variation_description
 * @property-read string|null $price_name
 * @property-read string|null $preview
 * @property-read string|null $description
 * @property-read string|null $accessory_name
 * @property-read string|null $similar_name
 * @property-read string|null $related_name
 * @property-read string|null $work_name
 * @property-read string|null $instruments_name
 * @property-read int[]|null $relatedCategoriesIds
 * @property-read array|null $seo
 * @property-read array|null $infoPrices
 * @property-read array|null $instructions
 * @property-read array|null $mainImage
 * @property-read array|null $additionalImages
 * @property-read array|null $charCategories
 * @property-read array|null $chars
 * @property-read int[]|null $accessories
 * @property-read int[]|null $similar
 * @property-read int[]|null $related
 * @property-read int[]|null $works
 * @property-read int[]|null $instruments
 * @property-read array|null $variations
 */
class CreateUpdateProductRequest extends FormRequest
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
        $currenciesIdsStr = Currency::cachedAll()->implode('id', ',');
        $availabilityStatusIdsStr = AvailabilityStatus::cachedAll()->implode('id', ',');
        $brandIdsStr = Brand::cachedAll()->implode('id', ',');
        $categoriesIdsStr = Category::cachedAll()->implode('id', ',');
        $charTypeIds = CharType::cachedAll()->implode('id', ',');
        $productIds = Product::cachedAll()->implode('id', ',');

        return [
            'name' => 'required|string|max:250',
            'slug' => 'required|string|max:250',
            'ordering' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'unit' => 'nullable|string|max:250',
            'price_purchase' => 'nullable|numeric',
            'price_purchase_currency_id' => sprintf('nullable|integer|in:%s', $currenciesIdsStr),
            'price_retail' => 'nullable|numeric',
            'price_retail_currency_id' => sprintf('nullable|integer|in:%s', $currenciesIdsStr),
            'admin_comment' => 'nullable|string|max:250',
            'availability_status_id' => sprintf('nullable|integer|in:%s', $availabilityStatusIdsStr),
            'brand_id' => sprintf('nullable|integer|in:%s', $brandIdsStr),
            'category_id' => sprintf('nullable|integer|in:%s', $categoriesIdsStr),
            'is_with_variations' => 'nullable|boolean',
            'coefficient' => 'nullable|numeric',
            'coefficient_description' => 'nullable|string|max:250',
            'coefficient_description_show' => 'nullable|boolean',
            'coefficient_variation_description' => 'nullable|string|max:250',
            'price_name' => 'nullable|string|max:250',

            'preview' => 'nullable|string|max:65000',
            'description' => 'nullable|string|max:65000',

            'accessory_name' => 'nullable|string|max:250',
            'similar_name' => 'nullable|string|max:250',
            'related_name' => 'nullable|string|max:250',
            'work_name' => 'nullable|string|max:250',
            'instruments_name' => 'nullable|string|max:250',

            'relatedCategoriesIds' => 'nullable|array',
            'relatedCategoriesIds.*' => sprintf('nullable|integer|in:%s', $categoriesIdsStr),

            'seo' => 'nullable|array',
            'seo.title' => 'nullable|string|max:250',
            'seo.h1' => 'nullable|string|max:250',
            'seo.keywords' => 'nullable|string|max:65000',
            'seo.description' => 'nullable|string|max:65000',

            'infoPrices' => 'nullable|array',
            'infoPrices.*.id' => 'nullable|integer',
            'infoPrices.*.name' => 'nullable|string|max:250',
            'infoPrices.*.price' => 'nullable|numeric',

            'instructions' => 'nullable|array',
            'instructions.*.id' => 'nullable|integer',
            'instructions.*.uuid' => 'string',
            'instructions.*.name' => 'nullable|string|max:250',
            'instructions.*.file_name' => 'nullable|string|max:250',
            'instructions.*.order_column' => 'nullable|integer',
            'instructions.*.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'mainImage' => 'nullable|array',
            'mainImage.id' => 'nullable|integer',
            'mainImage.uuid' => 'string',
            'mainImage.name' => 'nullable|string|max:250',
            'mainImage.file_name' => 'nullable|string|max:250',
            'mainImage.order_column' => 'nullable|integer',
            'mainImage.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'additionalImages' => 'nullable|array',
            'additionalImages.*.id' => 'nullable|integer',
            'additionalImages.*.uuid' => 'string',
            'additionalImages.*.name' => 'nullable|string|max:250',
            'additionalImages.*.file_name' => 'nullable|string|max:250',
            'additionalImages.*.order_column' => 'nullable|integer',
            'additionalImages.*.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'charCategories' => 'nullable|array',
            'charCategories.*.id' => 'nullable|integer',
            'charCategories.*.name' => 'nullable|string|max:250',
            'charCategories.*.ordering' => 'nullable|integer',
            'charCategories.*.chars' => 'nullable|array',
            'charCategories.*.chars.*.id' => 'nullable|integer',
            'charCategories.*.chars.*.name' => 'nullable|string|max:250',
            'charCategories.*.chars.*.value' => 'nullable|string|max:250',
            'charCategories.*.chars.*.type_id' => sprintf('nullable|integer|in:%s', $charTypeIds),
            'charCategories.*.chars.*.ordering' => 'nullable|integer',

            'accessories' => 'nullable|array',
            'accessories.*' => sprintf('nullable|integer|in:%s', $productIds),

            'similar' => 'nullable|array',
            'similar.*' => sprintf('nullable|integer|in:%s', $productIds),

            'related' => 'nullable|array',
            'related.*' => sprintf('nullable|integer|in:%s', $productIds),

            'works' => 'nullable|array',
            'works.*' => sprintf('nullable|integer|in:%s', $productIds),

            'instruments' => 'nullable|array',
            'instruments.*' => sprintf('nullable|integer|in:%s', $productIds),

            'variations' => 'nullable|array',
            'variations.*.id' => 'nullable|integer',
            'variations.*.uuid' => 'string',
            'variations.*.name' => 'nullable|string|max:250',
            'variations.*.is_active' => 'nullable|boolean',
            'variations.*.ordering' => 'nullable|integer',
            'variations.*.coefficient' => 'nullable|numeric',
            'variations.*.coefficient_description' => 'nullable|string|max:250',
            'variations.*.unit' => 'nullable|string|max:250',
            'variations.*.availability_status_id' => sprintf('nullable|integer|in:%s', $availabilityStatusIdsStr),
            'variations.*.price_purchase' => 'nullable|numeric',
            'variations.*.price_purchase_currency_id' => sprintf('nullable|integer|in:%s', $currenciesIdsStr),
            'variations.*.price_retail' => 'nullable|numeric',
            'variations.*.price_retail_currency_id' => sprintf('nullable|integer|in:%s', $currenciesIdsStr),
            'variations.*.preview' => 'nullable|string|max:65000',

            'variations.*.mainImage' => 'nullable|array',
            'variations.*.mainImage.id' => 'nullable|integer',
            'variations.*.mainImage.uuid' => 'string',
            'variations.*.mainImage.name' => 'nullable|string|max:250',
            'variations.*.mainImage.file_name' => 'nullable|string|max:250',
            'variations.*.mainImage.order_column' => 'nullable|integer',
            'variations.*.mainImage.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'variations.*.additionalImages' => 'nullable|array',
            'variations.*.additionalImages.*.id' => 'nullable|integer',
            'variations.*.additionalImages.*.uuid' => 'string',
            'variations.*.additionalImages.*.name' => 'nullable|string|max:250',
            'variations.*.additionalImages.*.file_name' => 'nullable|string|max:250',
            'variations.*.additionalImages.*.order_column' => 'nullable|integer',
            'variations.*.additionalImages.*.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),
        ];
    }

    /**
     * @return \Domain\Products\DTOs\Admin\Inertia\CreateEditProduct\ProductDTO
     */
    public function prepare(): ProductDTO
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

        return new ProductDTO([
            'name' => isset($payload['name'])
                ? (string)$payload['name']
                : null,
            'slug' => isset($payload['slug'])
                ? (string)$payload['slug']
                : null,
            'ordering' => isset($payload['ordering'])
                ? (int)$payload['ordering']
                : null,
            'is_active' => isset($payload['is_active'])
                ? (bool)$payload['is_active']
                : null,
            'unit' => isset($payload['unit'])
                ? (string)$payload['unit']
                : null,
            'price_purchase' => isset($payload['price_purchase'])
                ? (float)$payload['price_purchase']
                : null,
            'price_purchase_currency_id' => isset($payload['price_purchase_currency_id'])
                ? (int)$payload['price_purchase_currency_id']
                : null,
            'price_retail' => isset($payload['price_retail'])
                ? (float)$payload['price_retail']
                : null,
            'price_retail_currency_id' => isset($payload['price_retail_currency_id'])
                ? (int)$payload['price_retail_currency_id']
                : null,
            'admin_comment' => isset($payload['admin_comment'])
                ? (string)$payload['admin_comment']
                : null,
            'availability_status_id' => isset($payload['availability_status_id'])
                ? (int)$payload['availability_status_id']
                : null,
            'brand_id' => isset($payload['brand_id'])
                ? (int)$payload['brand_id']
                : null,
            'category_id' => isset($payload['category_id'])
                ? (int)$payload['category_id']
                : null,
            'is_with_variations' => isset($payload['is_with_variations'])
                ? (bool)$payload['is_with_variations']
                : null,
            'coefficient' => isset($payload['coefficient'])
                ? (float)$payload['coefficient']
                : null,
            'coefficient_description' => isset($payload['coefficient_description'])
                ? (string)$payload['coefficient_description']
                : null,
            'coefficient_description_show' => isset($payload['coefficient_description_show'])
                ? (bool)$payload['coefficient_description_show']
                : null,
            'coefficient_variation_description' => isset($payload['coefficient_variation_description'])
                ? (string)$payload['coefficient_variation_description']
                : null,
            'price_name' => isset($payload['price_name'])
                ? (string)$payload['price_name']
                : null,
            'preview' => isset($payload['preview'])
                ? (string)$payload['preview']
                : null,
            'description' => isset($payload['description'])
                ? (string)$payload['description']
                : null,
            'accessory_name' => isset($payload['accessory_name'])
                ? (string)$payload['accessory_name']
                : null,
            'similar_name' => isset($payload['similar_name'])
                ? (string)$payload['similar_name']
                : null,
            'related_name' => isset($payload['related_name'])
                ? (string)$payload['related_name']
                : null,
            'work_name' => isset($payload['work_name'])
                ? (string)$payload['work_name']
                : null,
            'instruments_name' => isset($payload['instruments_name'])
                ? (string)$payload['instruments_name']
                : null,
            'relatedCategoriesIds' => isset($payload['relatedCategoriesIds'])
                ? collect($payload['relatedCategoriesIds'])->map(fn ($id) => (int)$id)->all()
                : [],
            'seo' => isset($payload['seo'])
                ? new SeoDTO($payload['seo'])
                : null,
            'infoPrices' => isset($payload['infoPrices'])
                ? collect($payload['infoPrices'])->map(fn (array $infoPrice) => new InfoPriceDTO([
                    'id' => isset($infoPrice['id']) ? (int)$infoPrice['id'] : null,
                    'name' => isset($infoPrice['name']) ? (string)$infoPrice['name'] : null,
                    'price' => isset($infoPrice['price']) ? (float)$infoPrice['price'] : null,
                ]))->all()
                : [],
            'instructions' => isset($payload['instructions'])
                ? collect($payload['instructions'])->map($mediaCB)->all()
                : [],
            'mainImage' => isset($payload['mainImage'])
                ? $mediaCB($payload['mainImage'])
                : null,
            'additionalImages' => isset($payload['additionalImages'])
                ? collect($payload['additionalImages'])->map($mediaCB)->all()
                : [],
            'charCategories' => isset($payload['charCategories'])
                ? collect($payload['charCategories'])->map(fn (array $charCategory) => new CharCategoryDTO([
                    'id' => isset($charCategory['id'])
                        ? (int)$charCategory['id']
                        : null,
                    'uuid' => isset($charCategory['uuid'])
                        ? (string)$charCategory['uuid']
                        : null,
                    'name' => isset($charCategory['name'])
                        ? (string)$charCategory['name']
                        : null,
                    'ordering' => isset($charCategory['ordering'])
                        ? (int)$charCategory['ordering']
                        : null,
                    'chars' => isset($charCategory['chars'])
                        ? collect($charCategory['chars'])->map(fn (array $char) => new CharDTO([
                            'id' => isset($char['id'])
                                ? (int)$char['id']
                                : null,
                            'name' => isset($char['name'])
                                ? (string)$char['name']
                                : null,
                            'value' => isset($char['value'])
                                ? (string)$char['value']
                                : null,
                            'type_id' => isset($char['type_id'])
                                ? (int)$char['type_id']
                                : null,
                            'ordering' => isset($char['ordering'])
                                ? (int)$char['ordering']
                                : null,
                        ]))->all()
                        : [],
                ]))->all()
                : [],
            'accessories' => isset($payload['accessories'])
                ? collect($payload['accessories'])->map(fn ($id) => (int)$id)->all()
                : [],
            'similar' => isset($payload['similar'])
                ? collect($payload['similar'])->map(fn ($id) => (int)$id)->all()
                : [],
            'related' => isset($payload['related'])
                ? collect($payload['related'])->map(fn ($id) => (int)$id)->all()
                : [],
            'works' => isset($payload['works'])
                ? collect($payload['works'])->map(fn ($id) => (int)$id)->all()
                : [],
            'instruments' => isset($payload['instruments'])
                ? collect($payload['instruments'])->map(fn ($id) => (int)$id)->all()
                : [],
            'variations' => isset($payload['variations'])
                ? collect($payload['variations'])->map(fn (array $variation) => new VariationDTO([
                    'id' => isset($variation['id'])
                        ? (int)$variation['id']
                        : null,
                    'uuid' => isset($variation['uuid'])
                        ? (string)$variation['uuid']
                        : null,
                    'name' => isset($variation['name'])
                        ? (string)$variation['name']
                        : null,
                    'is_active' => isset($variation['is_active'])
                        ? (bool)$variation['is_active']
                        : null,
                    'ordering' => isset($variation['ordering'])
                        ? (int)$variation['ordering']
                        : null,
                    'coefficient' => isset($variation['coefficient'])
                        ? (float)$variation['coefficient']
                        : null,
                    'coefficient_description' => isset($variation['coefficient_description'])
                        ? (string)$variation['coefficient_description']
                        : null,
                    'unit' => isset($variation['unit'])
                        ? (string)$variation['unit']
                        : null,
                    'availability_status_id' => isset($variation['availability_status_id'])
                        ? (int)$variation['availability_status_id']
                        : null,
                    'price_purchase' => isset($variation['price_purchase'])
                        ? (float)$variation['price_purchase']
                        : null,
                    'price_purchase_currency_id' => isset($variation['price_purchase_currency_id'])
                        ? (int)$variation['price_purchase_currency_id']
                        : null,
                    'price_retail' => isset($variation['price_retail'])
                        ? (float)$variation['price_retail']
                        : null,
                    'price_retail_currency_id' => isset($variation['price_retail_currency_id'])
                        ? (int)$variation['price_retail_currency_id']
                        : null,
                    'preview' => isset($variation['preview'])
                        ? (string)$variation['preview']
                        : null,
                    'mainImage' => isset($variation['mainImage'])
                        ? $mediaCB($variation['mainImage'])
                        : null,
                    'additionalImages' => isset($variation['additionalImages'])
                        ? collect($variation['additionalImages'])->map($mediaCB)->all()
                        : [],
                ]))->all()
                : [],
        ]);
    }
}

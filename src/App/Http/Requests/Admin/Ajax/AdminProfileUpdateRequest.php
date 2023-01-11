<?php

namespace App\Http\Requests\Admin\Ajax;

use App\Providers\AuthServiceProvider;
use Domain\Common\Enums\Column;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property \Domain\Users\Models\Admin $admin @see {@link \App\Providers\RouteServiceProvider::routeBinding()}
 * @property-read string|null $adminSidebarFlexBasis
 *
 * @property-read int[]|null $adminOrderColumns
 * @property-read bool|null $adminOrderColumnsDefault
 *
 * @property-read int[]|null $adminProductColumns
 * @property-read bool|null $adminProductColumnsDefault
 *
 * @property-read int[]|null $adminProductVariantColumns
 * @property-read bool|null $adminProductVariantColumnsDefault
 *
 * @property-read array[]|null $adminProductsColumnSizes
 * @property-read bool|null $adminProductsColumnSizesDefault
 *
 * @property-read array[]|null $adminProductVariationsColumnSizes
 * @property-read bool|null $adminProductVariationsColumnSizesDefault
 *
 * @property-read array[]|null $adminOrdersColumnSizes
 * @property-read bool|null $adminOrdersColumnSizesDefault
 */
class AdminProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows(AuthServiceProvider::ADMIN_PROFILE_UPDATE, $this->admin);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'adminSidebarFlexBasis' => 'nullable|string',

            'adminOrderColumns' => 'array|nullable',
            'adminOrderColumns.*' => $this->getColumnValidation(),
            'adminOrderColumnsDefault' => 'boolean|nullable',

            'adminProductColumns' => 'array|nullable',
            'adminProductColumns.*' => $this->getColumnValidation(),
            'adminProductColumnsDefault' => 'boolean|nullable',

            'adminProductVariantColumns' => 'array|nullable',
            'adminProductVariantColumns.*' => $this->getColumnValidation(),
            'adminProductVariantColumnsDefault' => 'boolean|nullable',

            'adminProductsColumnSizes' => 'nullable|array',
            'adminProductsColumnSizes.*.column' => $this->getColumnValidation(),
            'adminProductsColumnSizes.*.size' => 'string',
            'adminProductsColumnSizesDefault' => 'boolean|nullable',

            'adminProductVariationsColumnSizes' => 'nullable|array',
            'adminProductVariationsColumnSizes.*.column' => $this->getColumnValidation(),
            'adminProductVariationsColumnSizes.*.size' => 'string',
            'adminProductVariationsColumnSizesDefault' => 'boolean|nullable',

            'adminOrdersColumnSizes' => 'nullable|array',
            'adminOrdersColumnSizes.*.column' => $this->getColumnValidation(),
            'adminOrdersColumnSizes.*.size' => 'string',
            'adminOrdersColumnSizesDefault' => 'boolean|nullable',
        ];
    }

    /**
     * @return string[]
     */
    protected function getColumnValidation(): array
    {
        return [
            'integer',
            sprintf('in:%s', implode(',', Column::toValues())),
        ];
    }
}

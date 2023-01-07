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
 * @property-read array[]|null $adminProductsTableSizes
 * @property-read bool|null $adminProductsTableSizesDefault
 *
 * @property-read array[]|null $adminProductVariationsTableSizes
 * @property-read bool|null $adminProductVariationsTableSizesDefault
 *
 * @property-read array[]|null $adminOrdersTableSizes
 * @property-read bool|null $adminOrdersTableSizesDefault
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

            'adminProductsTableSizes' => 'nullable|array',
            'adminProductsTableSizes.*.column' => $this->getColumnValidation(),
            'adminProductsTableSizes.*.size' => 'string',
            'adminProductsTableSizesDefault' => 'boolean|nullable',

            'adminProductVariationsTableSizes' => 'nullable|array',
            'adminProductVariationsTableSizes.*.column' => $this->getColumnValidation(),
            'adminProductVariationsTableSizes.*.size' => 'string',
            'adminProductVariationsTableSizesDefault' => 'boolean|nullable',

            'adminOrdersTableSizes' => 'nullable|array',
            'adminOrdersTableSizes.*.column' => $this->getColumnValidation(),
            'adminOrdersTableSizes.*.size' => 'string',
            'adminOrdersTableSizesDefault' => 'boolean|nullable',
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

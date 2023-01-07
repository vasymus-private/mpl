<?php

namespace App\Http\Requests\Admin\Ajax;

use App\Providers\AuthServiceProvider;
use Domain\Common\Enums\Column;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property \Domain\Users\Models\Admin $admin @see {@link \App\Providers\RouteServiceProvider::routeBinding()}
 * @property string|null $adminSidebarFlexBasis
 * @property array<int, string>|null $adminProductsTableSizes
 * @property array<int, string>|null $adminProductVariationsTableSizes
 * @property array<int, string>|null $adminOrdersTableSizes
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
            'adminOrderColumns.*' => [
                'integer',
                sprintf('in:%s', implode(',', Column::toValues())),
            ],
            'adminOrderColumnsDefault' => 'boolean|nullable',

            'adminProductColumns' => 'array|nullable',
            'adminProductColumns.*' => [
                'integer',
                sprintf('in:%s', implode(',', Column::toValues())),
            ],
            'adminProductColumnsDefault' => 'boolean|nullable',

            'adminProductVariantColumns' => 'array|nullable',
            'adminProductVariantColumns.*' => [
                'integer',
                sprintf('in:%s', implode(',', Column::toValues())),
            ],
            'adminProductVariantColumnsDefault' => 'boolean|nullable',

            'adminProductsTableSizes' => 'nullable|array',
            'adminProductsTableSizes.*' => 'string',
            'adminProductVariationsTableSizes' => 'nullable|array',
            'adminProductVariationsTableSizes.*' => 'string',
            'adminOrdersTableSizes' => 'nullable|array',
            'adminOrdersTableSizes.*' => 'string',
        ];
    }
}

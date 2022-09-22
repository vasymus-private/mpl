<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Orders\Models\PaymentMethod;
use Domain\Users\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Support\H;

class CreateUpdateOrderRequest extends FormRequest
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
            'order_status_id' => sprintf('required|exists:%s,id', OrderStatus::class),
            'payment_method_id' => sprintf('required|exists:%s,id', PaymentMethod::class),
            'comment_user' => 'nullable|max:65000',
            'admin_id' => sprintf('nullable|exists:%s,id', Admin::class),
            'importance_id' => sprintf('nullable|exists:%s,id', OrderImportance::class),
            'customer_bill_status_id' => sprintf('required|exists:%s,id', BillStatus::class),
            'customer_bill_description' => 'nullable|max:65000',
            'provider_bill_status_id' => sprintf('required|exists:%s,id', BillStatus::class),
            'provider_bill_description' => 'nullable|max:65000',
            'comment_admin' => 'nullable|max:65000',

            'customerInvoices' => 'nullable|array',
            'customerInvoices.*.id' => 'nullable|integer',
            'customerInvoices.*.uuid' => 'string',
            'customerInvoices.*.name' => 'nullable|string|max:250',
            'customerInvoices.*.file_name' => 'nullable|string|max:250',
            'customerInvoices.*.order_column' => 'nullable|integer',
            'customerInvoices.*.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'supplierInvoices' => 'nullable|array',
            'supplierInvoices.*.id' => 'nullable|integer',
            'supplierInvoices.*.uuid' => 'string',
            'supplierInvoices.*.name' => 'nullable|string|max:250',
            'supplierInvoices.*.file_name' => 'nullable|string|max:250',
            'supplierInvoices.*.order_column' => 'nullable|integer',
            'supplierInvoices.*.file' => sprintf('nullable|file|max:%s', H::validatorMb(95)),

            'productItems.*.order_product_count' => 'nullable',
            'productItems.*.order_product_price_retail_rub' => 'nullable',
        ];
    }

    public function prepare()
    {
    }
}

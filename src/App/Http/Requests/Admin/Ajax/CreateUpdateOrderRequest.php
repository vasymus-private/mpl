<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Orders\DTOs\CreateOrUpdateOrderDTO;
use Domain\Orders\DTOs\OrderProductItemDTO;
use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Orders\Models\PaymentMethod;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Support\H;

/**
 * @property-read int $order_status_id
 * @property-read int|null $payment_method_id
 * @property-read string|null $comment_user
 * @property-read int|null $admin_id
 * @property-read int|null $importance_id
 * @property-read int|null $customer_bill_status_id
 * @property-read string|null $customer_bill_description
 * @property-read int|null $provider_bill_status_id
 * @property-read string|null $provider_bill_description
 * @property-read string|null $comment_admin
 * @property-read string|null $request_name
 * @property-read string|null $request_email
 * @property-read string|null $request_phone
 * @property-read array|null $customerInvoices
 * @property-read array|null $supplierInvoices
 * @property-read array $productItems
 */
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
            'order_status_id' => sprintf('required|integer|exists:%s,id', OrderStatus::class),
            'payment_method_id' => sprintf('required|integer|exists:%s,id', PaymentMethod::class),
            'comment_user' => 'nullable|max:65000',
            'admin_id' => sprintf('nullable|integer|exists:%s,id', Admin::class),
            'importance_id' => sprintf('nullable|integer|exists:%s,id', OrderImportance::class),
            'customer_bill_status_id' => sprintf('required|integer|exists:%s,id', BillStatus::class),
            'customer_bill_description' => 'nullable|max:65000',
            'provider_bill_status_id' => sprintf('required|exists:%s,id', BillStatus::class),
            'provider_bill_description' => 'nullable|max:65000',
            'comment_admin' => 'nullable|max:65000',
            'request_name' => 'string|max:250|nullable',
            'request_email' => 'string|max:250|nullable',
            'request_phone' => 'string|max:250|nullable',

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

            'productItems' => 'array',
            'productItems.*.uuid' => sprintf('required|exists:%s,uuid', Product::class),
            'productItems.*.count' => 'nullable|integer',
            'productItems.*.name' => 'nullable|string|max:250',
            'productItems.*.unit' => 'nullable|string|max:250',
            'productItems.*.ordering' => 'nullable|integer',
            'productItems.*.price_retail_rub' => 'nullable|numeric',
            'productItems.*.price_retail_rub_origin' => 'nullable|numeric',
            'productItems.*.price_retail_rub_was_updated' => 'nullable|boolean',
        ];
    }

    /**
     * @return \Domain\Orders\DTOs\CreateOrUpdateOrderDTO
     */
    public function prepare(): CreateOrUpdateOrderDTO
    {
        return new CreateOrUpdateOrderDTO([
            'order_status_id' => $this->order_status_id,
            'importance_id' => $this->importance_id,
            'comment_user' => $this->comment_user,
            'request_name' => $this->request_name,
            'request_email' => $this->request_email,
            'request_phone' => $this->request_phone,
            'payment_method_id' => $this->payment_method_id,
            'customer_bill_description' => $this->customer_bill_description ? (string)$this->customer_bill_description : null,
            'customer_bill_status_id' => $this->customer_bill_status_id ? (int)$this->customer_bill_status_id : null,
            'provider_bill_description' => $this->provider_bill_description ? (string)$this->provider_bill_description : null,
            'provider_bill_status_id' => $this->provider_bill_status_id ? (int)$this->provider_bill_status_id : null,
            'comment_admin' => $this->comment_admin ? (string)$this->comment_admin : null,
            'productItems' => collect($this->productItems)
                ->map(function (array $productItem) {
                    /** @var \Domain\Products\Models\Product\Product $product */
                    $product = Product::query()->withTrashed()->where(sprintf('%s.uuid', Product::TABLE), $productItem['uuid'])->firstOrFail();

                    return new OrderProductItemDTO([
                        'count' => isset($productItem['count']) ? (int)$productItem['count'] : 1,
                        'order_product_count' => isset($productItem['count']) ? (int)$productItem['count'] : 1,
                        'name' => isset($productItem['name']) ? (string)$productItem['name'] : null,
                        'unit' => isset($productItem['unit']) ? (string)$productItem['unit'] : null,
                        'ordering' => isset($productItem['ordering']) ? (int)$productItem['ordering'] : null,
                        'price_retail_rub' => (float)$productItem['price_retail_rub'],
                        'order_product_price_retail_rub' => (float)$productItem['price_retail_rub'],
                        'price_retail_rub_origin' => (float)$productItem['price_retail_rub_origin'],
                        'price_retail_rub_was_updated' => isset($productItem['price_retail_rub_was_updated']) ? (bool)$productItem['price_retail_rub_was_updated'] : null,
                        'order_product_price_retail_rub_was_updated' => isset($productItem['price_retail_rub_was_updated']) ? (bool)$productItem['price_retail_rub_was_updated'] : null,
                        'product' => $product,
                        'id' => $product->id,
                    ]);
                })
                ->all(),
        ]);
    }
}

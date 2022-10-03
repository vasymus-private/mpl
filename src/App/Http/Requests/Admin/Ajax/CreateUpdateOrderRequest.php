<?php

namespace App\Http\Requests\Admin\Ajax;

use Domain\Common\DTOs\MediaDTO;
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
            'request_email' => 'string|max:250|nullable',
            'request_name' => 'string|max:250|nullable',
            'request_phone' => 'string|max:250|nullable',
            'payment_method_id' => sprintf('required|integer|exists:%s,id', PaymentMethod::class),
            'comment_user' => 'nullable|max:65000',
            'admin_id' => sprintf('nullable|integer|exists:%s,id', Admin::class),
            'importance_id' => sprintf('nullable|integer|exists:%s,id', OrderImportance::class),
            'customer_bill_description' => 'nullable|max:65000',
            'customer_bill_status_id' => sprintf('required|integer|exists:%s,id', BillStatus::class),
            'provider_bill_description' => 'nullable|max:65000',
            'provider_bill_status_id' => sprintf('required|exists:%s,id', BillStatus::class),
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

            'productItems' => 'array',
            'productItems.*.uuid' => sprintf('required|exists:%s,uuid', Product::class),
            'productItems.*.count' => 'nullable|integer',
            'productItems.*.name' => 'nullable|string|max:250',
            'productItems.*.unit' => 'nullable|string|max:250',
            'productItems.*.ordering' => 'nullable|integer',
            'productItems.*.price_retail_rub' => 'nullable|numeric',
            'productItems.*.price_retail_rub_was_updated' => 'nullable|boolean',
        ];
    }

    /**
     * @return \Domain\Orders\DTOs\CreateOrUpdateOrderDTO
     */
    public function prepare(): CreateOrUpdateOrderDTO
    {
        return new CreateOrUpdateOrderDTO([
            'order_status_id' => (int)$this->order_status_id,
            'request_email' => $this->request_email ? (string)$this->request_email : null,
            'request_name' => $this->request_name ? (string)$this->request_name : null,
            'request_phone' => $this->request_phone ? (string)$this->request_phone : null,
            'payment_method_id' => $this->payment_method_id ? (int)$this->payment_method_id : null,
            'comment_user' => $this->comment_user ? (string)$this->comment_user : null,
            'admin_id' => $this->admin_id ? (int)$this->admin_id : null,
            'importance_id' => $this->importance_id ? (int)$this->importance_id : null,
            'customer_bill_description' => $this->customer_bill_description ? (string)$this->customer_bill_description : null,
            'customer_bill_status_id' => $this->customer_bill_status_id ? (int)$this->customer_bill_status_id : null,
            'customerInvoices' => isset($this->customerInvoices)
                ? collect($this->customerInvoices)->map(fn ($media) => MediaDTO::create($media))->all()
                : [],
            'provider_bill_description' => $this->provider_bill_description ? (string)$this->provider_bill_description : null,
            'provider_bill_status_id' => $this->provider_bill_status_id ? (int)$this->provider_bill_status_id : null,
            'supplierInvoices' => isset($this->supplierInvoices)
                ? collect($this->supplierInvoices)->map(fn ($media) => MediaDTO::create($media))->all()
                : [],
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
                        // for backward compatibility
                        'order_product_price_retail_rub' => (float)$productItem['price_retail_rub'],
                        'price_retail_rub_was_updated' => isset($productItem['price_retail_rub_was_updated']) ? (bool)$productItem['price_retail_rub_was_updated'] : null,
                        // for backward compatibility
                        'order_product_price_retail_rub_was_updated' => isset($productItem['price_retail_rub_was_updated']) ? (bool)$productItem['price_retail_rub_was_updated'] : null,
                        // for backward compatibility
                        'product' => $product,
                        'id' => $product->id,
                    ]);
                })
                ->all(),
        ]);
    }
}

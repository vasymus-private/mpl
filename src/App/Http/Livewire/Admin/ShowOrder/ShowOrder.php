<?php

namespace App\Http\Livewire\Admin\ShowOrder;

use App\Constants;
use App\Http\Livewire\Admin\BaseShowComponent;
use App\Http\Livewire\Admin\HasBillStatuses;
use App\Http\Livewire\Admin\HasManagers;
use App\Http\Livewire\Admin\HasOrderImportance;
use App\Http\Livewire\Admin\HasOrderStatuses;
use App\Http\Livewire\Admin\HasPaymentMethods;
use App\Http\Livewire\Admin\HasTabs;
use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\Currency;
use Domain\Common\Models\CustomMedia;
use Domain\Orders\Actions\DeleteOrderAction;
use Domain\Orders\Actions\HandleCancelOrderAction;
use Domain\Orders\Actions\HandleNotCancelOrderAction;
use Domain\Orders\Actions\OMS\HandleChangeOrderStatusAction;
use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderImportance;
use Domain\Orders\Models\OrderStatus;
use Domain\Orders\Models\PaymentMethod;
use Domain\Products\DTOs\Admin\OrderProductItemDTO;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\Admin;
use Illuminate\Support\Facades\Route;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Support\H;

class ShowOrder extends BaseShowComponent
{
    use HasTabs;
    use HasOrderStatuses;
    use HasPaymentMethods;
    use HasManagers;
    use HasOrderImportance;
    use HasBillStatuses;
    use WithFileUploads;

    protected const DEFAULT_TAB = 'order';
    public const MAX_FILE_SIZE_MB = 30;

    /**
     * @var string|int|null
     */
    public $editMode = '0';

    public bool $isCreating;

    public string $cancelMessage = '';

    public string $email = '';

    public string $name = '';

    public string $phone = '';

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public array $attachments;

    /**
     * @var array @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO}
     */
    public array $currentProductItem;

    /**
     * @var array @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO}
     */
    public array $initialCurrentProductItem;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\Admin\OrderProductItemDTO}
     */
    public array $productItems;

    /**
     * @var \Livewire\TemporaryUploadedFile
     */
    public $tempAttachment;

    /**
     * @var \Domain\Orders\Models\Order
     */
    public Order $item;

    public function tabs(): array
    {
        return $this->isCreating
            ? [
                'order' => 'Заказ',
            ]
            : [
                'order' => 'Заказ',
                'history' => 'История изменений',
            ];
    }

    /**
     * @return array
     */
    protected function queryString(): array
    {
        return array_merge(
            $this->getHasTabsQueryString(),
            [
                'editMode' => ['except' => '0'],
            ]
        );
    }

    /**
     * @return string[]
     */
    protected function rules(): array
    {
        return [
            'item.order_status_id' => sprintf('required|exists:%s,id', OrderStatus::class),
            'item.payment_method_id' => sprintf('required|exists:%s,id', PaymentMethod::class),
            'item.comment_user' => 'nullable|max:65000',
            'item.admin_id' => sprintf('nullable|exists:%s,id', Admin::class),
            'item.importance_id' => sprintf('nullable|exists:%s,id', OrderImportance::class),
            'item.customer_bill_status_id' => sprintf('required|exists:%s,id', BillStatus::class),
            'item.customer_bill_description' => 'nullable|max:65000',
            'item.provider_bill_status_id' => sprintf('required|exists:%s,id', BillStatus::class),
            'item.provider_bill_description' => 'nullable|max:65000',
            'item.comment_admin' => 'nullable|max:65000',

            'attachments.*.name' => 'nullable|max:250',
            'tempAttachment' => sprintf('nullable|max:%s', 1024 * self::MAX_FILE_SIZE_MB), // 1024 -> 1024 kb = 1 mb

            'productItems.*.order_product_count' => 'nullable',
        ];
    }

    public function mount()
    {
        $this->isCreating = Route::currentRouteName() === Constants::ROUTE_ADMIN_ORDERS_CREATE;

        $this->initOrderStatusesOptions();
        $this->initPaymentMethodsOptions();
        $this->initManagersOptions();
        $this->initOrderImportanceOptions();
        $this->initBillStatusesOptions();
        $this->initAttachments();

        $this->initHasTabs();

        $this->email = $this->item->request['email'] ?? $this->item->user->email ?? '';
        $this->name = $this->item->request['name'] ?? $this->item->user->name ?? '';
        $this->phone = $this->item->request['phone'] ?? $this->item->user->phone ?? '';

        $this->initProductItems();
    }

    public function render()
    {
        return view('admin.livewire.show-order.show-order');
    }

    public function handleSave()
    {
        $this->validate();

        $request = $this->item->request;
        $request['email'] = $this->email;
        $request['name'] = $this->name;
        $request['phone'] = $this->phone;
        $this->item->request = $request;

        $this->item->save();

        /** @var \Domain\Orders\Actions\OMS\HandleChangeOrderStatusAction $handleChangeOrderStatusAction */
        $handleChangeOrderStatusAction = resolve(HandleChangeOrderStatusAction::class);
        $handleChangeOrderStatusAction->execute($this->item, $this->item->order_status_id);

        $this->saveAttachments();
    }

    public function handleDeleteOrder()
    {
        /** @var \Domain\Orders\Actions\DeleteOrderAction $deleteOrder */
        $deleteOrder = resolve(DeleteOrderAction::class);
        $deleteOrder->execute($this->item);
        return redirect()->route(Constants::ROUTE_ADMIN_ORDERS_INDEX);
    }

    public function handleCancelOrder()
    {
        if ($this->isCreating) {
            $this->skipRender();
            return false;
        }

        /** @var \Domain\Orders\Actions\HandleCancelOrderAction $handleCancelOrderAction */
        $handleCancelOrderAction = resolve(HandleCancelOrderAction::class);
        $order = $handleCancelOrderAction->execute($this->item->id, $this->cancelMessage);

        $this->item->cancelled = $order->cancelled;
        $this->item->cancelled_description = $order->cancelled_description;
        $this->item->cancelled_date = $order->cancelled_date;
        $this->item->updated_at = $order->updated_at;

        return true;
    }

    public function handleNotCancelled()
    {
        if ($this->isCreating) {
            $this->skipRender();
            return false;
        }

        /** @var \Domain\Orders\Actions\HandleNotCancelOrderAction $handleNotCancelOrderAction */
        $handleNotCancelOrderAction = resolve(HandleNotCancelOrderAction::class);
        $order = $handleNotCancelOrderAction->execute($this->item->id);

        $this->item->cancelled = $order->cancelled;
        $this->item->cancelled_description = $order->cancelled_description;
        $this->item->cancelled_date = $order->cancelled_date;
        $this->item->updated_at = $order->updated_at;

        return true;
    }

    public function isEditMode(): bool
    {
        return (int)$this->editMode !== 0;
    }

    public function deleteAttachment($index)
    {
        $this->attachments = collect($this->attachments)->values()->filter(fn(array $attachment, int $key) => (string)$index !== (string)$key)->toArray();
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $value
     */
    public function updatedTempAttachment(TemporaryUploadedFile $value)
    {
        $fileDTO = FileDTO::fromTemporaryUploadedFile($value);
        $this->attachments[] = $fileDTO->toArray();
    }

    public function removeProductItem($id)
    {
        $this->productItems = collect($this->productItems)->filter(fn(array $productItem) => (string)$productItem['id'] !== (string)$id)->toArray();
    }

    public function selectCurrentProductItem($uuid)
    {
        $orderProductItem = $this->productItems[$uuid];

        if (!$orderProductItem) {
            return false;
        }

        $this->currentProductItem = $orderProductItem;
        $this->initialCurrentProductItem = $orderProductItem;
        return true;
    }

    protected function initAttachments()
    {
        $this->attachments = $this->item
            ->admin_attachments
            ->map(
                fn(CustomMedia $media) => FileDTO::fromCustomMedia($media)->toArray()
            )
            ->toArray();
    }

    protected function saveAttachments()
    {
        $attachments = [];
        $collectionName = Order::MC_ADMIN_ATTACHMENT;

        foreach ($this->attachments as $fileDTO) {
            if ($fileDTO['id'] !== null) {
                /** @var \Domain\Common\Models\CustomMedia $attachment */
                $attachment = $this->item->getMedia($collectionName)->first(fn(CustomMedia $customMedia) => $fileDTO['id'] === $customMedia->id);
                $attachment->name = $fileDTO['name'] ?: $fileDTO['file_name'];
                $attachment->save();
                $attachments[] = $fileDTO;
            } else {
                $fileAdder = $this->item
                    ->addMedia($fileDTO['path'])
                    ->preservingOriginal()
                    ->usingFileName($fileDTO['file_name'])
                    ->usingName($fileDTO['name'] ?? $fileDTO['file_name'])
                ;
                /** @var \Domain\Common\Models\CustomMedia $attachment */
                $attachment = $fileAdder->toMediaCollection($collectionName);

                $attachments[] = FileDTO::fromCustomMedia($attachment)->toArray();
            }
        }

        $mediasIds = collect($attachments)->pluck('id')->toArray();
        $this->item->getMedia($collectionName)->each(function(CustomMedia $customMedia) use($mediasIds) {
            if (!in_array($customMedia->id, $mediasIds)) {
                $customMedia->delete();
            }
        });

        $this->attachments = $attachments;
    }

    protected function initProductItems()
    {
        $this->productItems = $this->item->products->map(fn(Product $product) => OrderProductItemDTO::fromOrderProductItem($product)->toArray())->keyBy('uuid')->all();
    }

    /**
     * @param string $value
     * @param string $field
     */
    public function updatedProductItems($value, $field)
    {
        $uuidItemFieldArr = explode('.', $field);
        $uuid = $uuidItemFieldArr[0];
        $itemField = $uuidItemFieldArr[1];

        $orderProductItem = $this->productItems[$uuid];
        $orderProductItem = $this->handleUpdateProductItem($orderProductItem, $itemField, $value);

        $this->productItems[$uuid] = $orderProductItem;
    }

    public function handleSaveCurrentProductItem()
    {
        if (!$this->currentProductItem) {
            return false;
        }
        $productItemToUpdate = $this->productItems[$this->currentProductItem['uuid']];

        $possibleFieldsToUpdate = ['name', 'unit', 'price_retail_rub', 'order_product_count'];
        foreach ($possibleFieldsToUpdate as $itemField) {
            if ($this->currentProductItem[$itemField] !== $this->initialCurrentProductItem[$itemField]) {
                $productItemToUpdate = $this->handleUpdateProductItem($productItemToUpdate, $itemField, $this->currentProductItem[$itemField]);
            }
        }
        $this->productItems[$this->currentProductItem['uuid']] = $productItemToUpdate;

        return true;
    }

    /**
     * @param array|\Domain\Products\DTOs\Admin\OrderProductItemDTO $orderProductItem
     * @param string $itemField
     * @param int|string $value
     *
     * @return array|\Domain\Products\DTOs\Admin\OrderProductItemDTO
     */
    protected function handleUpdateProductItem(array $orderProductItem, string $itemField, $value): array
    {
        switch ($itemField) {
            case 'order_product_count': {
                $orderProductItem['price_retail_rub_sum'] = (int)$value * $orderProductItem['price_retail_rub'];
                $orderProductItem['price_retail_rub_sum_formatted'] = H::priceRubFormatted($orderProductItem['price_retail_rub_sum'], Currency::ID_RUB);
                $orderProductItem['price_purchase_rub_sum'] = (int)$value * $orderProductItem['price_purchase_rub'];
                $orderProductItem['price_purchase_rub_sum_formatted'] = H::priceRubFormatted($orderProductItem['price_purchase_rub_sum'], Currency::ID_RUB);
                $orderProductItem['price_retail_purchase_sum_diff_rub_formatted'] = H::priceRubFormatted($orderProductItem['price_retail_rub_sum'] - $orderProductItem['price_purchase_rub_sum'], Currency::ID_RUB);
                $orderProductItem[$itemField] = $value;
                break;
            }
            case 'price_retail_rub': {
                $orderProductItem['price_retail_rub_was_updated'] = true;
                $orderProductItem['price_retail_rub_formatted'] = H::priceRubFormatted((int)$value, Currency::ID_RUB);
                $orderProductItem['price_retail_rub_sum'] = (int)$value * $orderProductItem['order_product_count'];
                $orderProductItem['price_retail_rub_sum_formatted'] = H::priceRubFormatted($orderProductItem['price_retail_rub_sum'], Currency::ID_RUB);
                $orderProductItem['price_retail_purchase_sum_diff_rub_formatted'] = H::priceRubFormatted($orderProductItem['price_retail_rub_sum'] - $orderProductItem['price_purchase_rub_sum'], Currency::ID_RUB);
                $orderProductItem[$itemField] = $value;
                break;
            }
            default: {
                $orderProductItem[$itemField] = $value;
            }
        }

        return $orderProductItem;
    }
}

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
use Domain\Users\Models\Admin;
use Illuminate\Support\Facades\Route;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

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
            'tempAttachment' => 'nullable|max:' . (1024 * self::MAX_FILE_SIZE_MB), // 1024 -> 1024 kb = 1 mb
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
}

<?php

namespace App\Http\Livewire\Admin\ShowOrder;

use App\Constants;
use App\Http\Livewire\Admin\BaseShowComponent;
use App\Http\Livewire\Admin\HasOrderStatuses;
use App\Http\Livewire\Admin\HasTabs;
use Domain\Orders\Actions\DeleteOrderAction;
use Domain\Orders\Actions\HandleCancelOrderAction;
use Domain\Orders\Actions\HandleNotCancelOrderAction;
use Domain\Orders\Actions\OMS\HandleChangeOrderStatusAction;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderStatus;
use Illuminate\Support\Facades\Route;

class ShowOrder extends BaseShowComponent
{
    use HasTabs;
    use HasOrderStatuses;

    protected const DEFAULT_TAB = 'order';

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
            'item.order_status_id' => 'required|exists:' . OrderStatus::class . ',id',
        ];
    }

    public function mount()
    {
        $this->isCreating = Route::currentRouteName() === Constants::ROUTE_ADMIN_ORDERS_CREATE;

        $this->initOrderStatusesOptions();

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

        $this->item->forceFill([

        ]);
        /** @var \Domain\Orders\Actions\OMS\HandleChangeOrderStatusAction $handleChangeOrderStatusAction */
        $handleChangeOrderStatusAction = resolve(HandleChangeOrderStatusAction::class);
        $handleChangeOrderStatusAction->execute($this->item, $this->item->order_status_id);
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
}

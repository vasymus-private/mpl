<?php

namespace App\Http\Livewire\Admin\ShowOrder;

use App\Constants;
use App\Http\Livewire\Admin\BaseShowComponent;
use App\Http\Livewire\Admin\HasOrderStatuses;
use App\Http\Livewire\Admin\HasTabs;
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

    }

    public function handleDeleteOrder()
    {

    }

    public function handleCancelOrder()
    {
        if ($this->isCreating) {
            $this->skipRender();
            return;
        }
        /** @var \Domain\Orders\Models\Order $order */
        $order = Order::query()->findOrFail($this->item->id);

        $cancelledDate = now();

        $this->item->cancelled = true;
        $this->item->cancelled_description = $this->cancelMessage;
        $this->item->cancelled_date = $cancelledDate;
        $this->item->updated_at = $cancelledDate;

        $order->cancelled = true;
        $order->cancelled_description = $this->cancelMessage;
        $order->cancelled_date = $cancelledDate;
        $order->updated_at = $cancelledDate;

        $order->save();

        return true;
    }

    public function handleNotCancelled()
    {
        if ($this->isCreating) {
            $this->skipRender();
            return;
        }
        /** @var \Domain\Orders\Models\Order $order */
        $order = Order::query()->findOrFail($this->item->id);

        $now = now();

        $this->item->cancelled = false;
        $this->item->cancelled_description = '';
        $this->item->cancelled_date = null;
        $this->item->updated_at = $now;

        $order->cancelled = false;
        $order->cancelled_description = '';
        $order->cancelled_date = null;
        $order->updated_at = $now;

        $order->save();
    }

    public function isEditMode(): bool
    {
        return (int)$this->editMode !== 0;
    }
}

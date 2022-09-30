<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\Orders\Actions\HandleCancelOrderAction;
use Domain\Orders\Actions\HandleNotCancelOrderAction;
use Domain\Orders\Models\Order;
use Illuminate\Http\Request;
use Support\H;

class OrdersCancelController extends BaseAdminController
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'should_cancel' => 'required|boolean',
            'cancelled_description' => 'string|nullable|max:250',
        ]);

        /** @var \Domain\Orders\Models\Order $order */
        $order = $request->admin_order;
        /** @var bool $shouldCancel */
        $shouldCancel = $request->should_cancel;
        /** @var string|null $cancelDescription */
        $cancelDescription = $request->cancelled_description;

        if ($shouldCancel) {
            HandleCancelOrderAction::cached()->execute($order, $cancelDescription, H::admin());
        } else {
            HandleNotCancelOrderAction::cached()->execute($order, H::admin());
        }

        $order = $this->refreshOrder($order->id);

        return [
            'id' => $order->id,
            'cancelled' => $order->cancelled,
            'cancelled_description' => $order->cancelled_description,
        ];
    }

    /**
     * @param int $id
     *
     * @return \Domain\Orders\Models\Order
     */
    private function refreshOrder(int $id): Order
    {
        /** @var \Domain\Orders\Models\Order $order */
        $order = Order::query()->select(['id', 'cancelled', 'cancelled_description'])->findOrFail($id);

        return $order;
    }
}

<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\Order;

class HandleCancelOrderAction
{
    /**
     * @param int $id
     * @param string|null $cancelMessage
     *
     * @return \Domain\Orders\Models\Order
     */
    public function execute(int $id, ?string $cancelMessage): Order
    {
        /** @var \Domain\Orders\Models\Order $order */
        $order = Order::query()->findOrFail($id);

        $cancelledDate = now();

        $order->cancelled = true;
        $order->cancelled_description = $cancelMessage;
        $order->cancelled_date = $cancelledDate;
        $order->updated_at = $cancelledDate;

        $order->save();

        // TODO ask about email

        return $order;
    }
}

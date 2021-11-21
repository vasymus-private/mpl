<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\Order;

class HandleNotCancelOrderAction
{
    /**
     * @param int $id
     * \
     * @return \Domain\Orders\Models\Order
     */
    public function execute(int $id): Order
    {
        /** @var \Domain\Orders\Models\Order $order */
        $order = Order::query()->findOrFail($id);

        $now = now();

        $order->cancelled = false;
        $order->cancelled_description = '';
        $order->cancelled_date = null;
        $order->updated_at = $now;

        $order->save();

        return $order;
    }
}

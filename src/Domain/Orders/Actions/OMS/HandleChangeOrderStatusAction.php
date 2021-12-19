<?php

namespace Domain\Orders\Actions\OMS;

use Domain\Orders\Models\Order;

class HandleChangeOrderStatusAction
{
    /**
     * @param \Domain\Orders\Models\Order $order
     * @param int $newStatus
     *
     * @return void
     */
    public function execute(Order $order, int $newStatus): void
    {
        if ((string)$order->getOriginal('order_status_id') === (string)$order->order_status_id) {
            return;
        }
        // TODO add validation / email etc
        $order->order_status_id = $newStatus;
        $order->save();
    }
}

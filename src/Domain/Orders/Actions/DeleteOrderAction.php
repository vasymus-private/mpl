<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\Order;

class DeleteOrderAction
{
    /**
     * @param \Domain\Orders\Models\Order $order
     *
     * @return void
     */
    public function execute(Order $order): void
    {
        $order->delete();
        // TODO dispatch email, etc
    }
}

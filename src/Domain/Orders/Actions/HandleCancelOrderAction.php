<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Domain\Users\Models\BaseUser\BaseUser;

class HandleCancelOrderAction
{
    /**
     * @param int $id
     * @param string|null $cancelMessage
     * @param \Domain\Users\Models\BaseUser\BaseUser|null $user
     *
     * @return \Domain\Orders\Models\Order
     */
    public function execute(int $id, ?string $cancelMessage, BaseUser $user = null): Order
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

        $orderEvent = new OrderEvent();
        $orderEvent->payload = [
            'cancelled' => true,
            'description' => sprintf('Заказ отменен. Причина: %s', $cancelMessage),
        ];
        $orderEvent->type = OrderEventType::cancellation();
        if ($user) {
            $orderEvent->user()->associate($user);
        }
        $orderEvent->order()->associate($order);
        $orderEvent->save();

        return $order;
    }
}

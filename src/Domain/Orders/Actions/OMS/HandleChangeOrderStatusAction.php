<?php

namespace Domain\Orders\Actions\OMS;

use Domain\Common\Actions\BaseAction;
use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Domain\Orders\Models\OrderStatus;
use Domain\Users\Models\BaseUser\BaseUser;

class HandleChangeOrderStatusAction extends BaseAction
{
    /**
     * @param \Domain\Orders\Models\Order $order
     * @param int $newStatus
     * @param \Domain\Users\Models\BaseUser\BaseUser|null $eventUser
     *
     * @return void
     */
    public function execute(Order $order, int $newStatus, BaseUser $eventUser = null): void
    {
        if ((string)$order->getOriginal('order_status_id') === (string)$newStatus) {
            return;
        }
        $orderStatus = OrderStatus::query()->findOrFail($newStatus);
        // TODO email, sms etc
        $order->order_status_id = $newStatus;
        $order->save();

        $orderEvent = new OrderEvent();
        $orderEvent->payload = [
            'new_status' => $newStatus,
            'description' => sprintf('Статус изменен на: "%s"', $orderStatus->name),
        ];
        $orderEvent->type = OrderEventType::update_status();
        if ($eventUser) {
            $orderEvent->user()->associate($eventUser);
        }
        $orderEvent->order()->associate($order);
        $orderEvent->save();
    }
}

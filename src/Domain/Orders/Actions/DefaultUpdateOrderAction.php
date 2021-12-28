<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Models\Order;
use Domain\Users\Models\BaseUser\BaseUser;

class DefaultUpdateOrderAction
{
    /**
     * @param \Domain\Orders\Models\Order $order
     * @param \Domain\Users\Models\BaseUser\BaseUser|null $user
     *
     * @return void
     */
    public function execute(Order $order, BaseUser $user = null): void
    {
//        if ((string)$payload->getOriginal('order_status_id') === (string)$newStatus) {
//            return;
//        }
/**
 * @method static self update_comment_admin()
 * @method static self update_payment_method()
 * @method static self update_comment_user()
 * @method static self update_admin()
 * @method static self update_importance()
 * @method static self update_customer_personal_data()
 */

    }
}

<?php

namespace Domain\Orders\DTOs;

use Domain\Orders\Models\Order;
use Domain\Users\Models\BaseUser\BaseUser;
use Spatie\DataTransferObject\DataTransferObject;

class DefaultUpdateOrderParams extends DataTransferObject
{
    /**
     * @var \Domain\Orders\Models\Order
     */
    public Order $order;

    /**
     * @var \Domain\Users\Models\BaseUser\BaseUser
     */
    public BaseUser $event_user;

    /**
     * @var string|int|float|null
     */
    public $comment_user;

    /**
     * @var string|int|float|null
     */
    public $comment_admin;

    /**
     * @var int|string|null
     */
    public $payment_method_id;

    /**
     * @var int|string|null
     */
    public $admin_id;

    /**
     * @var int|string|null
     */
    public $importance_id;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $email;

    /**
     * @var string|null
     */
    public ?string $phone;

    /**
     * @var string|null
     */
    public ?string $customer_bill_description;

    /**
     * @var int|null
     */
    public ?int $customer_bill_status_id;

    /**
     * @var string|null
     */
    public ?string $provider_bill_description;

    /**
     * @var int|null
     */
    public ?int $provider_bill_status_id;
}

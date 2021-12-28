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
     * @var \Domain\Users\Models\BaseUser\BaseUser|null
     */
    public ?BaseUser $user;

    /**
     * @var string|int|float|null
     */
    public $comment_user;

    /**
     * @var string|int|float|null
     */
    public $comment_admin;

    /**
     * @var int|null
     */
    public ?int $payment_method_id;

    /**
     * @var int|null
     */
    public ?int $admin_id;

    /**
     * @var int|null
     */
    public ?int $importance_id;

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
}

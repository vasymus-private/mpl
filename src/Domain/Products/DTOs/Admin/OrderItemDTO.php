<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Orders\Models\Order;
use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class OrderItemDTO extends DataTransferObject
{
    /*
дата создания (с указанием времени)
id
статус
комментарии (для внутреннего пользования)
комментарий покупателя
менеджер (кто первый из менеджеров открыл)
сумма (всегда в рублях)
имя (клиента)
телефон (клиента)
позиции (все, что кинул в корзину)
email
платежная система
     */

    public int $id;

    /**
     * @var string Format 'Y-m-d H:i:s'
     */
    public ?string $date;

    public int $order_status_id;

    public string $order_status_name;

    public ?string $comment_admin;

    public ?string $comment_user;

    public ?int $admin_id;

    public int $user_id;

    public ?string $user_name;

    public ?string $user_email;

    public ?string $user_phone;

    public string $order_price_retail_rub_formatted;

    /**
     * @var \Domain\Products\DTOs\Admin\OrderProductItemDTO[]
     */
    public array $products;

    public static function fromModel(Order $order): self
    {
        return new self([
            'id' => $order->id,
            'date' => $order->date_formatted,
            'order_status_id' => $order->order_status_id,
            'order_status_name' => $order->status->name ?? "",
            'comment_admin' => $order->comment_admin,
            'comment_user' => $order->comment_user,
            'admin_id' => $order->admin_id,
            'user_id' => $order->user_id,
            'user_name' => $order->user->name,
            'user_email' => $order->user->email,
            'user_phone' => $order->user->phone,
            'order_price_retail_rub_formatted' => $order->order_price_retail_rub_formatted,
            'products' => $order->products->map(fn(Product $product) => OrderProductItemDTO::fromModel($product))->all(),
        ]);
    }
}

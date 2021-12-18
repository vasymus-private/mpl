<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DTOs\CreateOrderParamsDTO;
use Domain\Orders\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateOrderAction
{
    /**
     * @param \Domain\Orders\DTOs\CreateOrderParamsDTO $params
     *
     * @return \Domain\Orders\Models\Order|null
     */
    public function execute(CreateOrderParamsDTO $params): ?Order
    {
        $productsPrepare = [];

        foreach ($params->productItems as $productItem) {
            $productsPrepare[$productItem->product->id] = [
                "count" => $productItem->count,
                "price_purchase" => $productItem->product->price_purchase,
                "price_purchase_currency_id" => $productItem->product->price_purchase_currency_id,
                "price_retail" => $productItem->product->price_retail,
                "price_retail_currency_id" => $productItem->product->price_retail_currency_id,
                'unit' => $productItem->product->unit,
                'price_retail_rub' => $productItem->product->price_retail_rub,
            ];
        }

        DB::beginTransaction();
        /** @var \Domain\Orders\Models\Order|null $order */
        $order = null;
        /** @var \Domain\Common\Models\CustomMedia[] $medias */
        $medias = [];

        try {
            $order = Order::forceCreate([
                "user_id" => $params->user->id,
                "order_status_id" => $params->order_status_id,
                "importance_id" => $params->importance_id,
                "comment_user" => $params->comment_user,
                "request" => [
                    "name" => $params->request_name,
                    "email" => $params->request_email,
                    "phone" => $params->request_phone,
                ]
            ]);

            $order->products()->attach($productsPrepare);

            foreach ($params->attachment as $file) {
                $medias[] = $order->addMedia($file)->toMediaCollection(Order::MC_INITIAL_ATTACHMENT);
            }
        } catch (Exception $exception) {
            Log::error($exception);
            $order = null;
            foreach ($medias as $media) {
                $media->delete();
            }
            DB::rollBack();
        }
        DB::commit();

        return $order;
    }
}

<?php

namespace Domain\Orders\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Common\Actions\SyncAndSaveMediasAction;
use Domain\Orders\DTOs\CreateOrderParamsDTO;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateOrderAction extends BaseAction
{
    /**
     * @link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::DEFAULT_ORDERING
     */
    private const DEFAULT_ORDERING = 100;

    /**
     * @link \App\Http\Livewire\Admin\ShowOrder\ShowOrder::ORDERING_STEP
     */
    private const ORDERING_STEP = 100;

    /**
     * @var \Domain\Common\Actions\SyncAndSaveMediasAction
     */
    private SyncAndSaveMediasAction $syncAndSaveMediasAction;

    /**
     * @param \Domain\Common\Actions\SyncAndSaveMediasAction $syncAndSaveMediasAction
     */
    public function __construct(SyncAndSaveMediasAction $syncAndSaveMediasAction)
    {
        $this->syncAndSaveMediasAction = $syncAndSaveMediasAction;
    }

    /**
     * @param \Domain\Orders\DTOs\CreateOrderParamsDTO $params
     *
     * @return \Domain\Orders\Models\Order|null
     */
    public function execute(CreateOrderParamsDTO $params): ?Order
    {
        $productsPrepare = $this->prepareProductItemsForAttach($params);

        DB::beginTransaction();

        /** @var \Domain\Common\Models\CustomMedia[] $medias */
        $medias = [];

        try {
            $orderParams = [
                "user_id" => $params->user->id,
                "admin_id" => $params->admin_id,
                "order_status_id" => $params->order_status_id,
                "importance_id" => $params->importance_id,
                "comment_user" => $params->comment_user,
                "payment_method_id" => $params->payment_method_id,
                'comment_admin' => $params->comment_admin,
                'customer_bill_description' => $params->customer_bill_description,
                'customer_bill_status_id' => $params->customer_bill_status_id ?: Order::DEFAULT_CUSTOMER_BILL_STATUS_ID,
                'provider_bill_description' => $params->provider_bill_description,
                'provider_bill_status_id' => $params->provider_bill_status_id ?: Order::DEFAULT_PROVIDER_BILL_STATUS_ID,
                "request" => [
                    "name" => $params->request_name,
                    "email" => $params->request_email,
                    "phone" => $params->request_phone,
                ],
            ];

            $order = Order::forceCreate($orderParams);

            $order->products()->attach($productsPrepare);

            foreach ($params->attachment as $file) {
                $medias[] = $order->addMedia($file)->toMediaCollection(Order::MC_INITIAL_ATTACHMENT);
            }

            $productsPrepareForEvent = $this->prepareProductItemsForEvent($params);
            $orderEvent = new OrderEvent();
            $orderEvent->payload = [
                'order' => $orderParams,
                'products' => $productsPrepareForEvent,
            ];
            $orderEvent->type = $params->order_event_type;

            $orderEvent->order()->associate($order);
            $orderEvent->user()->associate($params->event_user);
            $orderEvent->save();

            $this->syncAndSaveMediasAction->execute($order, $params->customerInvoices, Order::MC_CUSTOMER_INVOICES);
            $this->syncAndSaveMediasAction->execute($order, $params->supplierInvoices, Order::MC_SUPPLIER_INVOICES);
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

    /**
     * @phpstan-param \Domain\Orders\DTOs\CreateOrderParamsDTO $params
     *
     * @phpstan-return array<int, array>
     */
    private function prepareProductItemsForAttach(CreateOrderParamsDTO $params): array
    {
        $initOrdering = self::DEFAULT_ORDERING;

        $productsPrepare = [];

        /** @var \Domain\Orders\DTOs\OrderProductItemDTO $productItem */
        foreach (collect($params->productItems)->sortBy('ordering')->sortBy('id')->values()->toArray() as $productItem) {
            $productsPrepare[$productItem->product->id] = [
                'count' => $productItem->count ?? 1,
                'name' => $productItem->name ?? $productItem->product->name,
                'unit' => $productItem->unit ?? $productItem->product->unit,
                'ordering' => $productItem->ordering ?: ($initOrdering = $initOrdering + self::ORDERING_STEP),
                'price_retail_rub' => $productItem->price_retail_rub ?: $productItem->product->price_retail_rub,
                'price_retail_rub_origin' => $productItem->product->price_retail_rub,
            ];
        }

        return $productsPrepare;
    }

    /**
     * @phpstan-param \Domain\Orders\DTOs\CreateOrderParamsDTO $params
     *
     * @phpstan-return array<int, array>
     */
    private function prepareProductItemsForEvent(CreateOrderParamsDTO $params): array
    {
        $initOrdering = self::DEFAULT_ORDERING;

        $productsPrepare = [];

        /** @var \Domain\Orders\DTOs\OrderProductItemDTO $productItem */
        foreach (collect($params->productItems)->sortBy('ordering')->sortBy('id')->values()->toArray() as $productItem) {
            $productsPrepare[$productItem->product->id] = [
                'count' => $productItem->count ?? 1,
                'name' => $productItem->name ?? $productItem->product->name,
                'unit' => $productItem->unit ?? $productItem->product->unit,
                'ordering' => $productItem->ordering ?: ($initOrdering = $initOrdering + self::ORDERING_STEP),
                'price_retail_rub' => $productItem->price_retail_rub ?: $productItem->product->price_retail_rub,
                'price_retail_rub_origin' => $productItem->product->price_retail_rub,
                // for event
                'price_purchase' => $productItem->product->price_purchase,
                'price_purchase_currency_id' => $productItem->product->price_purchase_currency_id,
                'price_retail' => $productItem->product->price_retail,
                'price_retail_currency_id' => $productItem->product->price_retail_currency_id,
            ];
        }

        return $productsPrepare;
    }
}

<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DTOs\UpdateOrderCustomerInvoicesParamsDTO;
use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Illuminate\Support\Facades\Cache;
use Support\H;

class UpdateOrderCustomerInvoicesAction
{
    /**
     * @var \Domain\Orders\Actions\SaveOrderMediasAction
     */
    private SaveOrderMediasAction $saveOrderMediasAction;

    /**
     * @param \Domain\Orders\Actions\SaveOrderMediasAction $saveOrderMediasAction
     */
    public function __construct(SaveOrderMediasAction $saveOrderMediasAction)
    {
        $this->saveOrderMediasAction = $saveOrderMediasAction;
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderCustomerInvoicesParamsDTO $params
     *
     * @return void
     */
    public function execute(UpdateOrderCustomerInvoicesParamsDTO $params): void
    {
        if (!$this->hasChanges($params)) {
            return;
        }

        $shouldSave = false;

        // TODO do the same for other parts of the code and for UpdateOrderSupplierInvoicesAction
        if ($this->propertyHasChanged($params, 'customer_bill_status_id')) {
            $params->order->customer_bill_status_id = $params->customer_bill_status_id;
            $shouldSave = true;
        }

        if ($this->propertyHasChanged($params, 'customer_bill_description')) {
            $params->order->customer_bill_description = $params->customer_bill_description;
            $shouldSave = true;
        }

        if ($shouldSave) {
            $params->order->save();
        }

        $this->saveOrderMediasAction->execute($params->order, $params->invoices, Order::MC_CUSTOMER_INVOICES);

        $this->createOrderEvent($params);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderCustomerInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function hasChanges(UpdateOrderCustomerInvoicesParamsDTO $params): bool
    {
        return (string)$params->order->getOriginal('customer_bill_status_id') !== (string)$params->customer_bill_status_id ||
            (string)$params->order->getOriginal('customer_bill_description') !== (string)$params->customer_bill_description ||
            $this->hasNewInvoices($params) ||
            $this->hasDeletedInvoices($params);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderCustomerInvoicesParamsDTO $params
     *
     * @return string
     */
    private function getOrderEventDescription(UpdateOrderCustomerInvoicesParamsDTO $params): string
    {
        $orderEventDescription = '';

        if ((string)$params->order->getOriginal('customer_bill_status_id') !== (string)$params->customer_bill_status_id) {
            $billStatus = BillStatus::query()->findOrFail($params->customer_bill_status_id);
            $orderEventDescription .= sprintf('Статус: %s. ', $billStatus->name);
        }

        if ((string)$params->order->getOriginal('customer_bill_description') !== (string)$params->customer_bill_description) {
            $orderEventDescription .= sprintf('Комментарий: %s. ', $params->customer_bill_description);
        }

        $hasNewInvoices = $this->hasNewInvoices($params);
        $hasDeletedInvoices = $this->hasDeletedInvoices($params);
        if ($hasNewInvoices || $hasDeletedInvoices) {
            $detailed = $hasNewInvoices && $hasDeletedInvoices
                ? 'добавил и удалил.'
                : (
                    $hasNewInvoices
                        ? 'добавил.'
                        : 'удалил'
                );
            $orderEventDescription .= sprintf('Файлы: %s', $detailed);
        }

        return $orderEventDescription;
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderCustomerInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function hasNewInvoices(UpdateOrderCustomerInvoicesParamsDTO $params): bool
    {
        return collect($params->invoices)->isNotEmpty() && collect($params->invoices)->contains(fn(array $file) => $file['id'] === null);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderCustomerInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function hasDeletedInvoices(UpdateOrderCustomerInvoicesParamsDTO $params): bool
    {
        return Cache::store('array')->rememberForever(sprintf('%s-%s', static::class, $params->order->id), function() use($params) {
            $payloadInvoicesIds = collect($params->invoices)->pluck('id')->filter()->values()->toArray();
            $currentInvoicesIds = $params->order->customer_invoices->pluck('id')->filter()->values()->toArray();

            return count($currentInvoicesIds) !== 0 && count($currentInvoicesIds) !== count($payloadInvoicesIds);
        });
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderCustomerInvoicesParamsDTO $params
     *
     * @return void
     */
    private function createOrderEvent(UpdateOrderCustomerInvoicesParamsDTO $params): void
    {
        $orderEventPayload = [
            'description' => $this->getOrderEventDescription($params),
        ];

        if ((string)$params->order->getOriginal('customer_bill_status_id') !== (string)$params->customer_bill_status_id) {
            $orderEventPayload['customer_bill_status_id'] = $params->customer_bill_status_id;
        }

        if ((string)$params->order->getOriginal('customer_bill_description') !== (string)$params->customer_bill_description) {
            $orderEventPayload['customer_bill_status_id'] = $params->customer_bill_status_id;
        }

        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::update_customer_invoice();
        $orderEvent->payload = $orderEventPayload;
        $orderEvent->order()->associate($params->order);
        if ($params->user) {
            $orderEvent->user()->associate($params->user);
        }
        $orderEvent->save();
    }

    private function propertyHasChanged(UpdateOrderCustomerInvoicesParamsDTO $params, $propertyName): bool
    {
        return H::runtimeCache(
            sprintf('%s-%s-%s', static::class, $params->order->id, $propertyName),
            $params->order->getOriginal($propertyName) !== (string)$params->$propertyName
        );
    }
}

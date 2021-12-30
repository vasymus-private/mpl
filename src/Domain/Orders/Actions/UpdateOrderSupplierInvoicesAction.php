<?php

namespace Domain\Orders\Actions;

use Domain\Orders\DTOs\UpdateOrderSupplierInvoicesParamsDTO;
use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\BillStatus;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;

class UpdateOrderSupplierInvoicesAction
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
     * @param \Domain\Orders\DTOs\UpdateOrderSupplierInvoicesParamsDTO $params
     *
     * @return void
     */
    public function execute(UpdateOrderSupplierInvoicesParamsDTO $params): void
    {
        if (!$this->hasChanges($params)) {
            return;
        }

        if ((string)$params->order->getOriginal('provider_bill_status_id') !== (string)$params->provider_bill_status_id) {
            $params->order->provider_bill_status_id = $params->provider_bill_status_id;
        }

        if ((string)$params->order->getOriginal('provider_bill_description') !== (string)$params->provider_bill_description) {
            $params->order->provider_bill_description = $params->provider_bill_description;
        }

        $this->saveOrderMediasAction->execute($params->order, $params->invoices, Order::MC_SUPPLIER_INVOICES);

        $this->createOrderEvent($params);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderSupplierInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function hasChanges(UpdateOrderSupplierInvoicesParamsDTO $params): bool
    {
        return (string)$params->order->getOriginal('provider_bill_status_id') !== (string)$params->provider_bill_status_id ||
            (string)$params->order->getOriginal('provider_bill_description') !== (string)$params->provider_bill_description ||
            $this->hasNewInvoices($params) ||
            $this->hasDeletedInvoices($params);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderSupplierInvoicesParamsDTO $params
     *
     * @return string
     */
    private function getOrderEventDescription(UpdateOrderSupplierInvoicesParamsDTO $params): string
    {
        $orderEventDescription = '';

        if ((string)$params->order->getOriginal('provider_bill_status_id') !== (string)$params->provider_bill_status_id) {
            $billStatus = BillStatus::query()->findOrFail($params->provider_bill_status_id);
            $orderEventDescription .= sprintf('Статус: %s.', $billStatus->name);
        }

        if ((string)$params->order->getOriginal('provider_bill_description') !== (string)$params->provider_bill_description) {
            $orderEventDescription .= sprintf('Комментарий: %s.', $params->provider_bill_description);
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
     * @param \Domain\Orders\DTOs\UpdateOrderSupplierInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function hasNewInvoices(UpdateOrderSupplierInvoicesParamsDTO $params): bool
    {
        return collect($params->invoices)->contains(fn(array $file) => $file['id'] === null);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderSupplierInvoicesParamsDTO $params
     *
     * @return bool
     */
    private function hasDeletedInvoices(UpdateOrderSupplierInvoicesParamsDTO $params): bool
    {
        $payloadInvoicesIds = collect($params->invoices)->pluck('id')->filter()->values()->toArray();
        $currentInvoicesIds = $params->order->customer_invoices->pluck('id')->filter()->values()->toArray();

        return count($currentInvoicesIds) !== count($payloadInvoicesIds);
    }

    /**
     * @param \Domain\Orders\DTOs\UpdateOrderSupplierInvoicesParamsDTO $params
     *
     * @return void
     */
    private function createOrderEvent(UpdateOrderSupplierInvoicesParamsDTO $params): void
    {
        $orderEventPayload = [
            'description' => $this->getOrderEventDescription($params),
        ];

        if ((string)$params->order->getOriginal('provider_bill_status_id') !== (string)$params->provider_bill_status_id) {
            $orderEventPayload['provider_bill_status_id'] = $params->provider_bill_status_id;
        }

        if ((string)$params->order->getOriginal('provider_bill_description') !== (string)$params->provider_bill_description) {
            $orderEventPayload['provider_bill_status_id'] = $params->provider_bill_status_id;
        }

        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::update_supplier_invoice();
        $orderEvent->payload = $orderEventPayload;
        $orderEvent->order()->associate($params->order);
        if ($params->user) {
            $orderEvent->user()->associate($params->user);
        }
        $orderEvent->save();
    }
}

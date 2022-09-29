<?php

namespace Domain\Orders\Actions\CreateOrUpdateOrder;

use Domain\Common\Actions\BaseAction;
use Domain\Orders\Actions\ChangeOrderProductsAction;
use Domain\Orders\Actions\CreateOrderAction;
use Domain\Orders\Actions\DefaultUpdateOrderAction;
use Domain\Orders\Actions\OMS\HandleChangeOrderStatusAction;
use Domain\Orders\Actions\UpdateOrderCustomerInvoicesAction;
use Domain\Orders\DTOs\CreateOrderParamsDTO;
use Domain\Orders\DTOs\CreateOrUpdateOrderDTO;
use Domain\Orders\DTOs\DefaultUpdateOrderParams;
use Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO;
use Domain\Orders\Models\Order;

class CreateOrUpdateOrderAction extends BaseAction
{
    /**
     * @var \Domain\Orders\Actions\CreateOrderAction
     */
    private CreateOrderAction $createOrderAction;

    /**
     * @var \Domain\Orders\Actions\DefaultUpdateOrderAction
     */
    private DefaultUpdateOrderAction $defaultUpdateOrderAction;

    /**
     * @var \Domain\Orders\Actions\OMS\HandleChangeOrderStatusAction
     */
    private HandleChangeOrderStatusAction $handleChangeOrderStatusAction;

    /**
     * @var \Domain\Orders\Actions\UpdateOrderCustomerInvoicesAction
     */
    private UpdateOrderCustomerInvoicesAction $updateOrderCustomerInvoicesAction;

    /**
     * @var \Domain\Orders\Actions\ChangeOrderProductsAction
     */
    private ChangeOrderProductsAction $changeOrderProductsAction;

    /**
     * @param \Domain\Orders\Actions\CreateOrderAction $createOrderAction
     * @param \Domain\Orders\Actions\DefaultUpdateOrderAction $defaultUpdateOrderAction
     * @param \Domain\Orders\Actions\OMS\HandleChangeOrderStatusAction $handleChangeOrderStatusAction
     * @param \Domain\Orders\Actions\UpdateOrderCustomerInvoicesAction $updateOrderCustomerInvoicesAction
     * @param \Domain\Orders\Actions\ChangeOrderProductsAction $changeOrderProductsAction
     */
    public function __construct(
        CreateOrderAction $createOrderAction,
        DefaultUpdateOrderAction $defaultUpdateOrderAction,
        HandleChangeOrderStatusAction $handleChangeOrderStatusAction,
        UpdateOrderCustomerInvoicesAction $updateOrderCustomerInvoicesAction,
        ChangeOrderProductsAction $changeOrderProductsAction
    ) {
        $this->createOrderAction = $createOrderAction;
        $this->defaultUpdateOrderAction = $defaultUpdateOrderAction;
        $this->handleChangeOrderStatusAction = $handleChangeOrderStatusAction;
        $this->updateOrderCustomerInvoicesAction = $updateOrderCustomerInvoicesAction;
        $this->changeOrderProductsAction = $changeOrderProductsAction;
    }

    /**
     * @param \Domain\Orders\DTOs\CreateOrUpdateOrderDTO $dto
     * @param \Domain\Orders\Models\Order|null $target
     *
     * @return \Domain\Orders\Models\Order|null
     */
    public function execute(CreateOrUpdateOrderDTO $dto, Order $target = null): ?Order
    {
        if (! $target) {
            return $this->createOrderAction->execute(
                $this->mapCreateOrUpdateOrderDtoToCreateOrderParamsDto($dto)
            );
        }

        $this->defaultUpdateOrderAction->execute(
            $this->mapCreateOrUpdateOrderDtoToDefaultUpdateOrderParamsDto($dto, $target)
        );

        /** @var \Domain\Orders\Models\Order $updatedOrder */
        $updatedOrder = Order::query()->findOrFail($target->id);

        $this->handleChangeOrderStatusAction->execute(
            $updatedOrder,
            $dto->order_status_id,
            $dto->event_user
        );

        $this->updateOrderCustomerInvoicesAction->execute(
            $this->mapCreateOrUpdateOrderDtoUpdateOrderInvoicesParamsDTO($dto, $target)
        );

        $this->changeOrderProductsAction->execute(
            $target,
            $dto->event_user,
            $this->mapProductItemsToArrayProductItems($dto->productItems)
        );

        return $updatedOrder;
    }

    /**
     * @param \Domain\Orders\DTOs\CreateOrUpdateOrderDTO $createOrUpdateOrderDTO
     *
     * @return \Domain\Orders\DTOs\CreateOrderParamsDTO
     */
    private function mapCreateOrUpdateOrderDtoToCreateOrderParamsDto(CreateOrUpdateOrderDTO $createOrUpdateOrderDTO): CreateOrderParamsDTO
    {
        return new CreateOrderParamsDTO([
            'user' => $createOrUpdateOrderDTO->user,
            'event_user' => $createOrUpdateOrderDTO->event_user,
            'order_status_id' => $createOrUpdateOrderDTO->order_status_id,
            'request_email' => $createOrUpdateOrderDTO->request_email,
            'request_name' => $createOrUpdateOrderDTO->request_name,
            'request_phone' => $createOrUpdateOrderDTO->request_phone,
            'payment_method_id' => $createOrUpdateOrderDTO->payment_method_id,
            'comment_user' => $createOrUpdateOrderDTO->comment_user,
            'admin_id' => $createOrUpdateOrderDTO->admin_id,
            'importance_id' => $createOrUpdateOrderDTO->importance_id,
            'customer_bill_description' => $createOrUpdateOrderDTO->customer_bill_description,
            'customer_bill_status_id' => $createOrUpdateOrderDTO->customer_bill_status_id,
            'customerInvoices' => $createOrUpdateOrderDTO->customerInvoices,
            'provider_bill_description' => $createOrUpdateOrderDTO->provider_bill_description,
            'provider_bill_status_id' => $createOrUpdateOrderDTO->provider_bill_status_id,
            'supplierInvoices' => $createOrUpdateOrderDTO->supplierInvoices,
            'comment_admin' => $createOrUpdateOrderDTO->comment_admin,
            'order_event_type' => $createOrUpdateOrderDTO->order_event_type,
            'productItems' => $createOrUpdateOrderDTO->productItems,
        ]);
    }

    /**
     * @param \Domain\Orders\DTOs\CreateOrUpdateOrderDTO $createOrUpdateOrderDTO
     * @param \Domain\Orders\Models\Order $target
     *
     * @return \Domain\Orders\DTOs\DefaultUpdateOrderParams
     */
    private function mapCreateOrUpdateOrderDtoToDefaultUpdateOrderParamsDto(CreateOrUpdateOrderDTO $createOrUpdateOrderDTO, Order $target): DefaultUpdateOrderParams
    {
        return new DefaultUpdateOrderParams([
            'order' => $target,
            'event_user' => $createOrUpdateOrderDTO->event_user,
            'name' => $createOrUpdateOrderDTO->request_name,
            'email' => $createOrUpdateOrderDTO->request_email,
            'phone' => $createOrUpdateOrderDTO->request_phone,
            'payment_method_id' => $createOrUpdateOrderDTO->payment_method_id,
            'comment_user' => $createOrUpdateOrderDTO->comment_user,
            'admin_id' => $createOrUpdateOrderDTO->admin_id,
            'importance_id' => $createOrUpdateOrderDTO->importance_id,
            'comment_admin' => $createOrUpdateOrderDTO->comment_admin,
        ]);
    }

    /**
     * @param \Domain\Orders\DTOs\CreateOrUpdateOrderDTO $createOrUpdateOrderDTO
     * @param \Domain\Orders\Models\Order $target
     *
     * @return \Domain\Orders\DTOs\UpdateOrderInvoicesParamsDTO
     */
    private function mapCreateOrUpdateOrderDtoUpdateOrderInvoicesParamsDTO(CreateOrUpdateOrderDTO $createOrUpdateOrderDTO, Order $target): UpdateOrderInvoicesParamsDTO
    {
        return new UpdateOrderInvoicesParamsDTO([
            'order' => $target,
            'customer_bill_status_id' => $createOrUpdateOrderDTO->customer_bill_status_id,
            'customer_bill_description' => $createOrUpdateOrderDTO->customer_bill_description,
            'customerInvoices' => $this->mapMediaDTOsToFileDtoArrays($createOrUpdateOrderDTO->customerInvoices),
            'provider_bill_status_id' => $createOrUpdateOrderDTO->provider_bill_status_id,
            'provider_bill_description' => $createOrUpdateOrderDTO->provider_bill_description,
            'supplierInvoices' => $this->mapMediaDTOsToFileDtoArrays($createOrUpdateOrderDTO->supplierInvoices),
            'event_user' => $createOrUpdateOrderDTO->event_user,
        ]);
    }

    /**
     * @param \Domain\Orders\DTOs\OrderProductItemDTO[] $orderProductItemDTOs
     *
     * @return array[]
     */
    private function mapProductItemsToArrayProductItems(array $orderProductItemDTOs): array
    {
        $result = [];

        foreach ($orderProductItemDTOs as $orderProductItemDTO) {
            $result[] = $orderProductItemDTO->toArray();
        }

        return $result;
    }

    /**
     * @param \Domain\Common\DTOs\MediaDTO[] $mediaDTOs
     *
     * @return array[] @see {@link \Domain\Common\DTOs\FileDTO}
     */
    private function mapMediaDTOsToFileDtoArrays(array $mediaDTOs): array
    {
        $result = [];

        foreach ($mediaDTOs as $mediaDTO) {
            $result[] = [
                'id' => $mediaDTO->id,
                'name' => $mediaDTO->name,
                'file_name' => $mediaDTO->file_name,
                'path' => $mediaDTO->file ? $mediaDTO->file->path() : null,
                'file' => $mediaDTO->file,
            ];
        }

        return $result;
    }
}

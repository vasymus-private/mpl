<?php

namespace Domain\Orders\Actions\CreateOrUpdateOrder;

use Domain\Common\Actions\BaseAction;
use Domain\Orders\Actions\CreateOrderAction;
use Domain\Orders\Actions\DefaultUpdateOrderAction;
use Domain\Orders\DTOs\CreateOrderParamsDTO;
use Domain\Orders\DTOs\CreateOrUpdateOrderDTO;
use Domain\Orders\DTOs\DefaultUpdateOrderParams;
use Domain\Orders\Models\Order;

class CreateOrUpdateOrderAction extends BaseAction
{
    /**
     * @var \Domain\Orders\Actions\CreateOrderAction
     */
    private CreateOrderAction $createOrderAction;

    private DefaultUpdateOrderAction $defaultUpdateOrderAction;

    public function __construct(
        CreateOrderAction $createOrderAction,
        DefaultUpdateOrderAction $defaultUpdateOrderAction
    )
    {
        $this->createOrderAction = $createOrderAction;
        $this->defaultUpdateOrderAction = $defaultUpdateOrderAction;
    }

    /**
     * @param \Domain\Orders\DTOs\CreateOrUpdateOrderDTO $dto
     * @param \Domain\Orders\Models\Order|null $target
     *
     * @return void
     */
    public function execute(CreateOrUpdateOrderDTO $dto, Order $target = null): void
    {
        if (!$target) {
            $this->createOrderAction->execute(
                $this->mapCreateOrUpdateOrderDtoToCreateOrderParamsDto($dto)
            );

            return;
        }

        $this->defaultUpdateOrderAction->execute(
            $this->mapCreateOrUpdateOrderDtoToDefaultUpdateOrderParamsDto($dto, $target)
        );
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
            'order_status_id' => $createOrUpdateOrderDTO->order_status_id,
            'importance_id' => $createOrUpdateOrderDTO->importance_id,
            'order_event_type' => $createOrUpdateOrderDTO->order_event_type,
            'comment_user' => $createOrUpdateOrderDTO->comment_user,
            'request_name' => $createOrUpdateOrderDTO->request_name,
            'request_email' => $createOrUpdateOrderDTO->request_email,
            'request_phone' => $createOrUpdateOrderDTO->request_phone,
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
            'user' => $createOrUpdateOrderDTO->user,
            'comment_user' => $createOrUpdateOrderDTO->comment_user,
            'comment_admin' => $createOrUpdateOrderDTO->comment_admin,
            'payment_method_id' => $createOrUpdateOrderDTO->payment_method_id,
            'admin_id' => $createOrUpdateOrderDTO->admin_id,
            'importance_id' => $createOrUpdateOrderDTO->importance_id,
            'name' => $createOrUpdateOrderDTO->request_name,
            'email' => $createOrUpdateOrderDTO->request_email,
            'phone' => $createOrUpdateOrderDTO->request_phone,
        ]);
    }
}

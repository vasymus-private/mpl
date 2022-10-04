<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateUpdateOrderRequest;
use App\Http\Resources\Admin\OrderResource;
use Domain\Orders\Actions\CreateOrUpdateOrder\CreateOrUpdateOrderAction;
use Domain\Orders\Enums\OrderEventType;
use Support\H;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateOrderRequest $request
     * @param \Domain\Orders\Actions\CreateOrUpdateOrder\CreateOrUpdateOrderAction $createOrUpdateOrderAction
     *
     * @return \App\Http\Resources\Admin\OrderResource|\Illuminate\Http\Response
     */
    public function store(CreateUpdateOrderRequest $request, CreateOrUpdateOrderAction $createOrUpdateOrderAction)
    {
        $admin = H::admin();

        $createOrUpdateOrderDto = $request->prepare();
        $createOrUpdateOrderDto->user = $admin;
        $createOrUpdateOrderDto->event_user = $admin;
        $createOrUpdateOrderDto->order_event_type = OrderEventType::admin_created();
        $order = $createOrUpdateOrderAction->execute($createOrUpdateOrderDto);

        if (! $order) {
            return response('', Response::HTTP_FAILED_DEPENDENCY);
        }

        return new OrderResource($order);
    }

    /**
     * @param \App\Http\Requests\Admin\Ajax\CreateUpdateOrderRequest $request
     * @param \Domain\Orders\Actions\CreateOrUpdateOrder\CreateOrUpdateOrderAction $createOrUpdateOrderAction
     *
     * @return \App\Http\Resources\Admin\OrderResource|\Illuminate\Http\Response
     */
    public function update(CreateUpdateOrderRequest $request, CreateOrUpdateOrderAction $createOrUpdateOrderAction)
    {
        /** @var \Domain\Orders\Models\Order $order */
        $order = $request->admin_order;

        $admin = H::admin();
        $createOrUpdateOrderDto = $request->prepare();
        $createOrUpdateOrderDto->event_user = $admin;
        $order = $createOrUpdateOrderAction->execute($createOrUpdateOrderDto, $order);

        if (! $order) {
            return response('', Response::HTTP_FAILED_DEPENDENCY);
        }

        return new OrderResource($order);
    }
}

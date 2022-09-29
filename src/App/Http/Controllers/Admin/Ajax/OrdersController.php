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

    public function update(CreateUpdateOrderRequest $request)
    {
    }
}

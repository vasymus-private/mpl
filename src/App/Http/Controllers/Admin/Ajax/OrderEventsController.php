<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Resources\Admin\OrderEventResource;
use Illuminate\Http\Request;

class OrderEventsController extends BaseAdminController
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function index(Request $request)
    {
        /** @var \Domain\Orders\Models\Order $order */
        $order = $request->admin_order;

        $order->load(['events', 'events.user']);

        return OrderEventResource::collection($order->events);
    }
}

<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Resources\Admin\Ajax\OrderPingResponseResource;
use Domain\Orders\Models\Order;
use Illuminate\Http\Request;

class ShowOrderBusyController extends BaseAdminController
{
    public function __invoke(Request $request)
    {
        /** @var int[] | string[] $ids */
        $ids = $request->ids;

        if (empty($ids)) {
            return [
                'data' => [],
            ];
        }

        $orders = Order::query()
            ->select(['id', 'busy_by_id', 'busy_at'])
            ->whereIn(sprintf('%s.id', Order::TABLE), $ids)
            ->get();

        return OrderPingResponseResource::collection($orders);
    }
}

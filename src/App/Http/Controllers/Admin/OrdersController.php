<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\OrderEventResource;
use App\Http\Resources\Admin\OrderItemResource;
use App\Http\Resources\Admin\OrderResource;
use Carbon\Exceptions\InvalidFormatException;
use Domain\Orders\Models\Order;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Support\H;

class OrdersController extends BaseAdminController
{
    public function index(Request $request)
    {
        return view("admin.pages.orders.orders");
    }

    public function indexTemp(Request $request)
    {
        $inertia = H::getAdminInertia();

        $query = Order::query()->select(['*'])->with(['admin', 'products']);
        $table = Order::TABLE;
        $usersT = BaseUser::TABLE;
        $DATE_FORMAT_DB_QUERY = 'Y-m-d H:i:s';

        if ($request->date_from) {
            try {
                $parsed = Carbon::parse($request->date_from);
            } catch (InvalidFormatException $exception) {
                $parsed = null;
            }
            if ($parsed) {
                $query->where("$table.created_at", ">=", $parsed->format($DATE_FORMAT_DB_QUERY));
            }
        }

        if ($request->date_to) {
            try {
                $parsed = Carbon::parse($request->date_to);
            } catch (InvalidFormatException $exception) {
                $parsed = null;
            }
            if ($parsed) {
                $query->where("$table.created_at", "<=", $parsed->format($DATE_FORMAT_DB_QUERY));
            }
        }

        if ($request->email || $request->name) {
            $query->join($usersT, "$table.user_id", "=", "$usersT.id");
            if ($request->email) {
                $query->where("$usersT.email", "LIKE", "%{$request->email}%");
            }
            if ($request->name) {
                $query->where("$usersT.name", "LIKE", "%{$request->name}%");
            }
        }

        if ($request->admin_id) {
            $query->where("$table.admin_id", $request->admin_id);
        }

        if ($request->order_id) {
            $query->where("$table.id", $request->order_id);
        }

        $query->orderBy("$table.id", 'desc');

        return $inertia->render('Orders/Index', [
            'orders' => OrderItemResource::collection($query->paginate($request->per_page)),
        ]);
    }

    public function create(Request $request)
    {
        $order = new Order();

        return view("admin.pages.orders.order", compact("order"));
    }

    public function createTemp(Request $request)
    {
        $inertia = H::getAdminInertia();

        $order = $request->copy_id
            ? Order::query()->find($request->copy_id)
            : null;

        return $inertia->render('Orders/CreateEdit', [
            'order' => $order
                ? (new OrderResource($order))->toArray($request)
                : null,
        ]);
    }

    public function edit(Request $request)
    {
        /** @var \Domain\Orders\Models\Order $order */
        $order = $request->admin_order;
        $order->load(['products.parent', 'products.media', 'user', 'admin', 'status', 'payment', 'media']);

        return view("admin.pages.orders.order", compact("order"));
    }

    public function editTemp(Request $request)
    {
        $inertia = H::getAdminInertia();

        /** @var \Domain\Orders\Models\Order $order */
        $order = $request->admin_order;

        $order->load(['events', 'events.user']);

        return $inertia->render('Orders/CreateEdit', [
            'order' => (new OrderResource($order))->toArray($request),
            'orderEvents' => OrderEventResource::collection($order->events),
        ]);
    }
}

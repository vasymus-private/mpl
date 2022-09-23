<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\CreateUpdateOrderRequest;
use Domain\Orders\Actions\CreateOrUpdateOrder\CreateOrUpdateOrderAction;

class OrdersController extends BaseAdminController
{
    public function store(CreateUpdateOrderRequest $request, CreateOrUpdateOrderAction $createOrUpdateOrderAction)
    {
        $createOrUpdateOrderAction->execute($request->prepare());
    }

    public function update(CreateUpdateOrderRequest $request)
    {
    }
}

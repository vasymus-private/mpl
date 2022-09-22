<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\Orders\Actions\HandleCancelOrderAction;
use Domain\Orders\Actions\HandleNotCancelOrderAction;
use Illuminate\Http\Request;
use Support\H;
use Symfony\Component\HttpFoundation\Response;

class OrdersCancelController extends BaseAdminController
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'should_cancel' => 'required|boolean',
            'cancel_message' => 'string|max:250',
        ]);

        /** @var \Domain\Orders\Models\Order $order */
        $order = $request->admin_order;
        /** @var bool $shouldCancel */
        $shouldCancel = $request->should_cancel;
        /** @var string|null $cancelMessage */
        $cancelMessage = $request->cancel_message;

        if ($shouldCancel) {
            HandleCancelOrderAction::cached()->execute($order, $cancelMessage, H::admin());

            return response('', Response::HTTP_NO_CONTENT);
        }

        HandleNotCancelOrderAction::cached()->execute($order, H::admin());

        return response('', Response::HTTP_NO_CONTENT);
    }
}

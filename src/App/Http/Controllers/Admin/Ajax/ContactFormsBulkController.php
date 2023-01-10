<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\ContactFormsBulkDeleteRequest;
use Domain\Users\Models\ContactForm;
use Symfony\Component\HttpFoundation\Response;

class ContactFormsBulkController extends BaseAdminController
{
    /**
     * @param \App\Http\Requests\Admin\Ajax\ContactFormsBulkDeleteRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(ContactFormsBulkDeleteRequest $request)
    {
        $items = ContactForm::query()->whereIn(sprintf('%s.id', ContactForm::TABLE), $request->ids)->get();

        $items->each(function (ContactForm $item) {
            $item->delete();
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}

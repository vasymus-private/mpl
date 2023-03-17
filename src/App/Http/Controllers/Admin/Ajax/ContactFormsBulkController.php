<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\ContactFormsBulkDeleteRequest;
use App\Http\Requests\Admin\Ajax\ContactFormsBulkReadStateRequest;
use Domain\Users\Actions\ContactForm\MarkReadAction;
use Domain\Users\Actions\ContactForm\MarkUnreadAction;
use Domain\Users\Models\ContactForm;
use Support\H;
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

    /**
     * @param \App\Http\Requests\Admin\Ajax\ContactFormsBulkReadStateRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function readState(ContactFormsBulkReadStateRequest $request)
    {
        $items = ContactForm::query()->whereIn(sprintf('%s.id', ContactForm::TABLE), $request->ids)->get();

        $admin = H::admin();
        $now = now();

        $items->each(function(ContactForm $contactForm) use($request, $admin, $now) {
            if ($request->isRead) {
                MarkReadAction::cached()->execute($contactForm, $admin, $now);
                return true;
            }

            MarkUnreadAction::cached()->execute($contactForm);
            return true;
        });

        return response('', Response::HTTP_NO_CONTENT);
    }
}

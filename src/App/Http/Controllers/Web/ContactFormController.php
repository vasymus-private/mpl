<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Web\Ajax\ContactFormCreateRequest;
use Domain\Ip\Actions\GetIpAction;
use Domain\Users\Events\ContactFormCreatedEvent;
use Domain\Users\Models\ContactForm;
use Illuminate\Support\Carbon;

class ContactFormController extends BaseWebController
{
    /**
     * @param \App\Http\Requests\Web\Ajax\ContactFormCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ContactFormCreateRequest $request)
    {
        $ip = GetIpAction::cached()->execute($request->ip());

        $cf = new ContactForm();
        $cf->type = $request->type;
        $cf->ip = $ip->ip;
        $cf->name = $request->name;
        $cf->email = $request->email;
        $cf->phone = $request->phone;
        $cf->description = $request->description;
        $cf->created_at = Carbon::now();
        $cf->save();

        event(new ContactFormCreatedEvent($cf));

        return redirect()->back()->with('successContactForm', 1);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\ContactFormItemResource;
use App\Http\Resources\Admin\ContactFormResource;
use Domain\Users\Actions\ContactForm\MarkReadAction;
use Domain\Users\Models\ContactForm;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\H;

class ContactFormsController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = H::getAdminInertia();

        $query = ContactForm::query()->select(["*"])->with('ipDetails')->orderByDesc('id');

        if ($request->search) {
            $query->where(function (Builder $q) use ($request) {
                $q->where(sprintf('%s.name', ContactForm::TABLE), "LIKE", "%{$request->search}%")
                    ->orWhere(sprintf('%s.ip', ContactForm::TABLE), "LIKE", "%{$request->search}%")
                    ->orWhere(sprintf('%s.email', ContactForm::TABLE), "LIKE", "%{$request->search}%")
                    ->orWhere(sprintf('%s.phone', ContactForm::TABLE), "LIKE", "%{$request->search}%")
                    ->orWhere(sprintf('%s.description', ContactForm::TABLE), "LIKE", "%{$request->search}%");
            });
        }

        return $inertia->render('ContactForm/Index', [
            'contactForms' => ContactFormItemResource::collection($query->paginate($request->per_page)),
        ]);
    }

    public function show(Request $request)
    {
        $inertia = H::getAdminInertia();

        /** @var \Domain\Users\Models\ContactForm $contactForm */
        $contactForm = $request->admin_contact_form;

        MarkReadAction::cached()->execute($contactForm, H::admin(), now());

        return $inertia->render('ContactForm/Show', [
            'contactForm' => (new ContactFormResource($contactForm))->toArray($request),
        ]);
    }
}

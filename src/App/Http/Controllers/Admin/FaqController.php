<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\FaqItemResource;
use App\Http\Resources\Admin\FaqResource;
use Domain\FAQs\Models\FAQ;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Support\H;

class FaqController extends BaseAdminController
{
    public function index(Request $request)
    {
        $inertia = H::getAdminInertia();

        $query = FAQ::query()->select(["*"]);

        if ($request->search) {
            $query->where(function(Builder $q) use($request) {
                $q->where(sprintf('%s.name', FAQ::TABLE), "LIKE", "%{$request->search}%")
                    ->orWhere(sprintf('%s.question', FAQ::TABLE), "LIKE", "%{$request->search}%")
                    ->orWhere(sprintf('%s.answer', FAQ::TABLE), "LIKE", "%{$request->search}%");
            });
        }

        return $inertia->render('Faq/Index', [
            'faqs' => FaqItemResource::collection($query->paginate($request->per_page)),
        ]);
    }

    public function create(Request $request)
    {
        $inertia = H::getAdminInertia();

        return $inertia->render('Faq/CreateEdit');
    }

    public function edit(Request $request)
    {
        $inertia = H::getAdminInertia();

        /** @var \Domain\FAQs\Models\FAQ $faq */
        $faq = $request->admin_faq;

        return $inertia->render('Faq/CreateEdit', [
            'faq' => (new FaqResource($faq))->toArray($request),
        ]);
    }
}

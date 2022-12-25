<?php

namespace App\Http\Controllers\Web;

use Domain\FAQs\Models\FAQ;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class FaqController extends BaseWebController
{
    public function index(Request $request)
    {
        $faqs = FAQ::query()
            ->parents()
            ->active()
            ->with([
                'children' => function (HasMany $hm) {
                    /** @var \Domain\FAQs\QueryBuilders\FaqQueryBuilder $hm */
                    return $hm->active();
                },
            ])
            ->paginate();

        return view("web.pages.faqs.faqs", compact("faqs"));
    }

    public function show(Request $request)
    {
        /** @var \Domain\FAQs\Models\FAQ $faq */
        $faq = $request->faq_slug;

        return view("web.pages.faqs.faq", compact("faq"));
    }
}

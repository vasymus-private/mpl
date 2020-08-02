<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class FaqController extends BaseWebController
{
    public function index(Request $request)
    {
        return view("web.pages.faqs.faqs");
    }

    public function show(Request $request)
    {
        return view("web.pages.faqs.faq");
    }
}

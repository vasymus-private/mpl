<?php

namespace App\Http\Controllers;

use App\Mail\TestMarkupOrderShippedMail;
use App\Mail\TestMarkupResetPasswordMail;
use Domain\Common\Models\Currency;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(Request $request)
    {
        dump(Currency::cachedAll()->implode('id', ','));
        return view('test');
    }

    public function testEmailOrderMarkup()
    {
        return new TestMarkupOrderShippedMail();
    }

    public function testResetPasswordMarkup()
    {
        return new TestMarkupResetPasswordMail();
    }
}

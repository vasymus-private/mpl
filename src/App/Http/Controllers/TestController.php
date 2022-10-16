<?php

namespace App\Http\Controllers;

use App\Mail\TestMarkupOrderShippedMail;
use App\Mail\TestMarkupResetPasswordMail;

class TestController extends Controller
{
    private const HEADER_KEY_CONTENT_TYPE = 'Content-Type';
    private const HEADER_KEY_CONTENT_DISPOSITION = 'Content-Disposition';
    private const HEADER_VALUE_MIME_TYPE_PDF = 'application/pdf';
    private const HEADER_VALUE_CHARSET_UTF_8 = 'charset=utf-8';

    public function test()
    {
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

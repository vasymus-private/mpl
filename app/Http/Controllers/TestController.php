<?php

namespace App\Http\Controllers;

use App\Mail\OrderShippedMail;
use App\Mail\TestMarkupOrderShippedMail;
use App\Models\Category;
use App\Models\FAQ;
use App\Models\Product\Product;
use App\Models\User\User;
use App\Notifications\OrderShipped;
use App\Services\TransferFromOrigin\TransferFAQ2;
use App\Services\TruncateHTML\TruncateHTML;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Ramsey\Uuid\Uuid;
use SimpleXMLElement;

class TestController extends Controller
{
    public function test()
    {
        dump(Hash::make("secret"));

        return view('test');
    }

    public function testEmailOrder()
    {

    }

    public function testEmailOrderMarkup()
    {
        return new TestMarkupOrderShippedMail();
    }
}

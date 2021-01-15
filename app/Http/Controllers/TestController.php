<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FAQ;
use App\Models\Product\Product;
use App\Services\TransferFromOrigin\TransferFAQ2;
use App\Services\TruncateHTML\TruncateHTML;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use SimpleXMLElement;

class TestController extends Controller
{
    public function test()
    {
        dump(Hash::make("secret"));

        return view('test');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product\Product;
use App\Services\TransferFromOrigin\TransferFAQ2;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class TestController extends Controller
{
    public function test()
    {
//        (new TransferFAQ2())->parsePages();

        return view('test');
    }
}

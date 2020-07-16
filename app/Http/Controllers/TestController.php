<?php

namespace App\Http\Controllers;

use App\Services\TransferFromOrigin\TransferCategories;
use App\Services\TransferFromOrigin\TransferFAQ;
use App\Services\TransferFromOrigin\TransferManufacturers;
use App\Services\TransferFromOrigin\TransferProducts;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;

class TestController extends Controller
{
    public function test()
    {
        $tr = new TransferProducts();
        $tr->transfer();

        return view('test');
    }
}

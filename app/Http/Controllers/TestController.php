<?php

namespace App\Http\Controllers;

use App\Services\TransferFromOrigin\TransferCatalog;
use App\Services\TransferFromOrigin\TransferFAQ;
use App\Services\TransferFromOrigin\TransferManufacturers;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;

class TestController extends Controller
{
    public function test()
    {
        $tr = new TransferCatalog();
        $tr->transfer();

        return view('test');
    }
}

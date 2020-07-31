<?php

namespace App\Http\Controllers;

use App\Services\RandomProxies\Contracts\CanGetRandomProxies;
use App\Services\RandomProxies\Repositories\RandomProxiesCacheRepository;
use App\Services\TransferFromOrigin\TransferGallery;
use App\Services\TransferFromOrigin\TransferServicesAndArticles;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function test()
    {
        $tr = new TransferServicesAndArticles();
        //$tr->transfer();

        return view('test');
    }
}

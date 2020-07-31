<?php

namespace App\Http\Controllers;

use App\Services\RandomProxies\Contracts\CanGetRandomProxies;
use App\Services\RandomProxies\Repositories\RandomProxiesCacheRepository;
use App\Services\TransferFromOrigin\TransferGallery;
use App\Services\TransferFromOrigin\TransferServicesAndArticles;

class TestController extends Controller
{
    public function test()
    {
        $tr = new TransferServicesAndArticles();
        $path = $tr->fetchAndStoreHtml("/ukladka-shtuchnogo-parketa/");

        dump($path);

        return view('test');
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\RandomProxies\Contracts\CanGetRandomProxies;
use App\Services\RandomProxies\Repositories\RandomProxiesCacheRepository;
use App\Services\TransferFromOrigin\TransferGallery;

class TestController extends Controller
{
    public function test()
    {
        //dump(Storage::allFiles("seeds/products/offers-and-chars"));

//        $tr = new TransferGallery();
//        $tr->transfer();

        //$tr->transfer();
        //$tr->transferPrices();
        //$tr->fetchAndStoreRaw(23);
//        $tr->fetchAndStoreRawItem("/catalog/parket/massive_board/dub_art_parket.html");
//        $tr->fetchAndStoreRawItem("catalog/parketnyy_lak/Bona_Traffic.html");

        return view('test');
    }
}

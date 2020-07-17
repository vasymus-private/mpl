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
        //dump(Storage::allFiles("seeds/products/offers-and-chars"));


        $tr = new TransferProducts();
        $tr->transfer();
        //$tr->fetchAndStoreRaw(23);
//        $tr->fetchAndStoreRawItem("/catalog/parket/massive_board/dub_art_parket.html");
//        $tr->fetchAndStoreRawItem("catalog/parketnyy_lak/Bona_Traffic.html");

        return view('test');
    }
}

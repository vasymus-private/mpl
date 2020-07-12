<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Builder;
use Ixudra\Curl\Facades\Curl;

class TestController extends Controller
{
    public function test()
    {
        dump(Storage::get("seeds/manufacturers/seeds.json"));

        return view('test');


        /** @var Builder $builder */
        /*$builder = Curl::to("http://union.parket-lux.ru/brands/index.php");
        $builder->withOption('USERPWD', 'parket:parket');
        $response = $builder->get();*/

        $url = "http://union.parket-lux.ru/upload/resize_cache/iblock/988/108_51_1d7a58ff99b324185ccb5ad5dfbdb5e85/98896615ab719eb9a6336c66b4846c4f.png";

        dump(pathinfo($url));
        return view('test');

        $builder = Curl::to($url);
        $builder->withOption('USERPWD', 'parket:parket');
        //$response = $builder->download("108_51_1d7a58ff99b324185ccb5ad5dfbdb5e85/98896615ab719eb9a6336c66b4846c4f.png");
        $response = $builder->get();

        Storage::put("/seeds/manufacturers/media/1.png", $response);

        //dump($response);

        return view('test');
    }
}

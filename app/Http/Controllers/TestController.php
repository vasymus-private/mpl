<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class TestController extends Controller
{
    public function test()
    {
        $str = Storage::get("currencies-rate.xml");

        $valCurs = new SimpleXMLElement($str);
        $json = json_encode($valCurs);
        dump($json);
        dump((string)$valCurs);
        dump(json_decode($json, true));
        foreach ($valCurs as $valute) {
            dump("{$valute->CharCode}", $valute->getName());
        }

        return view('test');
    }
}

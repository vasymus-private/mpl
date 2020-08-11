<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class TestController extends Controller
{
    public function test()
    {
        Product
            ::query()
            ->where(function(Builder $query) {
                $query
                    ->orWhere(function(Builder $qu) {
                        /** @var Product|Builder $qu*/
                        $qu->variations();
                    })
                    ->orWhere(function(Builder $qu) {
                        /** @var Product|Builder $qu*/
                        $qu->doesntHaveVariations();
                    })
                ;
            })
            ->active()
            ->get();

        return view('test');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class TestController extends Controller
{
    public function test()
    {
        $category = Category::query()->find(1);
        $category->parentCategory;

        return view('test');
    }
}

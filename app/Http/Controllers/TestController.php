<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class TestController extends Controller
{
    public function test()
    {
        $webViews = [];

        $webDirs = File::directories(resource_path("views/web/pages"));

        foreach ($webDirs as $dir) {
            $files = File::files($dir);
            foreach ($files as $file) {
                dump("web.pages." . str_replace(".blade.php", "", $file->getFilename()));
            }
        }


        return view('test');
    }
}

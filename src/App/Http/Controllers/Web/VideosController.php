<?php

namespace App\Http\Controllers\Web;

use Domain\Products\Models\Category;
use Illuminate\Http\Request;

class VideosController extends BaseWebController
{
    public function index(Request $request)
    {
        return view("web.pages.videos.videos");
    }
}

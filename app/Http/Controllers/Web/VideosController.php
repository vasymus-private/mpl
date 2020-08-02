<?php

namespace App\Http\Controllers\Web;

use App\Models\Category;
use Illuminate\Http\Request;

class VideosController extends BaseWebController
{
    public function index(Request $request)
    {
        return view("web.pages.videos.videos");
    }
}

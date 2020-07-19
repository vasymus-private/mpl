<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function show(Request $request)
    {

    }

    public function checkout(Request $request)
    {
        // TODO if not login, create new user
        // and handle ordering
    }
}

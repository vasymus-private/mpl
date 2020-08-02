<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class CartController extends BaseWebController
{
    public function show(Request $request)
    {
        return view('web.pages.cart.cart');
    }
}

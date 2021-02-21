<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;

class ProductsController extends BaseAdminController
{
    public function index(Request $request)
    {
//        $products = Product::query()->notVariations()->paginate()
    }
}

<?php

namespace App\Http\Controllers;

use Algolia\AlgoliaSearch\SearchIndex;
use App\Mail\TestMarkupOrderShippedMail;
use App\Mail\TestMarkupResetPasswordMail;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Meilisearch\Endpoints\Indexes;

class TestController extends Controller
{
    public function test(Request $request)
    {
        Product::query()->toBase();
//        $product = Product::query()->withTrashed()->findOrFail(3235);
//        $product->forceDelete();
//        $product->name = 'Some test product';
//        $product->save();

//        DB::transaction(function() {
//            $table1 = new TempTableModel();
//            $table1->name = 'Hello2';
//            $table1->save();
//
//            throw new \Exception('temp');
//        });

//        $products = Product::search('клей', /*function(SearchIndex $algolia, string $query = null, array $options = []) {
//            return $algolia->search($query, $options);
//        }*/)
//            ->orderBy('ordering', 'asc')
//            ->options([
//                'filter' => 'info_prices_count > 4'
//            ])
//            ->where('info_prices_count > ')
//            ->get()
//            ->paginate(50)
//        ;

        $products = Product::search()->paginate(10);

        /**
        $query = Product::search($request->search);

        if ($request->min_price) {
        $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
        $query->where('price', '<=', $request->max_price);
        }
         */

//        dump($products);

        return view('test', [
            'products' => $products,
        ]);
    }

    public function testEmailOrderMarkup()
    {
        return new TestMarkupOrderShippedMail();
    }

    public function testResetPasswordMarkup()
    {
        return new TestMarkupResetPasswordMail();
    }
}

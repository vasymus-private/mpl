<?php

namespace App\Http\Controllers;

use App\Mail\TestMarkupOrderShippedMail;
use App\Mail\TestMarkupResetPasswordMail;
use Domain\Products\Models\Product\Product;
use Domain\Products\QueryBuilders\ProductQueryBuilder;
use Illuminate\Http\Request;
use Meilisearch\Endpoints\Indexes as MeilisearchIndexes;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $products = $this->getMeilisearchProducts('Клей');

        return view('test', [
            'products' => $products,
        ]);
    }

    public function getMeilisearchProducts($search = '')
    {
        return Product::search($search, function(MeilisearchIndexes $meilisearch, string $query = null, array $options = []) {
//             $options['filter'] = 'info_prices_count=3';
            return $meilisearch->search($query, $options);
        })
             ->where('info_prices_count', 3)
            ->orderBy('ordering', 'asc')
            ->query(fn (ProductQueryBuilder $query) => $query->with('infoPrices'))
            ->paginate(10);
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

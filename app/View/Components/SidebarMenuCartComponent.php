<?php

namespace App\View\Components;

use App\H;
use App\Models\Currency;
use App\Models\Product\Product;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SidebarMenuCartComponent extends Component
{
    /**
     * @var Collection|Product[]
     * */
    public $cartProducts;

    /**
     * @var float
     * */
    public $totalSum;

    /**
     * @var string
     * */
    public $totalSumFormatted;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** @var User $user */
        $user = Auth::user();

        $cartProducts = $user->cart->filter(function(Product $product) {
            return ($product->pivot->deleted_at ?? null) === null;
        });

        $this->cartProducts = $cartProducts->take(10);

        $this->totalSum = $cartProducts->reduce(function(float $acc, Product $product) {
            return $acc += ($product->price_retail_rub * ($product->pivot->count ?? 1));
        }, 0.0);

        $this->totalSumFormatted = H::priceRubFormatted($this->totalSum, Currency::ID_RUB);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.sidebar-menu-cart-component');
    }
}

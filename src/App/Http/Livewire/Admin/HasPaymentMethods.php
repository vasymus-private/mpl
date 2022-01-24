<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Orders\Models\PaymentMethod;
use Illuminate\Support\Facades\Cache;

trait HasPaymentMethods
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Orders\Models\PaymentMethod}
     * */
    public array $paymentMethods;

    /**
     * @return void
     */
    protected function initPaymentMethodsOptions()
    {
        $this->paymentMethods = Cache::store('array')->rememberForever('options-payment-methods', function () {
            return PaymentMethod::query()->get()->map(fn (PaymentMethod $paymentMethod) => OptionDTO::fromPaymentMethod($paymentMethod)->toArray())->all();
        });
    }
}

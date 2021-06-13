<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Common\Models\Currency;

trait HasCurrencies
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Common\Models\Currency}
     */
    public array $currencies;

    protected function initCurrenciesOptions()
    {
        $this->currencies = Currency::query()->get()->map(fn(Currency $currency) => OptionDTO::fromCurrency($currency)->toArray())->all();
    }
}

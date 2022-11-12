<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Orders\Models\OrderImportance;
use Illuminate\Support\Facades\Cache;

trait HasOrderImportance
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Orders\Models\OrderImportance}
     */
    public array $orderImportance;

    protected function initOrderImportanceOptions()
    {
        $this->orderImportance = Cache::store('array')->rememberForever('order-importance-options', function () {
            return OrderImportance::query()->get()->map(fn (OrderImportance $orderImportance) => OptionDTO::fromOrderImportance($orderImportance)->toArray())->all();
        });
    }
}

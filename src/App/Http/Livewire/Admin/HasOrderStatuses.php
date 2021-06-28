<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Orders\Models\OrderStatus;
use Illuminate\Support\Facades\Cache;

trait HasOrderStatuses
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Orders\Models\OrderStatus}
     */
    public array $orderStatuses;

    protected function initOrderStatusesOptions()
    {
        $this->orderStatuses = Cache::store('array')->rememberForever('options-order-statuses', function() {
            return OrderStatus::query()->get()->map(fn(OrderStatus $orderStatus) => OptionDTO::fromOrderStatus($orderStatus)->toArray())->all();
        });
    }
}

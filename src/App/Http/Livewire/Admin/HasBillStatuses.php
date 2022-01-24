<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Orders\Models\BillStatus;
use Illuminate\Support\Facades\Cache;

trait HasBillStatuses
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Orders\Models\BillStatus}
     */
    public array $billStatuses;

    protected function initBillStatusesOptions()
    {
        $this->billStatuses = Cache::store('array')->rememberForever('bill-statuses-options', function () {
            return BillStatus::query()->get()->map(fn (BillStatus $billStatus) => OptionDTO::stdFromModel($billStatus)->toArray())->all();
        });
    }
}

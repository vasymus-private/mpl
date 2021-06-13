<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Products\Models\AvailabilityStatus;

trait HasAvailabilityStatuses
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\AvailabilityStatus}
     */
    public array $availabilityStatuses;

    protected function initAvailabilityStatusesOptions()
    {
        $this->availabilityStatuses = AvailabilityStatus::query()->get()->map(fn(AvailabilityStatus $availabilityStatus) => OptionDTO::fromAvailabilityStatus($availabilityStatus)->toArray())->all();
    }
}

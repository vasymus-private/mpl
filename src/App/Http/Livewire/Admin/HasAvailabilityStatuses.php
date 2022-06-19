<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Products\Models\AvailabilityStatus;
use Illuminate\Support\Facades\Cache;

trait HasAvailabilityStatuses
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Products\Models\AvailabilityStatus}
     */
    public array $availabilityStatuses;

    protected function initAvailabilityStatusesOptions()
    {
        $this->availabilityStatuses = Cache::store('array')->rememberForever('options-availability-statuses', function () {
            $result = [];
            $entitiesKeyedById = AvailabilityStatus::query()->get()->keyBy('id');
            $result[] = $entitiesKeyedById->get(AvailabilityStatus::ID_AVAILABLE_IN_STOCK);
            $result[] = $entitiesKeyedById->get(AvailabilityStatus::ID_NOT_AVAILABLE);
            $result[] = $entitiesKeyedById->get(AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK);

            return collect($result)
                ->map(fn (AvailabilityStatus $availabilityStatus) => OptionDTO::fromAvailabilityStatus($availabilityStatus)->toArray())
                ->all();
        });
    }
}

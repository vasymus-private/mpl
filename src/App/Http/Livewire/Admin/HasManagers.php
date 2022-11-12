<?php

namespace App\Http\Livewire\Admin;

use Domain\Common\DTOs\OptionDTO;
use Domain\Users\Models\Admin;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Support\Facades\Cache;

trait HasManagers
{
    /**
     * @var array[] @see {@link \Domain\Common\DTOs\OptionDTO} {@link \Domain\Users\Models\Admin}
     */
    public array $managers;

    protected function initManagersOptions()
    {
        $this->managers = Cache::store('array')->rememberForever('options-managers', function () {
            return Admin::query()->get()->map(fn (BaseUser $admin) => OptionDTO::fromAdmin($admin)->toArray())->all(); // @phpstan-ignore-line
        });
    }
}

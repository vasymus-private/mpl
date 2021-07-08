<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Support\H;

class BaseShowComponent extends Component
{
    /**
     * @param mixed $name
     * @param mixed $value
     *
     * @see {@link https://github.com/livewire/livewire/issues/823#issuecomment-751321838}
     */
    public function updated($name, $value)
    {
        data_set($this, $name, H::trimAndNullEmptyString($value)); // trim only left side
    }

    public function clearValidationErrors()
    {
        $this->clearValidation();
    }
}

<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class BaseShowComponent extends Component
{
    public function clearValidationErrors()
    {
        $this->clearValidation();
    }
}

<?php

namespace App\Http\Livewire\Admin;

trait HasSelectAll
{
    public $selectAll = false;

    public function updatedSelectAll(bool $isChecked)
    {
        $this->items = collect($this->items)->map(function(array $item) use($isChecked) {
            $item['is_checked'] = $isChecked;
            return $item;
        })->all();
    }
}

<?php

namespace App\Http\Livewire\Admin;

trait HasSelectAll
{
    public $selectAll = false;

    public function updatedSelectAll(bool $isChecked)
    {
        if (isset($this->items)) {
            $this->changeItemsSelectAll($isChecked);
        }

        if (isset($this->variations)) {
            $this->changeVariationsSelectAll($isChecked);
        }
    }

    protected function changeItemsSelectAll(bool $isChecked)
    {
        $this->items = collect($this->items)->map(function (array $item) use ($isChecked) {
            $item['is_checked'] = $isChecked;

            return $item;
        })->all();
    }

    protected function changeVariationsSelectAll(bool $isChecked)
    {
        $this->variations = collect($this->variations)->map(function (array $item) use ($isChecked) {
            $item['is_checked'] = $isChecked;

            return $item;
        })->all();
    }
}

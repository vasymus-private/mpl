<?php

namespace App\Http\Livewire\Admin;

trait HasSelectAll
{
    public $selectAll = false;

    public function updatedSelectAll(bool $isChecked)
    {
        $this->changeItemsSelectAll($isChecked);

        $this->changeVariationsSelectAll($isChecked);
    }

    protected function changeItemsSelectAll(bool $isChecked)
    {
        if (isset($this->items)) {
            $this->items = collect($this->items)->map(function (array $item) use ($isChecked) {
                $item['is_checked'] = $isChecked;

                return $item;
            })->all();
        }
    }

    protected function changeVariationsSelectAll(bool $isChecked)
    {
        if (isset($this->variations)) {
            $this->variations = collect($this->variations)->map(function (array $item) use ($isChecked) {
                $item['is_checked'] = $isChecked;

                return $item;
            })->all();
        }
    }
}

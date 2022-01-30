<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Str;

trait HasGenerateSlug
{
    /**
     * @var bool
     */
    public bool $generateSlugSyncMode = false;

    protected function initGenerateSlug()
    {
        if (! $this->item->id) {
            $this->generateSlugSyncMode = true;
        }
    }

    public function toggleGenerateSlugMode()
    {
        $this->generateSlugSyncMode = ! $this->generateSlugSyncMode;
        $this->handleGenerateSlug();
    }

    public function handleGenerateSlug()
    {
        if ($this->generateSlugSyncMode) {
            $this->generateSlug();
        }
    }

    protected function generateSlug()
    {
        $this->item->slug = Str::slug($this->item->name);
    }
}

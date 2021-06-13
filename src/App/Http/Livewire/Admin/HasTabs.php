<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\Cache;

trait HasTabs
{
    /**
     * @var string
     */
    public string $activeTab;

    /**
     * @param string $tab
     *
     * @return void
     */
    public function selectTab(string $tab)
    {
        if (in_array($tab, array_keys($this->getTabs()))) {
            $id = property_exists($this, 'item') ? ($this->item->id ?? null) : null;
            Cache::put(static::getActiveTabCacheKey($id), $tab, new \DateInterval('PT15M'));
        }
        $this->skipRender();
    }

    /**
     * @param string|int|null $id
     *
     * @return string
     */
    protected static function getActiveTabCacheKey($id = null): string
    {
        return sprintf('%s-%s-%s-show-active-tab', auth()->id(), static::class, $id);
    }

    /**
     * @return string
     */
    protected function getDefaultTab(): string
    {
        return defined('static::DEFAULT_TAB') ? static::DEFAULT_TAB : 'elements';
    }

    /**
     * @return string[]
     */
    protected function getTabs(): array
    {
        return property_exists($this, 'tabs') ? $this->tabs : [];
    }

    /**
     * @return void
     */
    protected function initTabs()
    {
        $this->activeTab = Cache::get(static::getActiveTabCacheKey(), $this->getDefaultTab());
    }
}

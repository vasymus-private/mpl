<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\Cache;

trait HasTabs
{
    /**
     * @var string
     */
    public $activeTab = '';

    /**
     * @param string|null $tab
     *
     * @return void
     */
    public function selectTab($tab = null)
    {
        $this->skipRender();
        if ($this->isValidTab($tab)) {
            $id = property_exists($this, 'item') ? ($this->item->id ?? null) : null;
            Cache::put(static::getActiveTabCacheKey($id), $tab, new \DateInterval('PT15M'));
            $this->activeTab = $tab;
        }
    }

    /**
     * @return array
     */
    protected function getHasTabsQueryString(): array
    {
        return [
            'activeTab' => ['except' => ''],
        ];
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
        if (property_exists($this, 'tabs')) {
            return $this->tabs;
        }
        if (method_exists($this, 'tabs')) {
            return $this->tabs();
        }

        return [];
    }

    /**
     * @return void
     */
    protected function initHasTabs()
    {
        $activeTab = $this->isValidTab($this->activeTab) ? $this->activeTab : null;
        $cacheKey = static::getActiveTabCacheKey($this->item->id ?? null);
        $defaultTab = $this->getDefaultTab();
        $this->activeTab = $activeTab ?: Cache::get($cacheKey, $defaultTab);
    }

    /**
     * @param string|null $tab
     *
     * @return bool
     */
    protected function isValidTab($tab = null): bool
    {
        return in_array($tab, array_keys($this->getTabs()));
    }
}

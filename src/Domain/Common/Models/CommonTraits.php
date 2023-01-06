<?php

namespace Domain\Common\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

trait CommonTraits
{
    /**
     * @var float|int
     */
    protected static $cacheTime = 24 * 60 * 60; // seconds

    /**
     * @return string
     */
    public function getFullTableName(): string
    {
        return $this->getConnection()->getTablePrefix() . $this->getTable();
    }

    /**
     * @return string
     */
    public function getConnectionName(): string
    {
        if (! is_null($this->connection)) {
            return $this->connection;
        }

        return config("database.default");
    }

    /**
     * Get all the models from the database.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function cachedAll()
    {
        return Cache::remember(static::getCacheAllKey(), static::getCacheAllTime(), function () {
            return static::all();
        });
    }

    /**
     * @return \Illuminate\Support\Carbon
     */
    public static function getCacheAllTime(): Carbon
    {
        return now()->addSeconds(static::$cacheTime);
    }

    /**
     * @return string
     */
    public static function getCacheAllKey(): string
    {
        return static::class . ".all";
    }

    /**
     * @param string $key
     * @param int|null $value
     *
     * @return void
     */
    public function setNullableForeignInt(string $key, int $value = null): void
    {
        if (! isset($value)) {
            return;
        }

        $this->$key = $value !== 0 ? $value : null;
    }
}

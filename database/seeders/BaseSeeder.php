<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BaseSeeder extends Seeder
{
    /**
     * @var string
     */
    protected string $stdSecret;

    /**
     * @var bool
     */
    protected bool $clearData = false;

    public function __construct()
    {
        $this->clearData = config('services.seeders.clearData');
        $this->stdSecret = Hash::make('secret');
    }

    /**
     * @return bool
     */
    protected function shouldClearData(): bool
    {
        return $this->clearData;
    }

    /**
     * @return bool
     */
    protected function isCalledOnce(): bool
    {
        return DB::table('seeders')
            ->where('name', static::class)
            ->exists();
    }

    /**
     * @return void
     */
    protected function setCalledOnce(): void
    {
        DB::table('seeders')->insert([
            'name' => static::class,
        ]);
    }
}

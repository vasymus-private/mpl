<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
}

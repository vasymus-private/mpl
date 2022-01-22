<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseTestingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class BaseActionTestCase extends TestCase
{
    /**
     * @var string
     */
    protected string $seeder = DatabaseTestingSeeder::class;

    use RefreshDatabase {
        refreshDatabase as _refreshDatabase;
    }

    /**
     * @var bool
     */
    protected static bool $hasRun = false;

    public function refreshDatabase()
    {
        if (self::$hasRun) {
            return;
        }
        $this->_refreshDatabase();
        self::$hasRun = true;
    }
}

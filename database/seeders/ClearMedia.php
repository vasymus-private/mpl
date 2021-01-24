<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;

class ClearMedia extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Media::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Storage::deleteDirectory("public/media");
        Storage::makeDirectory("public/media");
    }
}

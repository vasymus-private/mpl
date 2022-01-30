<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ClearMedia extends BaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! $this->shouldClearData()) {
            return;
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Media::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Storage::deleteDirectory("public/media");
        Storage::makeDirectory("public/media");
        Storage::delete('media');
        Storage::makeDirectory('media');
    }
}

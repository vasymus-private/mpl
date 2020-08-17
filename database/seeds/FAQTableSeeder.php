<?php

use App\Models\FAQ;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FAQTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FAQ::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function runOld()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FAQ::query()->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $rawSeeds = json_decode(Storage::get("seeds/faq/old/seeds.json"), true);
        $seeds = [];

        foreach ($rawSeeds as $rawSeed) {
            $asIsAttributes = ["id", "question", "answer", "is_active", "user_email", "user_name"];
            $seed = [];
            foreach ($asIsAttributes as $attribute) {
                $seed[$attribute] = $rawSeed[$attribute];
            }
            $seed["created_at"] = $rawSeed["created_at"]
                ? Carbon::createFromFormat("d.m.Y H:i:s", $rawSeed["created_at"])
                : null
            ;
            $seeds[] = $seed;
        }

        FAQ::query()->insert($seeds);
    }
}

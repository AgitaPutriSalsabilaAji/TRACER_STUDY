<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramStudiSeeder extends Seeder
{
    public function run()
    {
        DB::table('program_studi')->insert([
            ['program_studi' => 'D4 Teknik Informatika'],
            ['program_studi' => 'D4 Sistem Informasi Bisnis'],
            ['program_studi' => 'D2 PPLS'],
            ['program_studi' => 'S2 MRTI'],
        ]);
    }
}

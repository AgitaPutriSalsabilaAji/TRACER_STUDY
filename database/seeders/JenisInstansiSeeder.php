<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisInstansiSeeder extends Seeder
{
    public function run()
    {
        DB::table('jenis_instansi')->insert([
            ['jenis_instansi' => 'Pendidikan Tinggi'],
            ['jenis_instansi' => 'Instansi Pemerintah'],
            ['jenis_instansi' => 'Perusahaan Swasta'],
            ['jenis_instansi' => 'BUMN'],
        ]);
    }
}

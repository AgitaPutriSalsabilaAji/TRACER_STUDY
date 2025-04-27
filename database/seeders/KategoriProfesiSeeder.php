<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriProfesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert data kategori profesi
        DB::table('kategori_profesi')->insert([
            ['kategori_profesi' => 'Infokom'],
            ['kategori_profesi' => 'Non-Infokom'],
            ['kategori_profesi' => 'Belum Bekerja'],
        ]);
    }
}

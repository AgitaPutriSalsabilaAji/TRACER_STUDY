<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesiSeeder extends Seeder
{
    public function run()
    {
        DB::table('profesi')->insert([
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'Software Developer/Programmer/Developer'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'IT Support/IT Administrator'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'Infrastructure Engineer'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'Digital Marketing Specialist'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'Graphic Designer/Multimedia Designer'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'Business Analyst'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'QA Engineer/Tester'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'IT Enterpreneur'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'Trainer/Guru/Dosen (IT)'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'Mahasiswa IT'],
            ['kategori_profesi' => 'Infokom', 'nama_profesi' => 'Lainnya'],
            ['kategori_profesi' => 'Non-Infokom', 'nama_profesi' => 'Procurement & Operational Team'],
            ['kategori_profesi' => 'Non-Infokom', 'nama_profesi' => 'Wirausahawan (Non IT)'],
            ['kategori_profesi' => 'Non-Infokom', 'nama_profesi' => 'Trainer/Guru/Dosen (Non IT)'],
            ['kategori_profesi' => 'Non-Infokom', 'nama_profesi' => 'Mahasiswa'],
            ['kategori_profesi' => 'Non-Infokom', 'nama_profesi' => 'Lainnya'],
            ['kategori_profesi' => 'Belum Bekerja'],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil kategori profesi
        $infokom = DB::table('kategori_profesi')->where('kategori_profesi', 'Infokom')->first()->id;
        $nonInfokom = DB::table('kategori_profesi')->where('kategori_profesi', 'Non-Infokom')->first()->id;
        $belumBekerja = DB::table('kategori_profesi')->where('kategori_profesi', 'Belum Bekerja')->first()->id;

        // Insert data profesi
        DB::table('profesi')->insert([
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'Software Developer/Programmer/Developer'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'IT Support/IT Administrator'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'Infrastructure Engineer'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'Digital Marketing Specialist'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'Graphic Designer/Multimedia Designer'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'Business Analyst'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'QA Engineer/Tester'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'IT Enterpreneur'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'Trainer/Guru/Dosen (IT)'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'Mahasiswa IT'],
            ['kategori_profesi_id' => $infokom, 'nama_profesi' => 'Lainnya'],
            ['kategori_profesi_id' => $nonInfokom, 'nama_profesi' => 'Procurement & Operational Team'],
            ['kategori_profesi_id' => $nonInfokom, 'nama_profesi' => 'Wirausahawan (Non IT)'],
            ['kategori_profesi_id' => $nonInfokom, 'nama_profesi' => 'Trainer/Guru/Dosen (Non IT)'],
            ['kategori_profesi_id' => $nonInfokom, 'nama_profesi' => 'Mahasiswa'],
            ['kategori_profesi_id' => $nonInfokom, 'nama_profesi' => 'Lainnya'],
            ['kategori_profesi_id' => $belumBekerja, 'nama_profesi' => 'Belum Bekerja'],
        ]);
    }
}

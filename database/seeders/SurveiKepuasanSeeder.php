<?php

namespace Database\Seeders;

use App\Models\SurveiKepuasan;
use App\Models\Lulusan;
use Illuminate\Database\Seeder;

class SurveiKepuasanSeeder extends Seeder
{
    public function run()
    {
        $lulusan = Lulusan::all();

        $lulusan = $lulusan->take(30);

        $faker = \Faker\Factory::create('id_ID'); 
        foreach ($lulusan as $lulusanData) {
            $instansi = $lulusanData->nama_instansi;
            $alumni = $lulusanData->alumni;  

            SurveiKepuasan::create([
                'alumni_id' => $alumni->id,
                'nama_surveyor' => $faker->name(), 
                'instansi' => $instansi,
                'jabatan' => $faker->jobTitle(), 
                'email' => $faker->email(), 
                'kerjasama_tim' => $faker->randomElement([1, 2, 3, 4]),
                'keahlian_di_bidang_ti' => $faker->randomElement([1, 2, 3, 4]),
                'kemampuan_bahasa_asing' => $faker->randomElement([1, 2, 3, 4]),
                'kemampuan_komunikasi' => $faker->randomElement([1, 2, 3, 4]),
                'pengembangan_diri' => $faker->randomElement([1, 2, 3, 4]),
                'kepemimpinan' => $faker->randomElement([1, 2, 3, 4]),
                'etos_kerja' => $faker->randomElement([1, 2, 3, 4]),
                'kompetensi_belum_terpenuhi' => $faker->randomElement([
                    'Penguasaan teknis belum memadai.',
                    'Kurangnya pemahaman tentang soft skills.',
                    'Perlu pengembangan dalam kemampuan analisis data.',
                    'Perlu peningkatan keterampilan komunikasi interpersonal.',
                    'Kurangnya keterampilan dalam bekerja tim.'
                ]),
                'saran_kurikulum' => $faker->randomElement([
                    'Kurikulum perlu lebih banyak fokus pada praktek langsung.',
                    'Perlu ditambahkan modul tentang pengembangan diri.',
                    'Kurikulum perlu lebih fokus pada teknologi terbaru.',
                    'Harus ada pembelajaran tentang komunikasi bisnis.',
                    'Kurikulum perlu lebih mengarah pada pengembangan soft skills.'
                ]),
            ]);
        }
    }
}

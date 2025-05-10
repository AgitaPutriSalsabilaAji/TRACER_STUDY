<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lulusan;
use App\Models\Alumni;

class LulusanSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        $alumniIds = Alumni::take(40)->pluck('id')->toArray();

        foreach ($alumniIds as $alumniId) {
            Lulusan::create([
                'alumni_id' => $alumniId, 
                'profesi_id' => rand(1, 17),
                'jenis_instansi_id' => rand(1, 4),
                'tahun_lulus' => $faker->year,
                'no_hp' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'tgl_pertama_kerja' => $faker->dateTimeBetween('2027-01-01', '2030-12-31')->format('Y-m-d'),
                'tgl_mulai_kerja_instansi' => $faker->dateTimeBetween('2027-01-01', '2030-12-31')->format('Y-m-d'),
                'nama_instansi' => $faker->company,
                'skala' => $faker->randomElement(['Nasional', 'Internasional', 'Regional']),
                'lokasi_instansi' => $faker->city,
                'nama_atasan_langsung' => $faker->name,
                'jabatan_atasan_langsung' => $faker->jobTitle,
                'no_hp_atasan_langsung' => $faker->phoneNumber,
                'email_atasan_langsung' => $faker->unique()->companyEmail,
            ]);
        }
    }
}

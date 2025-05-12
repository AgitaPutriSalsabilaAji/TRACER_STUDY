<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Lulusan;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class LulusanSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        $alumniData = Alumni::take(40)->select('id', 'tanggal_lulus')->get();

        foreach ($alumniData as $alumni) {
            $tahunLulus = Carbon::parse($alumni->tanggal_lulus)->year;
            Lulusan::create([
                'alumni_id' => $alumni->id,
                'profesi_id' => rand(1, 17),
                'jenis_instansi_id' => rand(1, 4),
                'tahun_lulus' => $tahunLulus,
                'no_hp' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'tgl_pertama_kerja' => $faker->dateTimeBetween('2020-01-01', '2025-12-31')->format('Y-m-d'),
                'tgl_mulai_kerja_instansi' => $faker->dateTimeBetween('2020-01-01', '2025-12-31')->format('Y-m-d'),
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

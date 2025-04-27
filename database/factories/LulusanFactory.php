<?php

namespace Database\Factories;

use App\Models\Lulusan;
use App\Models\Alumni;
use App\Models\Profesi;
use App\Models\JenisInstansi;
use Illuminate\Database\Eloquent\Factories\Factory;

class LulusanFactory extends Factory
{
    protected $model = Lulusan::class;

    public function definition(): array
    {
        $this->faker->locale = 'id_ID';
        $alumni = Alumni::inRandomOrder()->first(); 
        $profesi = Profesi::inRandomOrder()->first();
        $jenisInstansi = JenisInstansi::inRandomOrder()->first();
        return [
            'alumni_id' => $alumni->id,
            'profesi_id' => $profesi->id,
            'jenis_instansi_id' => $jenisInstansi->id,
            'tahun_lulus' => $this->faker->year(),
            'no_hp' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'tgl_pertama_kerja' => $this->faker->date(),
            'tgl_mulai_kerja_instansi' => $this->faker->date(),
            'nama_instansi' => $this->faker->company(),
            'skala' => $this->faker->randomElement(['Lokal', 'Nasional', 'Internasional']),
            'lokasi_instansi' => $this->faker->city(),
            'nama_atasan_langsung' => $this->faker->name(),
            'jabatan_atasan_langsung' => $this->faker->jobTitle(),
            'no_hp_atasan_langsung' => $this->faker->phoneNumber(),
            'email_atasan_langsung' => $this->faker->email(),
        ];
    }
}

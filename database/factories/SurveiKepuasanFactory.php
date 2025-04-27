<?php

namespace Database\Factories;

use App\Models\SurveiKepuasan;
use App\Models\Alumni;
use Illuminate\Database\Eloquent\Factories\Factory;

class SurveiKepuasanFactory extends Factory
{
    protected $model = SurveiKepuasan::class;

    public function definition(): array
    {
        $this->faker->locale = 'id_ID';

        $alumni = Alumni::inRandomOrder()->first(); 
        return [
            'alumni_id' => $alumni->id,
            'nama_surveyor' => $this->faker->name(),
            'instansi' => $this->faker->company(),
            'jabatan' => $this->faker->jobTitle(),
            'email' => $this->faker->email(),
            'ketjasama_tim' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'keahlian_u' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'kemampuan_bahasa_asing' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'kemampuan_komunikasi' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'pengembangan_diri' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'kepemimpinan' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'etos_kerja' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'kompetensi_belum_terpenuhi' => $this->faker->sentence(),
            'saran_kurikulum' => $this->faker->sentence(),
        ];
    }
}

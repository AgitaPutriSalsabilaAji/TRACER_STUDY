<?php

namespace Database\Factories;

use App\Models\Alumni;
use App\Models\ProgramStudi;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumniFactory extends Factory
{
    protected $model = Alumni::class;

    public function definition(): array
    {
        $this->faker->locale = 'id_ID';
        $programStudi = ProgramStudi::inRandomOrder()->first();
        return [
            'program_studi_id' => $programStudi->id,
            'nama' => $this->faker->name(),
            'nim' => $this->faker->unique()->numerify('NIM-######'),
            'tanggal_lulus' => $this->faker->dateTimeBetween('2026-01-01', '2030-12-31')->format('Y-m-d'), 
        ];
    }
}

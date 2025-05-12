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
            'nama' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'nim' => $this->faker->unique()->numerify('NIM-23########'),
            'tanggal_lulus' => $this->faker->dateTimeBetween('2019-01-01', '2024-12-31')->format('Y-m-d'), 
        ];
    }
}

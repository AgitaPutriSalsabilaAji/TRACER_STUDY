<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Alumni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');


        User::create([
            'name' => 'Purnama',
            'username' => 'Purnama',
            'email' => 'purnamaA@gmail.com',
            'password' => Hash::make('purnama'),
        ]);
        $this->call([
            ProgramStudiSeeder::class
        ]);
        Alumni::factory(50)->create();



        $this->call([
            KategoriProfesiSeeder::class,
            ProfesiSeeder::class,
            JenisInstansiSeeder::class,
            LulusanSeeder::class,
            SurveiKepuasanSeeder::class,
        ]);
    }
}

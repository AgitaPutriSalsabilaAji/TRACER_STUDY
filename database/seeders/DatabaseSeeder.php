<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
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
        if (!Admin::where('username', 'PurnamaSuper')->exists()) {
            Admin::create([
                'name' => 'PurnamaSuper',
                'username' => 'PurnamaSuper',
                'email' => 'himadatsuki@gmail.com',
                'is_superadmin' => true,
                'password' => Hash::make('purnama'),
            ]);
        }
        if (!Admin::where('username', 'Purnama')->exists()) {
            Admin::create([
                'name' => 'Purnama',
                'username' => 'Purnama',
                'email' => 'minamiharuka18@gmail.com',
                'password' => Hash::make('purnama'),
            ]);
        }

        // Menambahkan Admin lainnya
        if (!Admin::where('username', 'Desi')->exists()) {
            Admin::create([
                'name' => 'Desi',
                'username' => 'Desi',
                'email' => 'desikarmila211@gmail.com',
                'password' => Hash::make('desi123'),
            ]);
        }


        $this->call([
            ProgramStudiSeeder::class
        ]);

        Alumni::factory(50)->create();
        Alumni::create([
            'program_studi_id' => 2,
            'nama' => 'Purnama Ridzky Nugraha',
            'nim' => '2341760037',
            'tanggal_lulus' => '2025-08-15',
        ]);
        Alumni::create([
            'program_studi_id' => 2,
            'nama' => 'Siska Nuri Aprilia',
            'nim' => '2341760038',
            'tanggal_lulus' => '2025-08-15',
        ]);

        $this->call([
            KategoriProfesiSeeder::class,
            ProfesiSeeder::class,
            JenisInstansiSeeder::class,
            LulusanSeeder::class,
            SurveiKepuasanSeeder::class,
        ]);
    }
}

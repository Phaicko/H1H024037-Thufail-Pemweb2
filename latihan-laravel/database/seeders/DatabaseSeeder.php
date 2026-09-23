<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ProgramStudiSeeder::class);
        $this->call(MatakuliahSeeder::class);
        $mahasiswa = Mahasiswa::factory()->count(30)->create();
        $matakuliah = Matakuliah::all();

        foreach ($mahasiswa as $item) {
            $item->matakuliah()->attach($matakuliah->random(min(3, $matakuliah->count()))->mapWithKeys(
                fn(Matakuliah $mataKuliah) => [$mataKuliah->id => ['nilai' => fake()->randomElement(['A', 'AB', 'B', 'BC'])]]
            ));
        }
    }
}

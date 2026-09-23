<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matakuliah;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftar = [
            ['kode' => 'PWEB1', 'nama' => 'Pemrograman Web 1', 'sks' => 3, 'semester' => 1],
            ['kode' => 'BD1', 'nama' => 'Basis Data 1', 'sks' => 3, 'semester' => 2],
            ['kode' => 'PWEB2', 'nama' => 'Pemrograman Web 2', 'sks' => 3, 'semester' => 3],
        ];

        foreach ($daftar as $item) {
            Matakuliah::create($item);
        }
    }
}

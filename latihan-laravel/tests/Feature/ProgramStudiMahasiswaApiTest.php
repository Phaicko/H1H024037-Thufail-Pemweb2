<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramStudiMahasiswaApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_program_studi_mahasiswa_endpoint_is_paginated_and_scoped(): void
    {
        $programStudi = ProgramStudi::create([
            'kode' => 'IF',
            'nama' => 'Informatika',
            'jenjang' => 'S1',
        ]);
        $programStudiLain = ProgramStudi::create([
            'kode' => 'TK',
            'nama' => 'Teknik Komputer',
            'jenjang' => 'S1',
        ]);

        Mahasiswa::factory()->count(3)->create([
            'program_studi_id' => $programStudi->id,
        ]);
        Mahasiswa::factory()->create([
            'program_studi_id' => $programStudiLain->id,
        ]);

        $this->getJson('/api/program-studi/' . $programStudi->id . '/mahasiswa?per_halaman=2')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('meta.total', 3)
            ->assertJsonPath('meta.per_page', 2)
            ->assertJsonPath('data.0.program_studi.id', $programStudi->id);

        $this->getJson('/api/program-studi/' . $programStudi->id . '/mahasiswa?per_halaman=2&page=2')
            ->assertOk()
            ->assertJsonCount(1, 'data');

        $this->getJson('/api/program-studi/99999/mahasiswa')
            ->assertNotFound();
    }
}
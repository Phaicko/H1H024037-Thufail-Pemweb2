<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use Database\Seeders\ProgramStudiSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaFieldsApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_only_the_requested_fields(): void
    {
        $this->seed(ProgramStudiSeeder::class);
        Mahasiswa::factory()->create();

        $response = $this->getJson('/api/mahasiswa?fields=nim,nama')
            ->assertOk();

        $this->assertSame(['nim', 'nama'], array_keys($response->json('data.0')));
    }

    public function test_index_can_include_the_program_studi_resource(): void
    {
        $this->seed(ProgramStudiSeeder::class);
        Mahasiswa::factory()->create();

        $this->getJson('/api/mahasiswa?fields=nim,program_studi')
            ->assertOk()
            ->assertJsonPath('data.0.program_studi.nama', 'Teknik Komputer');
    }

    public function test_index_rejects_unknown_fields(): void
    {
        $this->getJson('/api/mahasiswa?fields=nim,alamat')
            ->assertUnprocessable()
            ->assertJsonStructure(['galat' => ['fields']]);
    }
}
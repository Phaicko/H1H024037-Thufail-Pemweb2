<?php

namespace Tests\Feature;

use Database\Seeders\MatakuliahSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatakuliahSharedDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_matakuliah_are_available_through_the_api(): void
    {
        $this->seed(MatakuliahSeeder::class);
        $this->seed(MatakuliahSeeder::class);

        $this->getJson('/api/matakuliah?per_halaman=100')
            ->assertOk()
            ->assertJsonCount(6, 'data')
            ->assertJsonFragment(['kode' => 'PWEB1'])
            ->assertJsonFragment(['kode' => 'KECERDASAN']);
    }

    public function test_matakuliah_can_be_updated_using_its_kode(): void
    {
        $this->seed(MatakuliahSeeder::class);

        $this->putJson('/api/matakuliah/PWEB1', [
            'kode' => 'PWEB101',
            'nama' => 'Pemrograman Web Dasar',
            'sks' => 4,
            'semester' => 2,
        ])->assertOk()
            ->assertJsonPath('data.kode', 'PWEB101')
            ->assertJsonPath('data.nama', 'Pemrograman Web Dasar');

        $this->getJson('/api/matakuliah/PWEB101')
            ->assertOk()
            ->assertJsonPath('data.sks', 4);

        $this->assertDatabaseMissing('matakuliahs', ['kode' => 'PWEB1']);
    }

    public function test_api_matakuliah_data_is_shown_on_web_pages(): void
    {
        $response = $this->postJson('/api/matakuliah', [
            'kode' => 'API101',
            'nama' => 'Data dari API',
            'sks' => 3,
            'semester' => 1,
        ])->assertCreated();
        $this->get('/matakuliah')
            ->assertOk()
            ->assertSee('API101')
            ->assertSee('Data dari API')
            ->assertSee('bg-danger text-white')
            ->assertSee('3');

        $this->get('/matakuliah/API101')
            ->assertOk()
            ->assertSee('API101')
            ->assertSee('Data dari API')
            ->assertSee('Semester:');

        $this->patchJson('/api/matakuliah/API101', [
            'kode' => 'API102',
            'nama' => 'Nama diperbarui via API',
            'sks' => 4,
        ])->assertOk();

        $this->get('/matakuliah')
            ->assertOk()
            ->assertSee('API102')
            ->assertSee('Nama diperbarui via API')
            ->assertDontSee('API101');

        $this->deleteJson('/api/matakuliah/API102')
            ->assertOk();

        $this->get('/matakuliah')
            ->assertOk()
            ->assertDontSee('API102')
            ->assertDontSee('Nama diperbarui via API');
    }
}
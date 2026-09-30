<?php

use App\Http\Controllers\Api\MahasiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/status', function () {
    return response()->json([
        'sukses' => true,
        'pesan' => 'API Pemweb II aktif',
        'waktu' => now()->toIso8601String(),
    ]);
});
Route::get(
    'program-studi/{id}/mahasiswa',
    [MahasiswaController::class, 'byProgramStudi']
)->whereNumber('id');
Route::apiResource('mahasiswa', MahasiswaController::class);

require __DIR__ . '/api/matakuliah.php';

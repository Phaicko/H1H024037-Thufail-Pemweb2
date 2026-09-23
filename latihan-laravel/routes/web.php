<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\MahasiswaWebController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    return 'test';
});
Route::get('/mahasiswa-top-ipk', [MahasiswaWebController::class, 'topIpkTeknikKomputer'])
    ->name('mahasiswa.top-ipk');
Route::get('/mahasiswa/{nim}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/semester/{angka}', function (int $angka) {
    return 'Semester ke ' . $angka;
})->whereNumber('angka');
Route::get('/cari-mahasiswa', [MahasiswaController::class, 'cari']);
Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
Route::get('/matakuliah/{kode}', [MatakuliahController::class, 'show'])->name('matakuliah.show');
Route::get('/mahasiswa-data', [MahasiswaWebController::class, 'index'])->name('mahasiswa.data');

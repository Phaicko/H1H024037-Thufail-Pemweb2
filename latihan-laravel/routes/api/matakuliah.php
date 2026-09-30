<?php

use App\Http\Controllers\Api\MatakuliahController;
use Illuminate\Support\Facades\Route;

Route::apiResource('matakuliah', MatakuliahController::class)
	->scoped(['matakuliah' => 'kode']);
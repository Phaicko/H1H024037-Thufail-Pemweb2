<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {
        $daftarMahasiswa = Mahasiswa::query()->orderBy('nama')->get();
        return view('mahasiswa.index', ['daftarMahasiswa' => $daftarMahasiswa]);
    }
    public function show(string $nim)
    {
        $mahasiswa = Mahasiswa::with(['programStudi', 'matakuliah'])
            ->where('nim', $nim)
            ->firstOrFail();

        return view('mahasiswa.show', compact('mahasiswa'));
    }
    public function cari(Request $request)
    {
        $kataKunci = $request->query('q', '');
        return response()->json([
            'kata_kunci' => $kataKunci,
            'metode' => $request->method(),
            'path' => $request->path(),
        ]);
    }
}

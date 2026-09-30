<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $pencarian = $request->query('nama', '');
        $daftarMatakuliah = Matakuliah::query()
            ->when($pencarian !== '', function ($query) use ($pencarian) {
                $query->where('nama', 'like', '%' . $pencarian . '%');
            })
            ->orderBy('nama')
            ->get();

        return view('matakuliah.daftar', compact('daftarMatakuliah', 'pencarian'));
    }
    public function show(string $kode)
    {
        $matakuliah = Matakuliah::where('kode', $kode)->firstOrFail();

        return view('matakuliah.detail', compact('matakuliah'));
    }
}

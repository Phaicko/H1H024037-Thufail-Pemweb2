<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $daftarMatakuliah = [
            ['kode' => 'MK001', 'nama' => 'Pemrograman Web', 'sks' => 3],
            ['kode' => 'MK002', 'nama' => 'Basis Data', 'sks' => 4],
            ['kode' => 'MK003', 'nama' => 'Jaringan Komputer', 'sks' => 3],
            ['kode' => 'MK004', 'nama' => 'Sistem Operasi', 'sks' => 2],
            ['kode' => 'MK005', 'nama' => 'Kecerdasan Buatan', 'sks' => 3],
        ];

        $pencarian = $request->query('nama', '');
        $daftarMatakuliah = array_filter($daftarMatakuliah, function (array $matakuliah) use ($pencarian) {
            return $pencarian === '' || stripos($matakuliah['nama'], $pencarian) !== false;
        });

        return view('matakuliah.daftar', compact('daftarMatakuliah', 'pencarian'));
    }
    public function show(string $kode)
    {
        return view('matakuliah.detail', ['kode' => $kode]);
    }
}

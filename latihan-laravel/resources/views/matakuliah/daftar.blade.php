@extends('layouts.app')
@section('judul', 'Daftar Mata Kuliah')
@section('konten')
<h1 class="h3 mb-4">Daftar Mata Kuliah</h1>
<form method="GET" action="{{ route('matakuliah.index') }}" class="mb-3">
    <div class="input-group">
        <input type="search" name="nama" value="{{ $pencarian }}" class="form-control" placeholder="Cari nama mata kuliah">
        <button type="submit" class="btn btn-primary">Cari</button>
    </div>
</form>
<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>SKS</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($daftarMatakuliah as $matakuliah)
        <tr>
            <td>{{ $matakuliah['kode'] }}</td>
            <td>{{ $matakuliah['nama'] }}</td>
            <x-sks :sks="$matakuliah['sks']" />
            <td>
            <a href="{{ route('matakuliah.show', $matakuliah['kode']) }}" class="btn btn-sm btn-primary">
                Detail
            </a></td>
        </tr>
        @empty
        <tr>
            <td colspan="3">Data belum tersedia</td>
        </tr>
        @endforelse
</tbody>
@endsection
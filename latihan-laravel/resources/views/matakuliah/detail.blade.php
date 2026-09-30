@extends('layouts.app')
@section('judul', 'Detail Mata Kuliah')
@section('konten')
<h1 class="h3 mb-4">Detail Mata Kuliah</h1>
<div class="card">
    <div class="card-body">
        <p>Kode: <strong>{{ $matakuliah->kode }}</strong></p>
        <p>Nama: <strong>{{ $matakuliah->nama }}</strong></p>
        <p>SKS: <strong>{{ $matakuliah->sks }}</strong></p>
        <p class="mb-0">Semester: <strong>{{ $matakuliah->semester }}</strong></p>
    </div>
</div>
<a href="{{ route('matakuliah.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection
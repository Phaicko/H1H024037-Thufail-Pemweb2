@extends('layouts.app')
@section('judul', 'Detail Mahasiswa')
@section('konten')
<h1 class="h3 mb-4">Detail Mahasiswa</h1>
<div class="card">
    <div class="card-body">
        <h2 class="h5">{{ $mahasiswa->nama }}</h2>
        <dl class="row mb-0">
            <dt class="col-sm-3">NIM</dt>
            <dd class="col-sm-9">{{ $mahasiswa->nim }}</dd>
            <dt class="col-sm-3">Program Studi</dt>
            <dd class="col-sm-9">{{ $mahasiswa->programStudi->nama }}</dd>
            <dt class="col-sm-3">Angkatan</dt>
            <dd class="col-sm-9">{{ $mahasiswa->angkatan }}</dd>
        </dl>
    </div>
</div>
<h2 class="h5 mt-4">Mata Kuliah yang Diambil</h2>
<div class="table-responsive">
    <table class="table table-bordered bg-white align-middle">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Mata Kuliah</th>
                <th>Semester</th>
                <th>SKS</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mahasiswa->matakuliah as $matakuliah)
                <tr>
                    <td>{{ $matakuliah->kode }}</td>
                    <td>{{ $matakuliah->nama }}</td>
                    <td>{{ $matakuliah->semester }}</td>
                    <td>{{ $matakuliah->sks }}</td>
                    <td><strong>{{ $matakuliah->pivot->nilai }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada mata kuliah yang diambil.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary
mt-3">Kembali</a>
@endsection
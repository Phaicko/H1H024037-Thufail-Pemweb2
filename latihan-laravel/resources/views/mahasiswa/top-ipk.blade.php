@extends('layouts.app')
@section('judul', '10 Mahasiswa IPK Tertinggi')
@section('konten')
<h1 class="h3 mb-4">10 Mahasiswa dengan IPK Tertinggi</h1>
<p class="text-muted">Program Studi Teknik Komputer</p>

<table class="table table-striped table-bordered bg-white">
    <thead>
        <tr>
            <th>Peringkat</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Angkatan</th>
            <th>IPK</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($daftarMahasiswa as $nomor => $mahasiswa)
            <tr>
                <td>{{ $nomor + 1 }}</td>
                <td>{{ $mahasiswa->nim }}</td>
                <td>{{ $mahasiswa->nama }}</td>
                <td>{{ $mahasiswa->angkatan }}</td>
                <td><strong>{{ $mahasiswa->ipk }}</strong></td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Data mahasiswa belum tersedia.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['fields' => ['sometimes', 'string']]);

        if ($request->filled('fields')) {
            $fields = array_values(array_unique(array_filter(array_map(
                'trim',
                explode(',', $request->query('fields'))
            ))));

            if ($fields === []) {
                throw ValidationException::withMessages([
                    'fields' => 'Pilih minimal satu kolom',
                ]);
            }

            $fieldsTidakValid = array_diff($fields, MahasiswaResource::FIELDS);
            if ($fieldsTidakValid !== []) {
                throw ValidationException::withMessages([
                    'fields' => 'Kolom tidak dikenal: ' . implode(', ', $fieldsTidakValid),
                ]);
            }

            $request->attributes->set('mahasiswa.fields', $fields);
        }

        $kueri = Mahasiswa::query()->with('programStudi');
        if ($request->filled('cari')) {
            $kataKunci = $request->query('cari');
            $kueri->where(function ($sub) use ($kataKunci) {
                $sub->where('nama', 'like', '%' . $kataKunci . '%')
                    ->orWhere('nim', 'like', '%' . $kataKunci . '%');
            });
        }
        if ($request->filled('angkatan')) {
            $kueri->where('angkatan', $request->integer('angkatan'));
        }
        if ($request->filled('program_studi_id')) {
            $kueri->where(
                'program_studi_id',
                $request->integer('program_studi_id')
            );
        }
        $urutan = $request->query('urut', 'nama');
        $arah = $request->query('arah', 'asc');
        $kolomDiizinkan = ['nama', 'nim', 'angkatan', 'ipk'];
        if (in_array($urutan, $kolomDiizinkan, true)) {
            $kueri->orderBy($urutan, $arah === 'desc' ? 'desc' : 'asc');
        }
        $perHalaman = min($request->integer('per_halaman', 10), 100);
        return MahasiswaResource::collection($kueri->paginate($perHalaman));
    }

    public function byProgramStudi(Request $request, int $id)
    {
        $programStudi = ProgramStudi::findOrFail($id);
        $perHalaman = max(1, min($request->integer('per_halaman', 10), 100));

        return MahasiswaResource::collection(
            $programStudi->mahasiswa()
                ->with('programStudi')
                ->orderBy('nama')
                ->paginate($perHalaman)
        );
    }

    public function store(StoreMahasiswaRequest $request): JsonResponse
    {
        $mahasiswa = Mahasiswa::create($request->validated());
        $mahasiswa->load('programStudi');
        return response()->json([
            'sukses' => true,
            'pesan' => 'Data mahasiswa berhasil dibuat',
            'data' => new MahasiswaResource($mahasiswa),
        ], 201);
    }
    public function show(Mahasiswa $mahasiswa): JsonResponse
    {
        $mahasiswa->load('programStudi');
        return response()->json([
            'sukses' => true,
            'data' => new MahasiswaResource($mahasiswa),
        ]);
    }
    public function update(UpdateMahasiswaRequest $request, Mahasiswa
    $mahasiswa): JsonResponse
    {
        $mahasiswa->update($request->validated());
        $mahasiswa->load('programStudi');
        return response()->json([
            'sukses' => true,
            'pesan' => 'Data mahasiswa berhasil diperbarui',
            'data' => new MahasiswaResource($mahasiswa),
        ]);
    }
    public function destroy(Mahasiswa $mahasiswa): JsonResponse
    {
        $mahasiswa->delete();
        return response()->json([
            'sukses' => true,
            'pesan' => 'Data mahasiswa berhasil dihapus',
        ]);
    }
}

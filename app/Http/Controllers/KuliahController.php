<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perkuliahan;

class KuliahController extends Controller
{

    public function getAllNilai()
    {
        try {
            $perkuliahan = Perkuliahan::with('mahasiswa', 'matakuliah')->get();

            if ($perkuliahan->isEmpty()) {
                return response()->json(['message' => 'Data not found'], 404);
            }

            return $perkuliahan->map(function ($perkuliahan) {
                return [
                    'id_perkuliahan' => $perkuliahan->id_perkuliahan,
                    'nim' => $perkuliahan->nim,
                    'nama' => $perkuliahan->mahasiswa->nama,
                    'alamat' => $perkuliahan->mahasiswa->alamat,
                    'tanggal_lahir' => $perkuliahan->mahasiswa->tanggal_lahir,
                    'kode_mk' => $perkuliahan->kode_mk,
                    'nama_mk' => $perkuliahan->matakuliah->nama_mk,
                    'sks' => $perkuliahan->matakuliah->sks,
                    'nilai' => $perkuliahan->nilai,
                ];
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }
    
    public function getNilaiByNim($nim)
    {
        try {
            $perkuliahan = Perkuliahan::with('mahasiswa', 'matakuliah')
                ->where('nim', $nim)
                ->firstOrFail();
    
            return [
                'id_perkuliahan' => $perkuliahan->id_perkuliahan,
                'nim' => $perkuliahan->nim,
                'nama' => $perkuliahan->mahasiswa->nama,
                'alamat' => $perkuliahan->mahasiswa->alamat,
                'tanggal_lahir' => $perkuliahan->mahasiswa->tanggal_lahir,
                'kode_mk' => $perkuliahan->kode_mk,
                'nama_mk' => $perkuliahan->matakuliah->nama_mk,
                'sks' => $perkuliahan->matakuliah->sks,
                'nilai' => $perkuliahan->nilai,
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Mahasiswa dengan NIM ini tidak memiliki riwayat perkuliahan'], 404);
        }
    }

    public function addNilai(Request $request)
    {
        try {
            $perkuliahan = new Perkuliahan;
            $perkuliahan->nim = $request->nim;
            $perkuliahan->kode_mk = $request->kode_mk;
            $perkuliahan->nilai = $request->nilai;
            $perkuliahan->save();

            return response()->json(['message' => 'Nilai berhasil ditambahkan'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function getNilaiByIdPerkuliahan($id_perkuliahan)
{
    try {
        $perkuliahan = Perkuliahan::with('mahasiswa', 'matakuliah')
            ->where('id_perkuliahan', $id_perkuliahan)
            ->firstOrFail();

        return [
            'nim' => $perkuliahan->nim,
            'nama' => $perkuliahan->mahasiswa->nama,
            'alamat' => $perkuliahan->mahasiswa->alamat,
            'tanggal_lahir' => $perkuliahan->mahasiswa->tanggal_lahir,
            'kode_mk' => $perkuliahan->kode_mk,
            'nama_mk' => $perkuliahan->matakuliah->nama_mk,
            'sks' => $perkuliahan->matakuliah->sks,
            'nilai' => $perkuliahan->nilai,
        ];
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['message' => 'Perkuliahan dengan ID ini tidak ditemukan'], 404);
    }
}

    public function updateNilai(Request $request, $nim, $kode_mk)
    {
        try {
            $perkuliahan = Perkuliahan::where('nim', $nim)
                ->where('kode_mk', $kode_mk)
                ->firstOrFail();

            $perkuliahan->nilai = $request->nilai;
            $perkuliahan->save();

            return response()->json(['message' => 'Nilai berhasil diupdate'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Perkuliahan dengan NIM dan kode_mk ini tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }
    
    public function deleteNilai($nim, $kode_mk)
    {
        try {
            $perkuliahan = Perkuliahan::where('nim', $nim)
                ->where('kode_mk', $kode_mk)
                ->firstOrFail();

            $perkuliahan->delete();

            return response()->json(['message' => 'Nilai berhasil dihapus'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Perkuliahan dengan NIM dan kode_mk ini tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }
}


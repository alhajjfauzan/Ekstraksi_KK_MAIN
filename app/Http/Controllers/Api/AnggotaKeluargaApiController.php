<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKeluarga;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @tags Anggota Keluarga
 */
class AnggotaKeluargaApiController extends Controller
{
    /**
     * Menampilkan daftar semua Anggota Keluarga
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $anggota = AnggotaKeluarga::with([
            'kartuKeluarga',
            'dataKelahiran',
            'dataDokumen',
            'dataStatus',
            'agama',
            'pendidikan'
        ])->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Anggota Keluarga berhasil diambil',
            'data' => $anggota
        ]);
    }

    /**
     * Menyimpan Anggota Keluarga baru
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nik' => 'required|string|unique:anggota_keluargas,nik|max:16',
            'kartu_keluarga_id' => 'required|string|exists:kartu_keluargas,no_kk',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_perkawinan' => 'nullable|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_hubungan' => 'required|string|max:50'
        ]);

        $anggota = AnggotaKeluarga::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Anggota Keluarga berhasil ditambahkan',
            'data' => $anggota
        ], 201);
    }

    /**
     * Menampilkan detail Anggota Keluarga berdasarkan NIK
     *
     * @param string $nik
     * @return JsonResponse
     */
    public function show(string $nik): JsonResponse
    {
        $anggota = AnggotaKeluarga::with([
            'kartuKeluarga',
            'dataKelahiran',
            'dataDokumen',
            'dataStatus',
            'agama',
            'pendidikan'
        ])->find($nik);

        if (!$anggota) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota Keluarga tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Anggota Keluarga berhasil diambil',
            'data' => $anggota
        ]);
    }

    /**
     * Mengupdate data Anggota Keluarga
     *
     * @param Request $request
     * @param string $nik
     * @return JsonResponse
     */
    public function update(Request $request, string $nik): JsonResponse
    {
        $anggota = AnggotaKeluarga::find($nik);

        if (!$anggota) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota Keluarga tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama_lengkap' => 'sometimes|string|max:255',
            'tanggal_perkawinan' => 'nullable|date',
            'jenis_kelamin' => 'sometimes|in:Laki-laki,Perempuan',
            'status_hubungan' => 'sometimes|string|max:50'
        ]);

        $anggota->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Anggota Keluarga berhasil diupdate',
            'data' => $anggota
        ]);
    }

    /**
     * Menghapus Anggota Keluarga
     *
     * @param string $nik
     * @return JsonResponse
     */
    public function destroy(string $nik): JsonResponse
    {
        $anggota = AnggotaKeluarga::find($nik);

        if (!$anggota) {
            return response()->json([
                'success' => false,
                'message' => 'Anggota Keluarga tidak ditemukan'
            ], 404);
        }

        $anggota->delete();

        return response()->json([
            'success' => true,
            'message' => 'Anggota Keluarga berhasil dihapus'
        ]);
    }

    /**
     * Mendapatkan anggota berdasarkan No KK
     *
     * @param string $no_kk
     * @return JsonResponse
     */
    public function getByKartuKeluarga(string $no_kk): JsonResponse
    {
        $anggota = AnggotaKeluarga::where('kartu_keluarga_id', $no_kk)
            ->with([
                'dataKelahiran',
                'dataDokumen',
                'dataStatus',
                'agama',
                'pendidikan'
            ])
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data Anggota Keluarga berhasil diambil',
            'data' => $anggota
        ]);
    }

    /**
     * Mencari Anggota Keluarga berdasarkan nama
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = AnggotaKeluarga::query();

        if ($request->has('nama')) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama . '%');
        }

        if ($request->has('nik')) {
            $query->where('nik', 'like', '%' . $request->nik . '%');
        }

        if ($request->has('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $results = $query->with('kartuKeluarga')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pencarian berhasil',
            'data' => $results
        ]);
    }
}

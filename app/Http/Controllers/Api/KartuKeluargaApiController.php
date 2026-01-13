<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @tags Kartu Keluarga
 */
class KartuKeluargaApiController extends Controller
{
    /**
     * Menampilkan daftar semua Kartu Keluarga
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $kartuKeluarga = KartuKeluarga::with('anggota')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Kartu Keluarga berhasil diambil',
            'data' => $kartuKeluarga
        ]);
    }

    /**
     * Menyimpan Kartu Keluarga baru
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'no_kk' => 'required|string|unique:kartu_keluargas,no_kk|max:16',
            'kepala_keluarga' => 'required|string|max:255',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:5',
            'tanggal_dikeluarkan' => 'required|date'
        ]);

        $kartuKeluarga = KartuKeluarga::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kartu Keluarga berhasil ditambahkan',
            'data' => $kartuKeluarga
        ], 201);
    }

    /**
     * Menampilkan detail Kartu Keluarga berdasarkan No KK
     *
     * @param string $no_kk
     * @return JsonResponse
     */
    public function show(string $no_kk): JsonResponse
    {
        $kartuKeluarga = KartuKeluarga::with([
            'anggota.dataKelahiran',
            'anggota.dataDokumen',
            'anggota.dataStatus',
            'anggota.agama',
            'anggota.pendidikan'
        ])->find($no_kk);

        if (!$kartuKeluarga) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu Keluarga tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Kartu Keluarga berhasil diambil',
            'data' => $kartuKeluarga
        ]);
    }

    /**
     * Mengupdate data Kartu Keluarga
     *
     * @param Request $request
     * @param string $no_kk
     * @return JsonResponse
     */
    public function update(Request $request, string $no_kk): JsonResponse
    {
        $kartuKeluarga = KartuKeluarga::find($no_kk);

        if (!$kartuKeluarga) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu Keluarga tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'kepala_keluarga' => 'sometimes|string|max:255',
            'alamat' => 'sometimes|string',
            'rt' => 'sometimes|string|max:3',
            'rw' => 'sometimes|string|max:3',
            'kelurahan' => 'sometimes|string|max:255',
            'kecamatan' => 'sometimes|string|max:255',
            'kabupaten' => 'sometimes|string|max:255',
            'provinsi' => 'sometimes|string|max:255',
            'kode_pos' => 'nullable|string|max:5',
            'tanggal_dikeluarkan' => 'sometimes|date'
        ]);

        $kartuKeluarga->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kartu Keluarga berhasil diupdate',
            'data' => $kartuKeluarga
        ]);
    }

    /**
     * Menghapus Kartu Keluarga
     *
     * @param string $no_kk
     * @return JsonResponse
     */
    public function destroy(string $no_kk): JsonResponse
    {
        $kartuKeluarga = KartuKeluarga::find($no_kk);

        if (!$kartuKeluarga) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu Keluarga tidak ditemukan'
            ], 404);
        }

        $kartuKeluarga->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kartu Keluarga berhasil dihapus'
        ]);
    }

    /**
     * Mencari Kartu Keluarga berdasarkan kriteria
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query = KartuKeluarga::query();

        if ($request->has('no_kk')) {
            $query->where('no_kk', 'like', '%' . $request->no_kk . '%');
        }

        if ($request->has('kepala_keluarga')) {
            $query->where('kepala_keluarga', 'like', '%' . $request->kepala_keluarga . '%');
        }

        if ($request->has('kelurahan')) {
            $query->where('kelurahan', 'like', '%' . $request->kelurahan . '%');
        }

        if ($request->has('kecamatan')) {
            $query->where('kecamatan', 'like', '%' . $request->kecamatan . '%');
        }

        $results = $query->with('anggota')->get();

        return response()->json([
            'success' => true,
            'message' => 'Pencarian berhasil',
            'data' => $results
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataKelahiran;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @tags Data Kelahiran
 */
class DataKelahiranApiController extends Controller
{
    /**
     * Menampilkan daftar semua Data Kelahiran
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $dataKelahiran = DataKelahiran::with('anggota')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Kelahiran berhasil diambil',
            'data' => $dataKelahiran
        ]);
    }

    /**
     * Menyimpan Data Kelahiran baru
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nik_fk' => 'required|string|exists:anggota_keluargas,nik',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255'
        ]);

        $dataKelahiran = DataKelahiran::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Kelahiran berhasil ditambahkan',
            'data' => $dataKelahiran
        ], 201);
    }

    /**
     * Menampilkan detail Data Kelahiran berdasarkan NIK
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function show(string $nik_fk): JsonResponse
    {
        $dataKelahiran = DataKelahiran::with('anggota')->find($nik_fk);

        if (!$dataKelahiran) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kelahiran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Kelahiran berhasil diambil',
            'data' => $dataKelahiran
        ]);
    }

    /**
     * Mengupdate Data Kelahiran
     *
     * @param Request $request
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function update(Request $request, string $nik_fk): JsonResponse
    {
        $dataKelahiran = DataKelahiran::find($nik_fk);

        if (!$dataKelahiran) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kelahiran tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'tempat_lahir' => 'sometimes|string|max:255',
            'tanggal_lahir' => 'sometimes|date',
            'nama_ayah' => 'sometimes|string|max:255',
            'nama_ibu' => 'sometimes|string|max:255'
        ]);

        $dataKelahiran->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Kelahiran berhasil diupdate',
            'data' => $dataKelahiran
        ]);
    }

    /**
     * Menghapus Data Kelahiran
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function destroy(string $nik_fk): JsonResponse
    {
        $dataKelahiran = DataKelahiran::find($nik_fk);

        if (!$dataKelahiran) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kelahiran tidak ditemukan'
            ], 404);
        }

        $dataKelahiran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Kelahiran berhasil dihapus'
        ]);
    }
}

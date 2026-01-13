<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataDokumen;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @tags Data Dokumen
 */
class DataDokumenApiController extends Controller
{
    /**
     * Menampilkan daftar semua Data Dokumen
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $dataDokumen = DataDokumen::with('anggota')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Dokumen berhasil diambil',
            'data' => $dataDokumen
        ]);
    }

    /**
     * Menyimpan Data Dokumen baru
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nik_fk' => 'required|string|exists:anggota_keluargas,nik',
            'no_paspor' => 'nullable|string|max:50',
            'no_kitap' => 'nullable|string|max:50',
            'tanggal_pembuatan' => 'required|date'
        ]);

        $dataDokumen = DataDokumen::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Dokumen berhasil ditambahkan',
            'data' => $dataDokumen
        ], 201);
    }

    /**
     * Menampilkan detail Data Dokumen berdasarkan NIK
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function show(string $nik_fk): JsonResponse
    {
        $dataDokumen = DataDokumen::with('anggota')->find($nik_fk);

        if (!$dataDokumen) {
            return response()->json([
                'success' => false,
                'message' => 'Data Dokumen tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Dokumen berhasil diambil',
            'data' => $dataDokumen
        ]);
    }

    /**
     * Mengupdate Data Dokumen
     *
     * @param Request $request
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function update(Request $request, string $nik_fk): JsonResponse
    {
        $dataDokumen = DataDokumen::find($nik_fk);

        if (!$dataDokumen) {
            return response()->json([
                'success' => false,
                'message' => 'Data Dokumen tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'no_paspor' => 'nullable|string|max:50',
            'no_kitap' => 'nullable|string|max:50',
            'tanggal_pembuatan' => 'sometimes|date'
        ]);

        $dataDokumen->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Dokumen berhasil diupdate',
            'data' => $dataDokumen
        ]);
    }

    /**
     * Menghapus Data Dokumen
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function destroy(string $nik_fk): JsonResponse
    {
        $dataDokumen = DataDokumen::find($nik_fk);

        if (!$dataDokumen) {
            return response()->json([
                'success' => false,
                'message' => 'Data Dokumen tidak ditemukan'
            ], 404);
        }

        $dataDokumen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Dokumen berhasil dihapus'
        ]);
    }
}

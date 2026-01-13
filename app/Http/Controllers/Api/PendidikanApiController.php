<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendidikan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @tags Pendidikan
 */
class PendidikanApiController extends Controller
{
    /**
     * Menampilkan daftar semua Pendidikan
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $pendidikan = Pendidikan::with('anggota')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Pendidikan berhasil diambil',
            'data' => $pendidikan
        ]);
    }

    /**
     * Menyimpan Pendidikan baru
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nik_fk' => 'required|string|exists:anggota_keluargas,nik',
            'nama' => 'required|string|max:100'
        ]);

        $pendidikan = Pendidikan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Pendidikan berhasil ditambahkan',
            'data' => $pendidikan
        ], 201);
    }

    /**
     * Menampilkan detail Pendidikan berdasarkan NIK
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function show(string $nik_fk): JsonResponse
    {
        $pendidikan = Pendidikan::with('anggota')->find($nik_fk);

        if (!$pendidikan) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pendidikan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Pendidikan berhasil diambil',
            'data' => $pendidikan
        ]);
    }

    /**
     * Mengupdate Pendidikan
     *
     * @param Request $request
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function update(Request $request, string $nik_fk): JsonResponse
    {
        $pendidikan = Pendidikan::find($nik_fk);

        if (!$pendidikan) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pendidikan tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama' => 'sometimes|string|max:100'
        ]);

        $pendidikan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Pendidikan berhasil diupdate',
            'data' => $pendidikan
        ]);
    }

    /**
     * Menghapus Pendidikan
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function destroy(string $nik_fk): JsonResponse
    {
        $pendidikan = Pendidikan::find($nik_fk);

        if (!$pendidikan) {
            return response()->json([
                'success' => false,
                'message' => 'Data Pendidikan tidak ditemukan'
            ], 404);
        }

        $pendidikan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Pendidikan berhasil dihapus'
        ]);
    }
}

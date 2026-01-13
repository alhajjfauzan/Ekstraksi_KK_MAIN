<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agama;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @tags Agama
 */
class AgamaApiController extends Controller
{
    /**
     * Menampilkan daftar semua Agama
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $agama = Agama::with('anggota')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Agama berhasil diambil',
            'data' => $agama
        ]);
    }

    /**
     * Menyimpan Agama baru
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nik_fk' => 'required|string|exists:anggota_keluargas,nik',
            'nama' => 'required|string|max:50'
        ]);

        $agama = Agama::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Agama berhasil ditambahkan',
            'data' => $agama
        ], 201);
    }

    /**
     * Menampilkan detail Agama berdasarkan NIK
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function show(string $nik_fk): JsonResponse
    {
        $agama = Agama::with('anggota')->find($nik_fk);

        if (!$agama) {
            return response()->json([
                'success' => false,
                'message' => 'Data Agama tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Agama berhasil diambil',
            'data' => $agama
        ]);
    }

    /**
     * Mengupdate Agama
     *
     * @param Request $request
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function update(Request $request, string $nik_fk): JsonResponse
    {
        $agama = Agama::find($nik_fk);

        if (!$agama) {
            return response()->json([
                'success' => false,
                'message' => 'Data Agama tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama' => 'sometimes|string|max:50'
        ]);

        $agama->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Agama berhasil diupdate',
            'data' => $agama
        ]);
    }

    /**
     * Menghapus Agama
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function destroy(string $nik_fk): JsonResponse
    {
        $agama = Agama::find($nik_fk);

        if (!$agama) {
            return response()->json([
                'success' => false,
                'message' => 'Data Agama tidak ditemukan'
            ], 404);
        }

        $agama->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Agama berhasil dihapus'
        ]);
    }
}

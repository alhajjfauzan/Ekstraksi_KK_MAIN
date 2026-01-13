<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataStatus;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @tags Data Status
 */
class DataStatusApiController extends Controller
{
    /**
     * Menampilkan daftar semua Data Status
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $dataStatus = DataStatus::with(['anggota', 'agama', 'pendidikan'])->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Status berhasil diambil',
            'data' => $dataStatus
        ]);
    }

    /**
     * Menyimpan Data Status baru
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nik_fk' => 'required|string|exists:anggota_keluargas,nik',
            'pekerjaan' => 'required|string|max:255',
            'golongan_darah' => 'nullable|string|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
            'status_perkawinan' => 'required|string|max:50',
            'kewarganegaraan' => 'required|string|max:50',
            'agama_id' => 'nullable|exists:agamas,nik_fk',
            'pendidikan_id' => 'nullable|exists:pendidikans,nik_fk'
        ]);

        $dataStatus = DataStatus::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Status berhasil ditambahkan',
            'data' => $dataStatus
        ], 201);
    }

    /**
     * Menampilkan detail Data Status berdasarkan NIK
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function show(string $nik_fk): JsonResponse
    {
        $dataStatus = DataStatus::with(['anggota', 'agama', 'pendidikan'])->find($nik_fk);

        if (!$dataStatus) {
            return response()->json([
                'success' => false,
                'message' => 'Data Status tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Status berhasil diambil',
            'data' => $dataStatus
        ]);
    }

    /**
     * Mengupdate Data Status
     *
     * @param Request $request
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function update(Request $request, string $nik_fk): JsonResponse
    {
        $dataStatus = DataStatus::find($nik_fk);

        if (!$dataStatus) {
            return response()->json([
                'success' => false,
                'message' => 'Data Status tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'pekerjaan' => 'sometimes|string|max:255',
            'golongan_darah' => 'nullable|string|in:A,B,AB,O,A+,A-,B+,B-,AB+,AB-,O+,O-',
            'status_perkawinan' => 'sometimes|string|max:50',
            'kewarganegaraan' => 'sometimes|string|max:50',
            'agama_id' => 'nullable|exists:agamas,nik_fk',
            'pendidikan_id' => 'nullable|exists:pendidikans,nik_fk'
        ]);

        $dataStatus->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data Status berhasil diupdate',
            'data' => $dataStatus
        ]);
    }

    /**
     * Menghapus Data Status
     *
     * @param string $nik_fk
     * @return JsonResponse
     */
    public function destroy(string $nik_fk): JsonResponse
    {
        $dataStatus = DataStatus::find($nik_fk);

        if (!$dataStatus) {
            return response()->json([
                'success' => false,
                'message' => 'Data Status tidak ditemukan'
            ], 404);
        }

        $dataStatus->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Status berhasil dihapus'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Models\AnggotaKeluarga;

class CekDuplikatController extends Controller
{
    public function cek(Request $request)
    {
        $noKK = $request->no_kk;
        $nik  = $request->nik;

        return response()->json([
            'no_kk_exists' => $noKK
                ? KartuKeluarga::where('no_kk', $noKK)->exists()
                : false,

            'nik_exists' => $nik
                ? AnggotaKeluarga::where('nik', $nik)->exists()
                : false,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\AnggotaKeluarga;

class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah KK
        $jumlahKK = KartuKeluarga::count();

        // Jumlah Warga (SEMUA anggota)
        $jumlahWarga = AnggotaKeluarga::count();

        // Data KK + hitung anggota (opsional, tapi bagus)
        $kartuKeluargas = KartuKeluarga::withCount('anggotaKeluarga')
            ->orderBy('no_kk', 'asc')
            ->paginate(10);

        return view('dashboard', compact(
            'jumlahKK',
            'jumlahWarga',
            'kartuKeluargas'
        ));
    }
}

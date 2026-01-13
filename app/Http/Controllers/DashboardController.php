<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\AnggotaKeluarga;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahKK = KartuKeluarga::count();
        $jumlahWarga = AnggotaKeluarga::count();
        $kartuKeluargas = KartuKeluarga::withCount('anggota')
            ->orderBy('no_kk', 'asc')
            ->paginate(10);

        return view('dashboard', compact(
            'jumlahKK',
            'jumlahWarga',
            'kartuKeluargas'
        ));
    }
}

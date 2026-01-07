<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga; 

class KartuKeluargaController extends Controller
{
    public function create()
    {
        return view('keluarga.tambah');
    }
    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|unique:kartu_keluarga,no_kk',
            'rt' => 'required',
            'rw' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
        ]);

        KartuKeluarga::create([
            'no_kk' => $request->no_kk,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Data keluarga berhasil ditambahkan');
    }
}

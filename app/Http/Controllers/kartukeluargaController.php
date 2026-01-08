<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Models\AnggotaKeluarga;

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
            'provinsi' => 'required',
            'tanggal_dikeluarkan' => 'required|date',
            'members' => 'required|array|min:1',
            'members.*.nama_lengkap' => 'required|string',
            'members.*.nik' => 'required|string',
            'members.*.jenis_kelamin' => 'required|string',
            'members.*.tempat_lahir' => 'required|string',
            'members.*.tanggal_lahir' => 'required|date',
            'members.*.agama' => 'required|string',
            'members.*.pendidikan' => 'required|string',
            'members.*.pekerjaan' => 'required|string',
            'members.*.golongan_darah' => 'required|string',
            'members.*.status_perkawinan' => 'required|string',
            'members.*.status_hubungan' => 'required|string',
            'members.*.kewarganegaraan' => 'required|string',
            'members.*.nama_ayah' => 'required|string',
            'members.*.nama_ibu' => 'required|string',
        ]);

        // Create Kartu Keluarga
        $kartuKeluarga = KartuKeluarga::create([
            'no_kk' => $request->no_kk,
            'kepala_keluarga' => $request->members[0]['nama_lengkap'] ?? 'N/A',
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'tanggal_dikeluarkan' => $request->tanggal_dikeluarkan,
        ]);

        // Create Anggota Keluarga
        if ($request->has('members')) {
            foreach ($request->members as $member) {
                AnggotaKeluarga::create([
                    'nik' => $member['nik'],
                    'nama_anggota' => $member['nama_lengkap'],
                    'jenis_kelamin' => $member['jenis_kelamin'],
                    'status_hubungan' => $member['status_hubungan'],
                    'no_kk_id' => $request->no_kk,
                    'tempat_lahir' => $member['tempat_lahir'],
                    'tanggal_lahir' => $member['tanggal_lahir'],
                    'agama' => $member['agama'],
                    'pendidikan' => $member['pendidikan'],
                    'pekerjaan' => $member['pekerjaan'],
                    'golongan_darah' => $member['golongan_darah'],
                    'status_perkawinan' => $member['status_perkawinan'],
                    'kewarganegaraan' => $member['kewarganegaraan'],
                    'nama_ayah' => $member['nama_ayah'],
                    'nama_ibu' => $member['nama_ibu'],
                    'tanggal_perkawinan' => $member['tanggal_perkawinan'] ?? null,
                    'no_pasport' => $member['no_pasport'] ?? null,
                    'no_kitap' => $member['no_kitap'] ?? null,
                ]);
            }
        }

        return redirect('/dashboard')->with([
            'success_title' => 'Berhasil!',
            'success_message' => 'Data keluarga berhasil ditambahkan',
        ]);
    }
}
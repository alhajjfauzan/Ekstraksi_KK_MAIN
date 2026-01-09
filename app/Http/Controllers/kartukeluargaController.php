<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KartuKeluarga;
use App\Models\AnggotaKeluarga;
use App\Models\DataKelahiran;
use App\Models\DataDokumen;
use App\Models\DataStatus;
use App\Models\Agama;
use App\Models\Pendidikan;

class KartuKeluargaController extends Controller
{
    public function create()
    {
        return view('keluarga.tambah');
    }
    public function show($no_kk)
{
    $kk = KartuKeluarga::with('anggota')->findOrFail($no_kk);
    return view('keluarga.show', compact('kk'));
}

    public function edit($no_kk)
{
    $kartuKeluarga = KartuKeluarga::with('anggota')
        ->where('no_kk', $no_kk)
        ->firstOrFail();
    dd($kartuKeluarga->anggota);

    return view('keluarga.edit', compact('kartuKeluarga'));
}

public function update(Request $request, $no_kk)
{
    $request->validate([
        'no_kk' => 'required|digits:16|unique:kartu_keluargas,no_kk,' . $no_kk,
        'rt' => 'required|digits:3',
        'rw' => 'required|digits:3',
        'kelurahan' => 'required',
        'kecamatan' => 'required',
        'kabupaten' => 'required',
        'provinsi' => 'required',
        'tanggal_dikeluarkan' => 'required|date',
        'anggota' => 'required|array|min:1',
        'anggota.*.nama_lengkap' => 'required|string',
        'anggota.*.nik' => 'required|digits:16',
        'anggota.*.jenis_kelamin' => 'required',
        'anggota.*.tempat_lahir' => 'required',
        'anggota.*.tanggal_lahir' => 'required|date',
        'anggota.*.agama' => 'required',
        'anggota.*.pendidikan' => 'required',
        'anggota.*.pekerjaan' => 'required',
        'anggota.*.golongan_darah' => 'required',
        'anggota.*.status_perkawinan' => 'required',
        'anggota.*.status_hubungan' => 'required',
        'anggota.*.kewarganegaraan' => 'required',
        'anggota.*.nama_ayah' => 'required',
        'anggota.*.nama_ibu' => 'required',
    ]);

    DB::transaction(function () use ($request, $no_kk) {
        $kk = KartuKeluarga::findOrFail($no_kk);

        $kk->update([
            'no_kk' => $request->no_kk,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'tanggal_dikeluarkan' => $request->tanggal_dikeluarkan,
            'kepala_keluarga' => $request->kepala_keluarga ?? $kk->kepala_keluarga,
            'alamat' => $request->alamat ?? $kk->alamat,
            'kode_pos' => $request->kode_pos ?? $kk->kode_pos,
            
        ]);

       foreach ($request->anggota as $a) {
            if (!empty($a['nik'])) {
                $anggota = $kk->anggota()->updateOrCreate(
                       ['nik' => $a['nik'], 'kartu_keluarga_id' => $kk->no_kk],
                    [
                        'nama_lengkap' => $a['nama_lengkap'],
                        'jenis_kelamin' => $a['jenis_kelamin'],
                        'status_perkawinan' => $a['status_perkawinan'],
                        // 'tanggal_perkawinan' => $a['tanggal_perkawinan'] ?? null,
                    ]
                );
                DataKelahiran::updateOrCreate(
                    ['nik_fk' => $a['nik']],
                    [
                        'tempat_lahir' => $a['tempat_lahir'],
                        'tanggal_lahir' => $a['tanggal_lahir'],
                        'jenis_kelamin' => $a['jenis_kelamin'],
                        'nama_ayah' => $a['nama_ayah'],
                        'nama_ibu' => $a['nama_ibu'],
                    ]
                );

                DataDokumen::updateOrCreate(
                    ['nik_fk' => $a['nik']],
                    [
                        'no_dokumen' => $a['no_pasport'] ?? null,
                        'jenis_dokumen' => $a['no_kitap'] ? 'KITAP' : ($a['no_pasport'] ? 'Pasport' : null),
                    ]
                );
                $agama = Agama::firstOrCreate(['nama' => $a['agama']]);
                $pendidikan = Pendidikan::firstOrCreate(['nama' => $a['pendidikan']]);
                DataStatus::updateOrCreate(
                    ['nik_fk' => $a['nik']],
                    [
                        'pekerjaan' => $a['pekerjaan'],
                        'golongan_darah' => $a['golongan_darah'],
                        'status_perkawinan' => $a['status_perkawinan'],
                        'kewarganegaraan' => in_array($a['kewarganegaraan'], ['WNI','WNA']) ? $a['kewarganegaraan'] : 'WNI',
                        'agama_id' => $agama->id,
                        'pendidikan_id' => $pendidikan->id,
                    ]
                );
            }
}});

    return redirect('/dashboard')->with([
        'success_title' => 'Berhasil!',
        'success_message' => 'Data keluarga berhasil diperbarui'
    ]);
}
    public function store(Request $request)
    {
        $request->validate([
            'no_kk' => 'required|digits:16|unique:kartu_keluargas,no_kk',
            'rt' => 'required|digits:3',
            'rw' => 'required|digits:3',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'tanggal_dikeluarkan' => 'required|date',
            'anggota' => 'required|array|min:1',
            'anggota.*.nama_lengkap' => 'required|string',
            'anggota.*.nik' => 'required|digits:16',
            'anggota.*.jenis_kelamin' => 'required',
            'anggota.*.tempat_lahir' => 'required',
            'anggota.*.tanggal_lahir' => 'required|date',
            'anggota.*.agama' => 'required',
            'anggota.*.pendidikan' => 'required',
            'anggota.*.pekerjaan' => 'required',
            'anggota.*.golongan_darah' => 'required',
            'anggota.*.status_perkawinan' => 'required',
            'anggota.*.status_hubungan' => 'required',
            'anggota.*.kewarganegaraan' => 'required',
            'anggota.*.nama_ayah' => 'required',
            'anggota.*.nama_ibu' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $anggotaArray = $request->input('anggota');
            $kepala = collect($anggotaArray)->firstWhere('status_hubungan', 'Kepala Keluarga');
            $kk = KartuKeluarga::create([
                'no_kk' => $request->no_kk,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kelurahan' => $request->kelurahan,
                'kecamatan' => $request->kecamatan,
                'kabupaten' => $request->kabupaten,
                'provinsi' => $request->provinsi,
                'tanggal_dikeluarkan' => $request->tanggal_dikeluarkan,
                'kepala_keluarga' => $kepala['nama_lengkap'] ?? null,
                'alamat' => $request->alamat ?? $request->kelurahan,
                'kode_pos' => $request->kode_pos ?? '00000',
            ]);

            foreach ($request->anggota as $a) {
                
                $kk->anggota()->create([
                    'nik' => $a['nik'],
                    'nama_lengkap' => $a['nama_lengkap'],
                    'jenis_kelamin' => $a['jenis_kelamin'],
                    'status_perkawinan' => $a['status_perkawinan'],
                    // 'tanggal_perkawinan' => $a['tanggal_perkawinan'] ?? 
                    // 'tempat_lahir' => $a['tempat_lahir'],
                    // 'tanggal_lahir' => $a['tanggal_lahir'],
                    // 'agama' => $a['agama'],
                    // 'pendidikan' => $a['pendidikan'],
                    // 'pekerjaan' => $a['pekerjaan'],
                    // 'golongan_darah' => $a['golongan_darah'],
                    // 'tanggal_perkawinan' => $a['tanggal_perkawinan'] ?? null,
                    // 'status_hubungan' => $a['status_hubungan'],
                    // 'kewarganegaraan' => $a['kewarganegaraan'],
                    // 'no_pasport' => $a['no_pasport'] ?? null,
                    // 'no_kitap' => $a['no_kitap'] ?? null,
                ]);

                 DataKelahiran::create([
                'nik_fk' => $a['nik'],
                'tempat_lahir' => $a['tempat_lahir'],
                'tanggal_lahir' => $a['tanggal_lahir'],
                'jenis_kelamin' => $a['jenis_kelamin'],
                'nama_ayah' => $a['nama_ayah'],
                'nama_ibu' => $a['nama_ibu'],
            ]);

            DataDokumen::create([
            'nik_fk' => $a['nik'],
            'no_dokumen' => $a['no_pasport'] ?? null,
                    'jenis_dokumen' => $a['no_kitap'] ? 'KITAP' : ($a['no_pasport'] ? 'Pasport' : null),
            ]);
            $agamaId = Agama::where('nama', $a['agama'])->value('id') ?? null;
            $pendidikanId = Pendidikan::where('nama', $a['pendidikan'])->value('id') ?? null;
            $kewarganegaraan = in_array($a['kewarganegaraan'], ['WNI','WNA']) ? $a['kewarganegaraan'] : 'WNI';
            $agama = Agama::firstOrCreate(['nama' => $a['agama']]); 
            $pendidikan = Pendidikan::firstOrCreate(['nama' => $a['pendidikan']]);
                 DataStatus::create([
                'nik_fk' => $a['nik'],
                'pekerjaan' => $a['pekerjaan'],
                'golongan_darah' => $a['golongan_darah'],
                'status_perkawinan' => $a['status_perkawinan'],
                'kewarganegaraan' => $a['kewarganegaraan'],
                'agama_id' => $agama->id,
                'pendidikan_id' => $pendidikan->id,
            ]);
            }
        });

        return redirect('/dashboard')->with([
            'success_title' => 'Berhasil!',
            'success_message' => 'Data keluarga berhasil ditambahkan'
        ]);
    }
}
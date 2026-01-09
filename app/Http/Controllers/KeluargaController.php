<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\KartuKeluarga;
use App\Models\AnggotaKeluarga;
use App\Models\DataKelahiran;
use App\Models\DataStatus;
use App\Models\DataDokumen;

class KeluargaController extends Controller
{
    public function index() {
        return view('beranda');
    }

    public function create() {
        return view('tambah');
    }

    public function confirm() {
        return view('popup_konfirmasi');
    }

    public function upload() {
        return view('upload');
    }

    public function uploadLanjutan() {
        return view('upload_lanjutan');
    }
    }
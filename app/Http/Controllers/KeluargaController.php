<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
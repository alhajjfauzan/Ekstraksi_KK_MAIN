<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\KartuKeluarga;
use App\Models\AnggotaKeluarga;
use App\Models\DataKelahiran;
use App\Models\DataStatus;
use App\Models\DataDokumen;

class KeluargaController extends Controller
{
    private const AI_ENDPOINT = 'http://10.50.1.46:5000/predict';

    /**
     * Normalisasi hasil AI ke format yang dipakai form tambah.blade.php
     *
     * Struktur keluaran AI (berdasarkan log) memiliki key: pages, success, total_blocks, total_pages.
     * Di sini kita ambil semua teks lalu coba ekstrak informasi penting dengan regex.
     */
    private function normalizeAiResult(array $aiResult): array
    {
        $normalized = [
            'no_kk' => null,
            'rt' => null,
            'rw' => null,
            'kelurahan' => null,
            'kecamatan' => null,
            'kabupaten' => null,
            'provinsi' => null,
            'tanggal_dikeluarkan' => null,
            'anggota' => [],
        ];
        $demografiTableHtml = null;
        $statusTableHtml = null;

        if (isset($aiResult['pages']) && is_array($aiResult['pages'])) {
            foreach ($aiResult['pages'] as $page) {
                if (!isset($page['blocks']) || !is_array($page['blocks'])) {
                    continue;
                }

                foreach ($page['blocks'] as $block) {
                    if (!isset($block['label'], $block['text']) || !is_string($block['text'])) {
                        continue;
                    }
                    $label = $block['label'];
                    $text = $block['text'];

                    switch ($label) {
                        case 'header':
                            if (preg_match('/No\\.?\\s*(\\d{16})/i', $text, $m)) {
                                $normalized['no_kk'] = $m[1];
                            }
                            break;

                        case 'form_fields':                
                            if ($normalized['rt'] === null && $normalized['rw'] === null &&
                                preg_match('/RT\\s*\\/\\s*RW\\s*[:\\-]?\\s*(\\d{1,3})\\/(\\d{1,3})/i', $text, $m)) {
                                $normalized['rt'] = str_pad($m[1], 3, '0', STR_PAD_LEFT);
                                $normalized['rw'] = str_pad($m[2], 3, '0', STR_PAD_LEFT);
                            }
                            if ($normalized['kelurahan'] === null &&
                                preg_match('/(Desa|Kelurahan)\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $text, $m)) {
                                $val = trim($m[2]);
                                $val = preg_replace('/\\s+Kecamatan$/i', '', $val);
                                $normalized['kelurahan'] = trim($val);
                            }
                            if ($normalized['kecamatan'] === null &&
                                preg_match('/Kecamatan\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $text, $m)) {
                                $val = trim($m[1]);
                                $val = preg_replace('/\\s+Kabupaten.*$/i', '', $val);
                                $normalized['kecamatan'] = trim($val);
                            }
                            if ($normalized['kabupaten'] === null &&
                                preg_match('/Kabupaten\\/Kota\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $text, $m)) {
                                $val = trim($m[1]);
                                $val = preg_replace('/\\s+Provinsi.*$/i', '', $val);
                                $normalized['kabupaten'] = trim($val);
                            }
                            if ($normalized['provinsi'] === null &&
                                preg_match('/Provinsi\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $text, $m)) {
                                $normalized['provinsi'] = trim($m[1]);
                            }
                            break;

                        case 'date_field':
                            if ($normalized['tanggal_dikeluarkan'] === null &&
                                preg_match('/(Dikeluarkan\\s*Tanggal|Tanggal)\\s*[:\\-]?\\s*(\\d{1,2}[\\-\\/]\\d{1,2}[\\-\\/]\\d{2,4})/i', $text, $m)) {
                                try {
                                    $date = new \DateTime($m[2]);
                                    $normalized['tanggal_dikeluarkan'] = $date->format('Y-m-d');
                                } catch (\Exception $e) {
                                }
                            }
                            break;

                        case 'table':
                            if ($demografiTableHtml === null) {
                                $demografiTableHtml = $text;
                            } elseif ($statusTableHtml === null) {
                                $statusTableHtml = $text;
                            }
                            break;
                    }
                }
            }
        }
        if ($demografiTableHtml !== null) {
            $normalized['anggota'] = $this->parseAnggotaFromTables($demografiTableHtml, $statusTableHtml);
        }
        $allTextLines = [];
        $walker = function ($node) use (&$walker, &$allTextLines) {
            if (is_array($node)) {
                foreach ($node as $key => $value) {
                    if ($key === 'text' && is_string($value)) {
                        $allTextLines[] = $value;
                    } else {
                        $walker($value);
                    }
                }
            }
        };

        if (isset($aiResult['pages'])) {
            $walker($aiResult['pages']);
        } else {
            $walker($aiResult);
        }
        $fullText = implode("\n", $allTextLines);
        if ($normalized['no_kk'] === null &&
            preg_match('/No\\s*(Kartu\\s*Keluarga|KK)\\s*[:\\-]?\\s*(\\d{16})/i', $fullText, $m)) {
            $normalized['no_kk'] = $m[2];
        }
        if ($normalized['rt'] === null && $normalized['rw'] === null &&
            preg_match('/RT\\s*[:\\-]?\\s*(\\d{1,3})\\s*[,\\/ ]+RW\\s*[:\\-]?\\s*(\\d{1,3})/i', $fullText, $m)) {
            $normalized['rt'] = str_pad($m[1], 3, '0', STR_PAD_LEFT);
            $normalized['rw'] = str_pad($m[2], 3, '0', STR_PAD_LEFT);
        }
        if ($normalized['kelurahan'] === null) {
            if (preg_match('/Kelurahan\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $fullText, $m) ||
                preg_match('/Desa\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $fullText, $m)) {
                $val = trim($m[1]);
                $val = preg_replace('/\\s+Kecamatan$/i', '', $val);
                $normalized['kelurahan'] = trim($val);
            }
        }
        if ($normalized['kecamatan'] === null &&
            preg_match('/Kecamatan\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $fullText, $m)) {
            $val = trim($m[1]);
            $val = preg_replace('/\\s+Kabupaten.*$/i', '', $val);
            $normalized['kecamatan'] = trim($val);
        }
        if ($normalized['kabupaten'] === null) {
            if (preg_match('/Kabupaten\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $fullText, $m) ||
                preg_match('/Kota\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $fullText, $m)) {
                $val = trim($m[1]);
                $val = preg_replace('/\\s+Provinsi.*$/i', '', $val);
                $normalized['kabupaten'] = trim($val);
            }
        }
        if ($normalized['provinsi'] === null &&
            preg_match('/Provinsi\\s*[:\\-]?\\s*([A-Z\\s]+)/i', $fullText, $m)) {
            $normalized['provinsi'] = trim($m[1]);
        }
        if ($normalized['tanggal_dikeluarkan'] === null &&
            preg_match('/Tanggal\\s*(Dikeluarkan|Penerbitan)?\\s*[:\\-]?\\s*(\\d{1,2}[\\-\\/]\\d{1,2}[\\-\\/]\\d{2,4})/i', $fullText, $m)) {
            try {
                $date = new \DateTime($m[2]);
                $normalized['tanggal_dikeluarkan'] = $date->format('Y-m-d');
            } catch (\Exception $e) {
            }
        }

        Log::info('AI normalized data', $normalized);

        return $normalized;
    }

    private function parseAnggotaFromTables(?string $demografiHtml, ?string $statusHtml): array
    {
        if ($demografiHtml === null) {
            return [];
        }
        $anggota = [];
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($demografiHtml);
        libxml_clear_errors();

        $rows = $dom->getElementsByTagName('tr');
        $rowIndex = 0;

        foreach ($rows as $row) {
            $cells = [];
            foreach ($row->getElementsByTagName('td') as $cell) {
                $cells[] = trim($cell->textContent);
            }
            if ($rowIndex < 2) {
                $rowIndex++;
                continue;
            }
            $nonEmpty = array_filter($cells, function ($v) {
                return $v !== '' && $v !== '-' && $v !== '=' && $v !== '1';
            });
            if (count($nonEmpty) === 0) {
                $rowIndex++;
                continue;
            }

            $data = [
                'nama_lengkap' => null,
                'nik' => null,
                'jenis_kelamin' => null,
                'tempat_lahir' => null,
                'tanggal_lahir' => null,
                'agama' => null,
                'pendidikan' => null,
                'pekerjaan' => null,
                'golongan_darah' => null,
            ];

            $c = $cells;
            if (count($c) < 5) {
                $rowIndex++;
                continue;
            }

            $first = $c[0] ?? '';
            $last = $c[count($c) - 1] ?? '';

            $isNik = function ($v) {
                $digits = preg_replace('/\\D/', '', $v);
                return strlen($digits) >= 10;
            };

            if ($isNik($first)) {
                // Pola A: NIK di kolom pertama
                $data['nik'] = $first;
                $data['jenis_kelamin'] = $c[1] ?? null;
                $data['tempat_lahir'] = $c[2] ?? null;
                $data['tanggal_lahir'] = $c[3] ?? null;
                $data['agama'] = $c[4] ?? null;
                $data['pendidikan'] = $c[5] ?? null;
                $data['pekerjaan'] = $c[6] ?? null;
                $data['golongan_darah'] = $c[7] ?? null;
                $data['nama_lengkap'] = $c[8] ?? null;
            } else {
                $penultimateIndex = count($c) - 2;
                $penultimate = $c[$penultimateIndex] ?? '';

                if ($isNik($last)) {
                    // Pola B: NIK di kolom terakhir, nama sebelum NIK
                    $data['nik'] = $last;
                    $data['nama_lengkap'] = $c[$penultimateIndex] ?? null;
                    // Asumsi urutan umum: [Nama, NIK, JK, Tempat, Tgl, Agama, Pendidikan, Pekerjaan, GolDarah]
                    $data['jenis_kelamin'] = $c[2] ?? null;
                    $data['tempat_lahir'] = $c[3] ?? null;
                    $data['tanggal_lahir'] = $c[4] ?? null;
                    $data['agama'] = $c[5] ?? null;
                    $data['pendidikan'] = $c[6] ?? null;
                    $data['pekerjaan'] = $c[7] ?? null;
                    $data['golongan_darah'] = $c[8] ?? null;
                } elseif ($isNik($penultimate)) {
                    // [0]=Tempat,1=Tgl,2=Agama,3=Pendidikan,4=Pekerjaan,5=GolDarah,6=Nama,7=NIK,8=JK
                    $data['nik'] = $penultimate;
                    $data['nama_lengkap'] = $c[6] ?? null;
                    $data['jenis_kelamin'] = $c[8] ?? null;
                    $data['tempat_lahir'] = $c[0] ?? null;
                    $data['tanggal_lahir'] = $c[1] ?? null;
                    $data['agama'] = $c[2] ?? null;
                    $data['pendidikan'] = $c[3] ?? null;
                    $data['pekerjaan'] = $c[4] ?? null;
                    $data['golongan_darah'] = $c[5] ?? null;
                } else {
                    $rowIndex++;
                    continue;
                }
            }
            if (!empty($data['tanggal_lahir'])) {
                try {
                    $d = new \DateTime($data['tanggal_lahir']);
                    $data['tanggal_lahir'] = $d->format('Y-m-d');
                } catch (\Exception $e) {
                }
            }

            $anggota[] = $data;
            $rowIndex++;
        }
        if ($statusHtml !== null && !empty($anggota)) {
            $dom2 = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom2->loadHTML($statusHtml);
            libxml_clear_errors();

            $rows2 = $dom2->getElementsByTagName('tr');
            $rowIndex2 = 0;
            $statusRows = [];

            foreach ($rows2 as $row) {
                $cells = [];
                foreach ($row->getElementsByTagName('td') as $cell) {
                    $cells[] = trim($cell->textContent);
                }
                if ($rowIndex2 < 3) {
                    $rowIndex2++;
                    continue;
                }

                $nonEmpty = array_filter($cells, function ($v) {
                    return $v !== '' && $v !== '-' && $v !== '=';
                });
                if (count($nonEmpty) === 0) {
                    $rowIndex2++;
                    continue;
                }

                $statusRows[] = $cells;
                $rowIndex2++;
            }

            foreach ($anggota as $i => &$a) {
                if (!isset($statusRows[$i])) {
                    continue;
                }
                $c = $statusRows[$i];
                $a['status_perkawinan'] = $c[0] ?? null;
                $a['tanggal_perkawinan'] = $c[1] ?? null;
                $a['status_hubungan'] = $c[2] ?? null;
                $a['kewarganegaraan'] = $c[3] ?? null;
                $a['no_paspor'] = $c[4] ?? null;
                $a['no_kitap'] = $c[5] ?? null;
                $a['nama_ayah'] = $c[6] ?? null;
                $a['nama_ibu'] = $c[7] ?? null;
            }
            unset($a);
        }

        return $anggota;
    }

    public function storeUpload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:jpeg,png,jpg,pdf|max:10240' 
            ], [
                'file.required' => 'File harus dipilih',
                'file.mimes' => 'Format file harus JPG, PNG, atau PDF',
                'file.max' => 'Ukuran file maksimal 10MB'
            ]);
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('uploads', $filename, 'public');
                $fullPath = Storage::disk('public')->path($path);
                try {
                    Log::info('Mengirim file ke AI endpoint', [
                        'endpoint' => self::AI_ENDPOINT,
                        'filename' => $filename,
                        'file_size' => $file->getSize()
                    ]);

                    /** @var \Illuminate\Http\Client\Response $response */
                    $response = Http::timeout(120) 
                        ->attach('file', file_get_contents($fullPath), $filename)
                        ->post(self::AI_ENDPOINT);

                    $statusCode = $response->status();
                    Log::info('AI endpoint response', [
                        'status' => $statusCode,
                        'headers' => $response->headers()
                    ]);
                    
                    if ($statusCode >= 200 && $statusCode < 300) {
                        $aiResult = $response->json();
                        
                        Log::info('AI extraction successful', [
                            'result_keys' => is_array($aiResult) ? array_keys($aiResult) : 'not_array'
                        ]);
                        $normalized = is_array($aiResult) ? $this->normalizeAiResult($aiResult) : null;
                        session()->put([
                            'ai_extracted_data' => $normalized ?: $aiResult,
                            'uploaded_file_path' => Storage::url($path)
                        ]);
                        session()->save();
                        return response()->json([
                            'success' => true,
                            'message' => 'File berhasil diproses oleh AI',
                            'file_path' => Storage::url($path),
                            'filename' => $filename,
                            'ai_result' => $aiResult,
                            'redirect_url' => route('tambah')
                        ]);
                    } else {
                        $responseBody = $response->body();
                        Log::error('AI endpoint error', [
                            'status' => $statusCode,
                            'body' => $responseBody,
                            'headers' => $response->headers()
                        ]);

                        return response()->json([
                            'success' => false,
                            'message' => 'Gagal memproses file dengan AI. Status: ' . $statusCode . '. ' . (strlen($responseBody) > 0 ? 'Pesan: ' . substr($responseBody, 0, 200) : '')
                        ], 500);
                    }
                } catch (\Illuminate\Http\Client\ConnectionException $e) {
                    Log::error('AI endpoint connection error', [
                        'message' => $e->getMessage(),
                        'endpoint' => self::AI_ENDPOINT
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak dapat terhubung ke AI service. Pastikan AI service berjalan di ' . self::AI_ENDPOINT
                    ], 500);
                } catch (\Exception $e) {
                    Log::error('AI endpoint exception', [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                        'endpoint' => self::AI_ENDPOINT
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal terhubung ke AI service: ' . $e->getMessage()
                    ], 500);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan'
            ], 400);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

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
    return view('keluarga.upload-start');
    }

    public function uploadStart() {
        return view('keluarga.upload-start');
        return view('upload');
    }

    public function uploadLanjutan() {
        return view('upload_lanjutan');
    }
    }
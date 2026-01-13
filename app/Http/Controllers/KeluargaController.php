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
            'kode_pos' => null,
            'alamat' => null,
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
        
        // Extract kode pos
        if ($normalized['kode_pos'] === null &&
            preg_match('/Kode\\s*Pos\\s*[:\\-]?\\s*(\\d{5})/i', $fullText, $m)) {
            $normalized['kode_pos'] = $m[1];
        }
        
        // Extract alamat (usually after kelurahan or before RT/RW)
        if ($normalized['alamat'] === null) {
            if (preg_match('/Alamat\\s*[:\\-]?\\s*([A-Z0-9\\s,\\.]+)/i', $fullText, $m)) {
                $normalized['alamat'] = trim($m[1]);
            } elseif (preg_match('/(?:Alamat|Jalan|Jl\\.?)\\s*[:\\-]?\\s*([A-Z0-9\\s,\\.]+?)(?:RT|RW|Kelurahan|Kecamatan)/i', $fullText, $m)) {
                $normalized['alamat'] = trim($m[1]);
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

        // Helper functions
        $isNik = function ($v) {
            $digits = preg_replace('/\\D/', '', $v);
            return strlen($digits) >= 16; // NIK harus 16 digit
        };
        
        $isDate = function ($v) {
            // Check if it looks like a date (DD-MM-YYYY or YYYY-MM-DD)
            return preg_match('/\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4}/', $v) || preg_match('/\d{4}[-\/]\d{1,2}[-\/]\d{1,2}/', $v);
        };
        
        $isJenisKelamin = function ($v) {
            $v = strtoupper(trim($v));
            return in_array($v, ['LAKI-LAKI', 'PEREMPUAN', 'L', 'P', 'LAKI', 'PEREMPUAN']);
        };
        
        $isAgama = function ($v) {
            $v = strtoupper(trim($v));
            return in_array($v, ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDDHA', 'KONGHUCU', 'KHONGHUCU']);
        };
        
        $isGolonganDarah = function ($v) {
            $v = strtoupper(trim($v));
            return in_array($v, ['A', 'B', 'AB', 'O', 'TIDAK TAHU']);
        };

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
            if (count($nonEmpty) < 3) {
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

            // Find NIK first
            $nikIndex = -1;
            foreach ($c as $idx => $cell) {
                if ($isNik($cell)) {
                    $nikIndex = $idx;
                    $data['nik'] = preg_replace('/\D/', '', $cell); // Extract only digits
                    break;
                }
            }
            
            if ($nikIndex === -1) {
                $rowIndex++;
                continue; // Skip if no NIK found
            }

            // Find other fields by pattern matching
            foreach ($c as $idx => $cell) {
                if ($idx === $nikIndex) continue;
                
                $cellUpper = strtoupper(trim($cell));
                
                // Find jenis kelamin
                if ($data['jenis_kelamin'] === null && $isJenisKelamin($cell)) {
                    $data['jenis_kelamin'] = $cell;
                    continue;
                }
                
                // Find agama
                if ($data['agama'] === null && $isAgama($cell)) {
                    $data['agama'] = $cell;
                    continue;
                }
                
                // Find golongan darah
                if ($data['golongan_darah'] === null && $isGolonganDarah($cell)) {
                    $data['golongan_darah'] = $cell;
                    continue;
                }
                
                // Find tanggal lahir (date pattern)
                if ($data['tanggal_lahir'] === null && $isDate($cell)) {
                    try {
                        $date = new \DateTime($cell);
                        $data['tanggal_lahir'] = $date->format('Y-m-d');
                        continue;
                    } catch (\Exception $e) {
                    }
                }
            }
            
            // Find nama lengkap (exclude pendidikan, pekerjaan, and other non-name fields)
            $isPendidikan = function ($v) {
                $v = strtoupper($v);
                return preg_match('/(SD|SMP|SMA|SMK|DIPLOMA|SARJANA|STRATA|S1|S2|S3|TK|PAUD|SLTP|SLTA|SLB)/i', $v);
            };
            
            $isPekerjaan = function ($v) {
                $v = strtoupper($v);
                // Common job titles
                return preg_match('/(PNS|PEGAWAI|GURU|DOKTER|PERAWAT|PEDAGANG|WIRASWASTA|PELAJAR|MAHASISWA|BURUH|KARYAWAN|PETANI|NELAYAN|PENSIUNAN|TIDAK BEKERJA|IBU RUMAH TANGGA)/i', $v);
            };
            
            $candidates = [];
            foreach ($c as $idx => $cell) {
                if ($idx === $nikIndex) continue;
                if ($isNik($cell) || $isDate($cell) || $isJenisKelamin($cell) || 
                    $isAgama($cell) || $isGolonganDarah($cell) || 
                    $isPendidikan($cell) || $isPekerjaan($cell)) {
                    continue;
                }
                // Nama biasanya:
                // - Lebih panjang dari 3 karakter
                // - Mengandung huruf
                // - Tidak hanya angka
                // - Tidak mengandung "/" atau "STRATA" atau "DIPLOMA"
                // - Biasanya mengandung spasi (nama lengkap)
                $cellUpper = strtoupper($cell);
                if (strlen($cell) > 3 && 
                    preg_match('/[A-Za-z]/', $cell) &&
                    !preg_match('/^\d+$/', $cell) &&
                    !preg_match('/(STRATA|DIPLOMA|SARJANA|SD|SMP|SMA)/i', $cellUpper) &&
                    !preg_match('/^[A-Z]$/', $cell) && // Bukan single letter (golongan darah)
                    $cell !== '-') {
                    // Prioritize names with spaces (nama lengkap biasanya lebih dari satu kata)
                    $score = strlen($cell);
                    if (strpos($cell, ' ') !== false) {
                        $score += 10; // Bonus untuk nama yang mengandung spasi
                    }
                    if (preg_match('/^[A-Z\s]+$/', $cell)) {
                        $score += 5; // Bonus untuk nama yang semua huruf besar (format umum nama)
                    }
                    $candidates[] = ['idx' => $idx, 'text' => $cell, 'score' => $score];
                }
            }
            if (!empty($candidates)) {
                // Sort by score, highest first
                usort($candidates, function($a, $b) {
                    return $b['score'] - $a['score'];
                });
                $data['nama_lengkap'] = $candidates[0]['text'];
            }
            
            // Find tempat lahir (usually near tanggal lahir, contains location name)
            foreach ($c as $idx => $cell) {
                if ($idx === $nikIndex) continue;
                if ($data['tempat_lahir'] !== null) break;
                if ($isNik($cell) || $isDate($cell) || $isJenisKelamin($cell) || 
                    $isAgama($cell) || $isGolonganDarah($cell)) {
                    continue;
                }
                // Tempat lahir biasanya nama kota/daerah (huruf besar, panjang sedang)
                if (strlen($cell) >= 3 && strlen($cell) <= 30 && 
                    preg_match('/^[A-Z\s]+$/', $cell) && $cell !== $data['nama_lengkap']) {
                    $data['tempat_lahir'] = $cell;
                    break;
                }
            }
            
            // Find pendidikan (usually contains "SD", "SMP", "SMA", "DIPLOMA", "SARJANA", etc.)
            $isPendidikan = function ($v) {
                $v = strtoupper($v);
                return preg_match('/(SD|SMP|SMA|SMK|DIPLOMA|SARJANA|STRATA|S1|S2|S3|TK|PAUD|SLTP|SLTA|SLB)/i', $v);
            };
            
            foreach ($c as $idx => $cell) {
                if ($idx === $nikIndex) continue;
                if ($data['pendidikan'] !== null) break;
                if ($isNik($cell) || $isDate($cell) || $isJenisKelamin($cell) || 
                    $isAgama($cell) || $isGolonganDarah($cell)) {
                    continue;
                }
                if ($cell === $data['nama_lengkap'] || $cell === $data['tempat_lahir']) {
                    continue;
                }
                if ($isPendidikan($cell)) {
                    $data['pendidikan'] = $cell;
                    break;
                }
            }
            
            // Find pekerjaan (usually the remaining text that's not assigned yet)
            $isPekerjaan = function ($v) {
                $v = strtoupper($v);
                return preg_match('/(PNS|PEGAWAI|GURU|DOKTER|PERAWAT|PEDAGANG|WIRASWASTA|PELAJAR|MAHASISWA|BURUH|KARYAWAN|PETANI|NELAYAN|PENSIUNAN|TIDAK BEKERJA|IBU RUMAH TANGGA)/i', $v);
            };
            
            foreach ($c as $idx => $cell) {
                if ($idx === $nikIndex) continue;
                if ($data['pekerjaan'] !== null) break;
                if ($isNik($cell) || $isDate($cell) || $isJenisKelamin($cell) || 
                    $isAgama($cell) || $isGolonganDarah($cell)) {
                    continue;
                }
                if ($cell === $data['nama_lengkap'] || $cell === $data['tempat_lahir'] || 
                    $cell === $data['pendidikan']) {
                    continue;
                }
                // Check if it looks like a job title
                if ($isPekerjaan($cell)) {
                    $data['pekerjaan'] = $cell;
                    break;
                }
                // Or if it's remaining text that's not a name
                if (strlen($cell) >= 2 && !preg_match('/^\d+$/', $cell) && 
                    $cell !== $data['nama_lengkap']) {
                    $data['pekerjaan'] = $cell;
                    break;
                }
            }

            // Only add if we have at least NIK and nama
            if (!empty($data['nik']) && !empty($data['nama_lengkap'])) {
                Log::info('Parsed anggota data', [
                    'row_index' => $rowIndex,
                    'cells' => $c,
                    'parsed_data' => $data
                ]);
                $anggota[] = $data;
            }
            $rowIndex++;
        }
        
        Log::info('Total anggota parsed', ['count' => count($anggota)]);
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
                    $response = Http::timeout(300) 
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
                        
                        try {
                            session()->put([
                                'ai_extracted_data' => $normalized ?: $aiResult,
                                'uploaded_file_path' => Storage::url($path)
                            ]);
                            session()->save();
                        } catch (\Exception $sessionError) {
                            Log::warning('Session save failed, but continuing', [
                                'error' => $sessionError->getMessage()
                            ]);
                            // Continue even if session save fails - data is in response
                        }
                        
                        return response()->json([
                            'success' => true,
                            'message' => 'File berhasil diproses oleh AI',
                            'file_path' => Storage::url($path),
                            'filename' => $filename,
                            'ai_result' => $aiResult,
                            'normalized_data' => $normalized,
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
                    $errorMessage = $e->getMessage();
                    $isTimeout = strpos($errorMessage, 'timed out') !== false || strpos($errorMessage, 'timeout') !== false;
                    
                    Log::error('AI endpoint connection error', [
                        'message' => $errorMessage,
                        'endpoint' => self::AI_ENDPOINT,
                        'is_timeout' => $isTimeout
                    ]);

                    if ($isTimeout) {
                        return response()->json([
                            'success' => false,
                            'message' => 'AI service membutuhkan waktu lebih lama untuk memproses file. File sudah ter-upload, silakan coba lagi atau hubungi administrator.'
                        ], 504);
                    }

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
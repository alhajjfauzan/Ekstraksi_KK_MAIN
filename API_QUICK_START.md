# 🚀 Quick Start Guide - API Ekstraksi KK

## Langkah 1: Pastikan Aplikasi Berjalan

Pastikan server Laravel sudah berjalan:

```bash
php artisan serve
```

Atau jika menggunakan Laragon, pastikan Apache/Nginx sudah running.

## Langkah 2: Akses Dokumentasi API

Buka browser dan akses:

```
http://localhost/docs/api
```

atau jika menggunakan virtual host:

```
http://ekstraksi-kk-main.test/docs/api
```

## Langkah 3: Test Endpoint

### Test Health Check

```bash
curl http://localhost/api/health
```

Expected Response:
```json
{
  "status": "OK",
  "message": "API is running",
  "timestamp": "2026-01-13 10:00:00"
}
```

### Test GET Kartu Keluarga

```bash
curl http://localhost/api/kartu-keluarga
```

### Test dengan Browser

Cukup buka URL di browser:
```
http://localhost/api/kartu-keluarga
http://localhost/api/anggota-keluarga
http://localhost/api/health
```

## Struktur API yang Dibuat

```
📁 app/Http/Controllers/Api/
├── 📄 KartuKeluargaApiController.php
├── 📄 AnggotaKeluargaApiController.php
├── 📄 DataKelahiranApiController.php
├── 📄 DataDokumenApiController.php
├── 📄 DataStatusApiController.php
├── 📄 AgamaApiController.php
└── 📄 PendidikanApiController.php

📁 routes/
└── 📄 api.php (✅ Baru dibuat)

📁 config/
└── 📄 scramble.php (✅ Konfigurasi dokumentasi)
```

## Fitur yang Sudah Tersedia

✅ **CRUD lengkap untuk semua model:**
- Kartu Keluarga
- Anggota Keluarga
- Data Kelahiran
- Data Dokumen
- Data Status
- Agama
- Pendidikan

✅ **Fitur tambahan:**
- Pencarian Kartu Keluarga
- Pencarian Anggota Keluarga
- Get Anggota by Kartu Keluarga
- Health Check
- Validasi otomatis
- Relationship loading (eager loading)

✅ **Dokumentasi otomatis dengan Scramble:**
- Interactive API Documentation
- Try it out feature
- Schema validation
- Response examples

## Tips Penggunaan

### 1. Menggunakan Postman

Import URL dokumentasi ke Postman:
```
http://localhost/docs/api
```

### 2. Menggunakan JavaScript

```javascript
// Helper function untuk API calls
const api = {
  baseURL: 'http://localhost/api',
  
  async get(endpoint) {
    const response = await fetch(`${this.baseURL}${endpoint}`);
    return response.json();
  },
  
  async post(endpoint, data) {
    const response = await fetch(`${this.baseURL}${endpoint}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });
    return response.json();
  }
};

// Contoh penggunaan
api.get('/kartu-keluarga')
  .then(data => console.log(data));
```

### 3. Menggunakan PHP (dari aplikasi lain)

```php
$ch = curl_init('http://localhost/api/kartu-keluarga');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$data = json_decode($response, true);
curl_close($ch);
```

## Troubleshooting

### API tidak bisa diakses
- ✅ Pastikan server berjalan
- ✅ Cek routes: `php artisan route:list | grep api`
- ✅ Clear cache: `php artisan config:clear && php artisan cache:clear`

### Dokumentasi tidak muncul
- ✅ Pastikan Scramble terinstall: `composer show dedoc/scramble`
- ✅ Clear config cache: `php artisan config:clear`
- ✅ Akses: `http://localhost/docs/api`

### CORS Error (jika akses dari frontend terpisah)
Tambahkan middleware CORS di `bootstrap/app.php` atau install package `fruitcake/laravel-cors`

## Dokumentasi Lengkap

Lihat file `API_DOCUMENTATION.md` untuk dokumentasi lengkap dengan contoh request/response detail.

## Support

Jika ada kendala, periksa:
1. Laravel logs: `storage/logs/laravel.log`
2. Browser console untuk error
3. Network tab untuk melihat request/response

---

**Selamat menggunakan API! 🎉**

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Preview Upload</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container" style="padding-top: 50px;">
        <div class="form-header">
            <a href="/keluarga/upload" class="back-link">< Kembali</a>
            <h2 class="text-green">PREVIEW DATA UPLOAD</h2>
        </div>

        <div class="table-container" style="margin-top: 30px;">
            <h3 style="text-align: center; margin-bottom: 20px; color: var(--primary-green);">Preview Data yang Akan Diimport</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No KK</th>
                        <th>Nama Kepala Keluarga</th>
                        <th>Kecamatan</th>
                        <th>Kabupaten</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>1234567890123456</td>
                        <td>CONTOH NAMA</td>
                        <td>TENGGARONG</td>
                        <td>Kutai Kartanegara</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px; justify-content: center;">
            <button class="btn btn-primary">Konfirmasi & Simpan</button>
            <a href="/keluarga/upload" class="btn btn-outline">Batal</a>
        </div>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>

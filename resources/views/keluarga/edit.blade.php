<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Data Keluarga</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container" style="padding-top: 30px;">
        <div class="form-header">
            <a href="/dashboard" class="back-link">< Kembali</a>
            <h2 class="text-green">EDIT DATA KELUARGA</h2>
        </div>

        <form>
            <div class="form-group">
                <label>No Kartu Keluarga</label>
                <input type="text" value="6402092839123">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>RT</label>
                    <input type="text" value="001">
                </div>
                <div class="form-group">
                    <label>RW</label>
                    <input type="text" value="005">
                </div>
                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" value="75511">
                </div>
            </div>
            
            <div style="margin-top: 30px; display: flex; flex-direction: column; gap: 10px;">
                <button type="button" onclick="openModal('modal-ubah')" class="btn btn-warning" style="justify-content: center;">
                    ✏️ Ubah Data
                </button>
                
                <button type="button" onclick="openModal('modal-hapus')" class="btn btn-danger" style="justify-content: center;">
                    🗑️ Hapus Data
                </button>
            </div>
        </form>
    </div>

    <div id="modal-ubah" class="modal-overlay">
        <div class="modal-box">
            <button class="close-btn" onclick="closeModal('modal-ubah')">X</button>
            <h3>Peringatan!</h3>
            <p style="margin: 20px 0; color: #ccc;">Apakah anda sudah yakin dengan data yang anda masukkan? Harap cek dengan seksama!</p>
            <div class="modal-actions">
                <button onclick="closeModal('modal-ubah')" class="btn btn-outline">Tidak</button>
                <button class="btn btn-primary">Yakin</button>
            </div>
        </div>
    </div>

    <div id="modal-hapus" class="modal-overlay">
        <div class="modal-box">
            <button class="close-btn" onclick="closeModal('modal-hapus')">X</button>
            <h3>Peringatan!</h3>
            <p style="margin: 20px 0; color: #ccc;">Apakah Anda Yakin ingin menghapus Data Keluarga ini?</p>
            <div class="modal-actions">
                <button onclick="closeModal('modal-hapus')" class="btn btn-outline">Tidak</button>
                <button class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
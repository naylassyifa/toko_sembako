<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

<div class="navbar">
    <h1>Tambah Barang</h1>
    <p>Input Data Barang Baru</p>
</div>

<div class="container">

<div class="form-box">
    <form method="POST" action="/tambah" enctype="multipart/form-data">
        @csrf

        <label>Nama Barang</label>
        <input type="text" name="nama_barang" required>

        <label>Kategori</label>
        <input type="text" name="kategori" required>

        <label>Harga Beli</label>
        <input type="number" name="harga_beli" required>

        <label>Harga Jual</label>
        <input type="number" name="harga_jual" required>

        <label>Stok</label>
        <input type="number" name="stok" required>

        <label>Satuan</label>
        <input type="text" name="satuan" required>

        <label>Gambar Produk</label>
        <input type="file" name="gambar" accept="image/*" class="input-file">
        <small style="color: #666; margin-top: 5px; display: block;">Format: JPG, PNG, GIF (Max. 5MB)</small>

        <button class="btn-save">Simpan</button>
    </form>
</div>

</div>

</body>
</html>
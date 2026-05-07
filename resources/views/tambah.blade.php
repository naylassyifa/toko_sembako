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
    <form method="POST" action="/tambah">
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

        <button class="btn-save">Simpan</button>
    </form>
</div>

</div>

</body>
</html>
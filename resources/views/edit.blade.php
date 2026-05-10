<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

<div class="navbar">
    <h1>Edit Barang</h1>
    <p>Update Data Barang</p>
</div>

<div class="container">

<div class="form-box">
    <form method="POST" action="/edit" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id" value="{{ $row->id_barang }}">

        <label>Nama Barang</label>
        <input name="nama_barang" value="{{ $row->nama_barang }}">

        <label>Kategori</label>
        <input name="kategori" value="{{ $row->kategori }}">

        <label>Harga Beli</label>
        <input type="number" name="harga_beli" value="{{ $row->harga_beli }}">

        <label>Harga Jual</label>
        <input type="number" name="harga_jual" value="{{ $row->harga_jual }}">

        <label>Stok</label>
        <input type="number" name="stok" value="{{ $row->stok }}">

        <label>Satuan</label>
        <input name="satuan" value="{{ $row->satuan }}">

        <label>Gambar Produk</label>
        @if($row->gambar && file_exists(public_path($row->gambar)))
            <div style="margin-bottom: 15px;">
                <img src="{{ asset($row->gambar) }}" alt="{{ $row->nama_barang }}" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                <p style="margin-top: 10px; color: #666; font-size: 13px;">Gambar saat ini</p>
            </div>
        @endif
        <input type="file" name="gambar" accept="image/*" class="input-file">
        <small style="color: #666; margin-top: 5px; display: block;">Biarkan kosong jika tidak ingin mengubah gambar</small>

        <button class="btn-save">Update</button>
    </form>
</div>

</div>

</body>
</html>
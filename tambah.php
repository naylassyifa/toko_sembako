<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
</head>
<body>

<h2>Tambah Barang</h2>

<form method="POST" action="">
    Nama Barang: <br>
    <input type="text" name="nama_barang" required><br><br>

    Kategori: <br>
    <input type="text" name="kategori" required><br><br>

    Harga Beli: <br>
    <input type="number" name="harga_beli" required><br><br>

    Harga Jual: <br>
    <input type="number" name="harga_jual" required><br><br>

    Stok: <br>
    <input type="number" name="stok" required><br><br>

    Satuan: <br>
    <input type="text" name="satuan" required><br><br>

    <button type="submit" name="submit">Simpan</button>

<?php
include 'koneksi.php';

if(isset($_POST['submit'])){
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $hb = $_POST['harga_beli'];
    $hj = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    mysqli_query($conn, "INSERT INTO barang 
    VALUES (NULL, '$nama', '$kategori', '$hb', '$hj', '$stok', '$satuan')");

    header("Location: index.php?pesan=berhasil");
    exit;
}
?>
</form>

</body>
</html>
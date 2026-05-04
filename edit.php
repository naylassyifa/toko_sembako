<?php
include 'koneksi.php';

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $hb = $_POST['harga_beli'];
    $hj = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    mysqli_query($conn, "UPDATE barang SET 
        nama_barang='$nama',
        kategori='$kategori',
        harga_beli='$hb',
        harga_jual='$hj',
        stok='$stok',
        satuan='$satuan'
        WHERE id_barang='$id'
    ");

    header("Location: index.php?pesan=update");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM barang WHERE id_barang='$id'");
$row = mysqli_fetch_assoc($data);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
</head>
<body>

<h2>Edit Barang</h2>

<form method="POST">
    <input type="hidden" name="id" value="<?= $row['id_barang']; ?>">

    Nama Barang: <br>
    <input type="text" name="nama_barang" value="<?= $row['nama_barang']; ?>"><br><br>

    Kategori: <br>
    <input type="text" name="kategori" value="<?= $row['kategori']; ?>"><br><br>

    Harga Beli: <br>
    <input type="number" name="harga_beli" value="<?= $row['harga_beli']; ?>"><br><br>

    Harga Jual: <br>
    <input type="number" name="harga_jual" value="<?= $row['harga_jual']; ?>"><br><br>

    Stok: <br>
    <input type="number" name="stok" value="<?= $row['stok']; ?>"><br><br>

    Satuan: <br>
    <input type="text" name="satuan" value="<?= $row['satuan']; ?>"><br><br>

    <button type="submit" name="update">Update</button>
</form>

</body>
</html>
<?php
session_start();

if(!isset($_SESSION['login'])){
    header("location:login.php");
    exit;
}
?>
<?php
session_start();

if(!isset($_SESSION['login'])){
    header("location:login.php");
}
include 'koneksi.php';

if(isset($_GET['cari'])){
    $cari = $_GET['cari'];
    $data = mysqli_query($conn, "SELECT * FROM barang WHERE nama_barang LIKE '%$cari%'");
} else {
    $data = mysqli_query($conn, "SELECT * FROM barang");
}

$total_barang = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM barang"));
$total_stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(stok) as total FROM barang"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="navbar">
    <h1>Toko Sembako</h1>
    <p>Manajemen Data Barang</p>
</div>

<div class="container">

<div style="margin-bottom:10px;">
    👤 Login sebagai: <?= isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest'; ?>

    <a href="logout.php" 
       style="float:right; 
              background:#d63031; 
              color:white; 
              padding:8px 12px; 
              border-radius:5px; 
              text-decoration:none;">
       Logout
    </a>
</div>

<h2>Data Barang</h2>

<!-- NOTIF -->
<?php if(isset($_GET['pesan'])){ ?>
    <div class="alert 
        <?php 
            if($_GET['pesan']=="berhasil") echo "success";
            elseif($_GET['pesan']=="update") echo "info";
            elseif($_GET['pesan']=="hapus") echo "danger";
        ?>">
        <?php 
            if($_GET['pesan']=="berhasil") echo "Data berhasil ditambahkan!";
            elseif($_GET['pesan']=="update") echo "Data berhasil diupdate!";
            elseif($_GET['pesan']=="hapus") echo "Data berhasil dihapus!";
        ?>
    </div>
<?php } ?>

<!-- NOTIF DATA KOSONG -->
<?php 
if(isset($_GET['cari']) && mysqli_num_rows($data) == 0){ ?>
    <div class="alert danger">
        Barang tidak ditemukan!
    </div>
<?php } ?>

<!-- HASIL SEARCH -->
<?php if(isset($_GET['cari'])){ ?>
    <p>Hasil pencarian: <b><?= $_GET['cari']; ?></b></p>
<?php } ?>

<form method="GET" class="search-box">
    <input type="text" name="cari" placeholder="Cari barang..." 
    value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">

    <button type="submit">Cari</button>

    <?php if(isset($_GET['cari'])){ ?>
        <a href="index.php" class="back">← Kembali</a>
    <?php } ?>
</form>

<br>

<div class="dashboard">
    <div class="card">
        <h3>Total Barang</h3>
        <p><?= $total_barang; ?></p>
    </div>

    <div class="card">
        <h3>Total Stok</h3>
        <p><?= $total_stok ? $total_stok : 0; ?></p>
    </div>
</div>

<!-- TABLE BOX -->
<div class="table-box">
<table>
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Harga Beli</th>
        <th>Harga Jual</th>
        <th>Stok</th>
        <th>Satuan</th>
        <th>Aksi</th>
    </tr>

<?php
$no = 1;

if(mysqli_num_rows($data) > 0){
    while($row = mysqli_fetch_assoc($data)){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $row['nama_barang']; ?></td>
    <td><?= $row['kategori']; ?></td>
    <td>Rp <?= number_format($row['harga_beli'],0,',','.'); ?></td>
    <td>Rp <?= number_format($row['harga_jual'],0,',','.'); ?></td>
    <td><?= $row['stok']; ?></td>
    <td><?= $row['satuan']; ?></td>
    <td>
        <a class="btn-edit" href="edit.php?id=<?= $row['id_barang']; ?>">Edit</a>
        <a class="btn-hapus" href="hapus.php?id=<?= $row['id_barang']; ?>" 
        onclick="return confirm('Yakin mau hapus data ini?')">
        Hapus
        </a>
    </td>
</tr>
<?php 
    }
} else {
?>
<tr>
    <td colspan="8">Barang tidak ditemukan</td>
</tr>
<?php } ?>

</table>
</div>

<br>

<div class="tombol-tengah">
    <a href="tambah.php">➕ Tambah Barang</a>
</div>

</div>

<footer>
    <p>© 2026 Toko Sembako</p>
</footer>

<script>
setTimeout(function(){
    let alertBox = document.querySelector('.alert');
    if(alertBox){
        alertBox.style.display = 'none';
    }
}, 3000);
</script>

</body>
</html>
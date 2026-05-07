<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

<div class="navbar">
    <h1>Toko Sembako</h1>
    <p>Manajemen Data Barang</p>
</div>

<div class="container">

    <!-- TOP BAR -->
    <div class="top-bar">
        <div>
            👤 Login sebagai: {{ session('user') }}
        </div>
        <a href="/logout" class="btn-hapus">Logout</a>
    </div>

    <h2>Data Barang</h2>

    <!-- SEARCH -->
    <form method="GET" class="search-box">
        <input type="text" name="cari" placeholder="Cari barang...">
        <button type="submit">Cari</button>
    </form>

    <!-- DASHBOARD -->
    <div class="dashboard">
        <div class="card">
            <h3>Total Barang</h3>
            <p>{{ $total_barang }}</p>
        </div>

        <div class="card">
            <h3>Total Stok</h3>
            <p>{{ $total_stok }}</p>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-box">
        <table>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>

            @foreach($data as $index => $row)
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $row->nama_barang }}</td>
                <td>{{ $row->kategori }}</td>
                <td>Rp {{ number_format($row->harga_jual,0,',','.') }}</td>
                <td>{{ $row->stok }}</td>
                <td>
                    <a class="btn-edit" href="/edit/{{ $row->id_barang }}">Edit</a>
                    <a class="btn-hapus" href="/hapus/{{ $row->id_barang }}">Hapus</a>
                </td>
            </tr>
            @endforeach

        </table>
    </div>

    <!-- BUTTON TAMBAH -->
    <div class="tombol-tengah">
        <a href="/tambah">+ Tambah Barang</a>
    </div>

</div>

</body>
</html>
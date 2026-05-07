<!DOCTYPE html>
<html>
<head>
    <title>Toko Sembako</title>
    <style>
        body{
            font-family: Arial;
            background:#f1f5f9;
        }
        .container{
            width:80%;
            margin:auto;
        }
        h2{
            text-align:center;
        }
        .card{
            background:white;
            padding:20px;
            margin:10px 0;
            border-radius:10px;
            box-shadow:0 2px 5px rgba(0,0,0,0.1);
        }
        .btn{
            padding:5px 10px;
            text-decoration:none;
            border-radius:5px;
            color:white;
        }
        .edit{ background:orange; }
        .hapus{ background:red; }
        .tambah{ background:green; display:inline-block; margin:10px 0; }
    </style>
</head>
<body>

<div class="container">

<h2>Data Barang</h2>

<a href="/barang/create" class="btn tambah">+ Tambah</a>

@foreach($data as $b)
<div class="card">
    <b>{{ $b->nama_barang }}</b><br>
    Stok: {{ $b->stok }}<br>
    Harga: Rp {{ number_format($b->harga_jual) }}<br><br>

    <a href="/barang/edit/{{ $b->id_barang }}" class="btn edit">Edit</a>
    <a href="/barang/delete/{{ $b->id_barang }}" class="btn hapus">Hapus</a>
</div>
@endforeach

</div>

</body>
</html>
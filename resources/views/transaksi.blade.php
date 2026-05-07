<!DOCTYPE html>
<html>
<head>
    <title>Transaksi</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>

<div class="navbar">
    <h1>Kasir</h1>
    <p>Halaman Transaksi</p>
</div>

<div class="container">

<h2>Pilih Barang</h2>

<div class="dashboard">
@foreach($barang as $b)
    <div class="card">
        <h4>{{ $b->nama_barang }}</h4>
        <p>Rp {{ number_format($b->harga_jual) }}</p>

        <form method="POST" action="/transaksi/tambah">
            @csrf
            <input type="hidden" name="id" value="{{ $b->id_barang }}">
            <button>+ Tambah</button>
        </form>
    </div>
@endforeach
</div>

<hr>

<h2>Keranjang</h2>

<table>
<tr>
<th>Nama</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
<th>Aksi</th>
</tr>

@php $total = 0; @endphp

@foreach($cart as $id => $item)
@php $sub = $item['harga'] * $item['qty']; $total += $sub; @endphp

<tr>
<td>{{ $item['nama'] }}</td>
<td>{{ $item['harga'] }}</td>
<td>{{ $item['qty'] }}</td>
<td>{{ $sub }}</td>
<td>
<form method="POST" action="/transaksi/hapus">
@csrf
<input type="hidden" name="id" value="{{ $id }}">
<button>Hapus</button>
</form>
</td>
</tr>
@endforeach

</table>

<h3>Total: Rp {{ number_format($total) }}</h3>

<form method="POST" action="/transaksi/checkout">
@csrf
<button style="background:green;color:white;padding:10px;">
Checkout
</button>
</form>

</div>

</body>
</html>
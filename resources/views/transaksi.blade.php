<!DOCTYPE html>
<html>
<head>
    <title>Kasir</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

<div class="navbar">
    <h1>Kasir</h1>
    <p>Halaman Transaksi</p>
</div>

<div class="container">

    <h2 class="judul-section">Pilih Barang</h2>

    <div class="produk-grid">

        @foreach($barang as $row)

        <div class="produk-card">

            <div class="produk-info">

                <h3>{{ $row->nama_barang }}</h3>

                <p class="harga">
                    Rp {{ number_format($row->harga_jual,0,',','.') }}
                </p>

                <span class="stok">
                    Stok: {{ $row->stok }}
                </span>

            </div>

            <!-- BUTTON TAMBAH -->
            <form action="/tambah-keranjang/{{ $row->id_barang }}" method="POST">
                @csrf

                <button type="submit" class="btn-tambah">
                    + Tambah
                </button>
            </form>

        </div>

        @endforeach

    </div>

    <!-- KERANJANG -->
    <div class="keranjang-box">

        <h2 class="judul-section">Keranjang</h2>

        <table>

            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>

            @php $total = 0; @endphp

            @foreach($keranjang as $item)

            @php
                $subtotal = $item['harga'] * $item['qty'];
                $total += $subtotal;
            @endphp

            <tr>

                <td>{{ $item['nama'] }}</td>

                <td>
                    Rp {{ number_format($item['harga'],0,',','.') }}
                </td>

                <td>{{ $item['qty'] }}</td>

                <td>
                    Rp {{ number_format($subtotal,0,',','.') }}
                </td>

                <td>

                    <!-- BUTTON HAPUS -->
                    <a href="/hapus-keranjang/{{ $item['id'] }}"
                    class="btn-hapus">
                        Hapus
                    </a>

                </td>

            </tr>

            @endforeach

        </table>

        <!-- CHECKOUT -->
        <div class="checkout-box">

            <h2>
                Total:
                Rp {{ number_format($total,0,',','.') }}
            </h2>

            <form action="/checkout" method="POST">
                @csrf

                <button type="submit" class="btn-checkout">
                    Checkout
                </button>
            </form>

        </div>

    </div>

</div>

</body>
</html>
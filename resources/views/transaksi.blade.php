<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Transaksi</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

<div class="navbar">
    <h1>🛍️ Sistem Kasir</h1>
    <p>Halaman Transaksi & Checkout</p>
</div>

<div class="container">

    <!-- ALERTS -->
    @if(session('success'))
        <div class="notification notification-success show">
            <div class="notification-content">
                <span class="notification-icon">✅</span>
                <div class="notification-text">
                    <h4>Berhasil!</h4>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif

    @if(session('error'))
        <div class="notification notification-danger show">
            <div class="notification-content">
                <span class="notification-icon">❌</span>
                <div class="notification-text">
                    <h4>Error!</h4>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif

    <!-- TOP BAR TRANSAKSI -->
    <div class="transaksi-top-bar">
        <div class="transaksi-title">
            <h2>📦 Pilih Barang</h2>
            <p>Klik "+ Tambah" untuk menambahkan barang ke keranjang</p>
        </div>
        <a href="/" class="btn-back">← Kembali ke Inventory</a>
    </div>

    <!-- PRODUK GRID -->
    <div class="produk-grid-transaksi">

        @forelse($barang as $row)

        <div class="produk-card-transaksi">

            <div class="produk-image-section">
                @if($row->gambar && file_exists(public_path($row->gambar)))
                    <img src="{{ asset($row->gambar) }}" alt="{{ $row->nama_barang }}" class="produk-image">
                @else
                    <div class="produk-image-placeholder">📦</div>
                @endif
                
                @if($row->stok <= 0)
                    <div class="stock-out-badge">Stok Habis</div>
                @elseif($row->stok < 5)
                    <div class="stock-warning-badge">Stok Terbatas</div>
                @endif
            </div>

            <div class="produk-info-transaksi">

                <h3 class="produk-nama">{{ $row->nama_barang }}</h3>

                <div class="produk-meta-transaksi">
                    <span class="kategori-tag">{{ $row->kategori }}</span>
                    <span class="stok-info">Stok: <strong>{{ $row->stok }}</strong></span>
                </div>

                <p class="harga-produk">
                    Rp {{ number_format($row->harga_jual, 0, ',', '.') }}
                </p>

            </div>

            <!-- BUTTON TAMBAH -->
            @if($row->stok > 0)
                <form action="/tambah-keranjang/{{ $row->id_barang }}" method="POST" class="form-tambah">
                    @csrf
                    <button type="submit" class="btn-tambah-produk">
                        + Tambah
                    </button>
                </form>
            @else
                <button type="button" class="btn-tambah-produk disabled" disabled>
                    Stok Habis
                </button>
            @endif

        </div>

        @empty

        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;">
            <h3>📭 Tidak ada barang tersedia</h3>
            <p>Silakan tambahkan barang dari <a href="/" style="color: #3b82f6;">halaman inventory</a></p>
        </div>

        @endforelse

    </div>

    <!-- KERANJANG SECTION -->
    <div class="keranjang-section">

        <div class="keranjang-header">
            <h2>🛒 Keranjang Belanja</h2>
            <span class="item-count">{{ count($keranjang) }} Item</span>
        </div>

        @if(count($keranjang) > 0)

            <div class="keranjang-table-wrapper">
                <table class="keranjang-table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $total = 0; $total_items = 0; @endphp

                        @foreach($keranjang as $item)

                        @php
                            $subtotal = $item['harga'] * $item['qty'];
                            $total += $subtotal;
                            $total_items += $item['qty'];
                        @endphp

                        <tr class="keranjang-row">

                            <td class="nama-cell">
                                <span class="item-icon">📦</span>
                                {{ $item['nama'] }}
                            </td>

                            <td class="harga-cell">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </td>

                            <td class="qty-cell">
                                <span class="qty-badge">{{ $item['qty'] }}</span>
                            </td>

                            <td class="subtotal-cell">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </td>

                            <td class="aksi-cell">
                                <a href="/hapus-keranjang/{{ $item['id'] }}" class="btn-hapus-keranjang">
                                    🗑️ Hapus
                                </a>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>

            <!-- CHECKOUT SECTION -->
            <div class="checkout-section">

                <div class="checkout-stats">
                    <div class="stat-item">
                        <span class="stat-label">Total Item:</span>
                        <span class="stat-value">{{ $total_items }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Total Harga:</span>
                        <span class="stat-value total-price">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form action="/checkout" method="POST" class="checkout-form">
                    @csrf

                    <button type="submit" class="btn-checkout-large">
                        ✓ Checkout & Selesaikan Transaksi
                    </button>
                </form>

            </div>

        @else

            <div class="keranjang-kosong">
                <div class="empty-icon">🛒</div>
                <h3>Keranjang Masih Kosong</h3>
                <p>Tambahkan barang dari daftar di atas untuk memulai transaksi</p>
            </div>

        @endif

    </div>

</div>

<script>
    // Auto-hide notifications after 5 seconds
    document.querySelectorAll('.notification.show').forEach(notif => {
        setTimeout(() => {
            notif.classList.remove('show');
            setTimeout(() => notif.remove(), 300);
        }, 5000);
    });
</script>

</body>
</html>
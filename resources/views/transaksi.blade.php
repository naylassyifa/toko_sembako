<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Transaksi</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="{{ asset('extra-transaksi.css') }}">
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
                                    <span class="hapus-icon">🗑️</span>
                                    <span class="hapus-text">Hapus</span>
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

                <button
                    type="button"
                    class="btn-checkout-large"
                    onclick="showCheckoutModal()"
                >
                    ✓ Checkout & Selesaikan Transaksi
                </button>

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





<!-- CHECKOUT CONFIRMATION MODAL -->
<div id="checkoutModal" class="modal modal-checkout">
    <div class="modal-content">

        <div class="modal-header">
            <h2>🧾 Konfirmasi Checkout</h2>
        </div>

        <div class="modal-body">

            <div class="checkout-warning">
                📋 Periksa kembali daftar barang sebelum menyelesaikan transaksi
            </div>

            <!-- TABEL BARANG -->
            <div class="checkout-item-table-wrapper">
                <table class="checkout-item-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="checkoutItemList">
                        <!-- diisi oleh JS -->
                    </tbody>
                </table>
            </div>

            <!-- RINGKASAN TOTAL -->
            <div class="checkout-summary">
                <div class="summary-row">
                    <span class="summary-label">Total Item:</span>
                    <span class="summary-value" id="checkoutItems">-</span>
                </div>
                <div class="summary-row summary-total">
                    <span class="summary-label">💰 Total Harga:</span>
                    <span class="summary-value" id="checkoutPrice">Rp 0</span>
                </div>
            </div>

            <div class="checkout-info-note">
                ✓ Stok akan berkurang otomatis setelah transaksi diselesaikan
            </div>

        </div>

        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeCheckoutModal()">✕ Kembali</button>
            <button class="btn-confirm-checkout" onclick="confirmCheckout()">✓ Selesaikan Transaksi</button>
        </div>

    </div>
</div>

<!-- SEMUA SCRIPT DI SINI — setelah modal HTML agar getElementById tidak null -->
<script>
    // ── Data dari server ──────────────────────────────────────────
    @php
        $keranjang_js   = [];
        $total_js       = 0;
        $total_items_js = 0;
        foreach(session('cart', []) as $item) {
            $sub             = $item['harga'] * $item['qty'];
            $total_js       += $sub;
            $total_items_js += $item['qty'];
            $keranjang_js[]  = [
                'nama'     => $item['nama'],
                'qty'      => (int) $item['qty'],
                'harga'    => (int) $item['harga'],
                'subtotal' => (int) $sub,
            ];
        }
    @endphp
    const _keranjangData = {!! json_encode($keranjang_js, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
    const _totalHarga    = {{ (int) $total_js }};
    const _totalItems    = {{ (int) $total_items_js }};

    // ── Helpers ───────────────────────────────────────────────────
    function formatRupiah(angka) {
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    // ── Auto-hide notifications ───────────────────────────────────
    document.querySelectorAll('.notification.show').forEach(function(notif) {
        setTimeout(function() {
            notif.classList.remove('show');
            setTimeout(function() { notif.remove(); }, 300);
        }, 5000);
    });

    // ── Checkout modal ────────────────────────────────────────────
    function showCheckoutModal() {
        var modal        = document.getElementById('checkoutModal');
        var itemsDisplay = document.getElementById('checkoutItems');
        var priceDisplay = document.getElementById('checkoutPrice');
        var itemListBody = document.getElementById('checkoutItemList');

        if (!modal) { console.error('Modal tidak ditemukan'); return; }

        itemsDisplay.textContent = _totalItems + ' item';
        priceDisplay.textContent = formatRupiah(_totalHarga);

        // Render baris barang
        itemListBody.innerHTML = '';
        _keranjangData.forEach(function(item, index) {
            var tr = document.createElement('tr');
            tr.className = 'modal-item-row';
            tr.innerHTML =
                '<td class="modal-item-no">' + (index + 1) + '</td>' +
                '<td class="modal-item-nama"><span class="modal-item-icon">📦</span> ' + item.nama + '</td>' +
                '<td class="modal-item-qty"><span class="modal-qty-badge">' + item.qty + 'x</span></td>' +
                '<td class="modal-item-harga">' + formatRupiah(item.harga) + '</td>' +
                '<td class="modal-item-subtotal">' + formatRupiah(item.subtotal) + '</td>';
            itemListBody.appendChild(tr);
        });

        modal.classList.add('show');
    }

    function closeCheckoutModal() {
        var modal = document.getElementById('checkoutModal');
        if (modal) modal.classList.remove('show');
    }

    function confirmCheckout() {
        var form       = document.createElement('form');
        form.method    = 'POST';
        form.action    = '/checkout';
        var csrf       = document.createElement('input');
        csrf.type      = 'hidden';
        csrf.name      = '_token';
        csrf.value     = '{{ csrf_token() }}';
        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }

    // Tutup modal kalau klik di luar area konten
    document.getElementById('checkoutModal').addEventListener('click', function(e) {
        if (e.target === this) closeCheckoutModal();
    });
</script>

</body>
</html>

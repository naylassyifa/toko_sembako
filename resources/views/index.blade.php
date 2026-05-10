<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

<div class="navbar">
    <h1>📦 Toko Sembako</h1>
    <p>Manajemen Data Barang & Inventory</p>
</div>

<div class="container">

    <!-- NOTIFICATIONS -->
    @if(request('pesan') == 'berhasil')
        <div class="notification notification-success show">
            <div class="notification-content">
                <span class="notification-icon">✅</span>
                <div class="notification-text">
                    <h4>Produk Ditambahkan!</h4>
                    <p>Barang baru telah berhasil ditambahkan ke sistem.</p>
                </div>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">✕</button>
        </div>
    @elseif(request('pesan') == 'update')
        <div class="notification notification-info show">
            <div class="notification-content">
                <span class="notification-icon">📝</span>
                <div class="notification-text">
                    <h4>Produk Diperbarui!</h4>
                    <p>Data produk telah berhasil diperbarui.</p>
                </div>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">✕</button>
        </div>
    @elseif(request('pesan') == 'hapus')
        <div class="notification notification-danger show">
            <div class="notification-content">
                <span class="notification-icon">🗑️</span>
                <div class="notification-text">
                    <h4>Produk Dihapus!</h4>
                    <p>Barang telah berhasil dihapus dari sistem.</p>
                </div>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif

    <!-- TOP BAR -->
    <div class="top-bar">
        <div style="display: flex; align-items: center; gap: 10px;">
            👤 <strong>{{ session('user') }}</strong>
        </div>
        <a href="/logout" class="btn-logout">Logout</a>
    </div>

    <!-- DASHBOARD STATS -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <p class="stat-label">Total Barang</p>
                <h3 class="stat-value">{{ $total_barang }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-content">
                <p class="stat-label">Total Stok</p>
                <h3 class="stat-value">{{ $total_stok }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-content">
                <p class="stat-label">Nilai Stok</p>
                <h3 class="stat-value">Rp {{ number_format($data->sum(fn($item) => $item->stok * $item->harga_jual), 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- SEARCH & ADD BUTTON -->
    <div class="search-section">
        <form method="GET" class="search-box-new">
            <div class="search-input-wrapper">
                <span class="search-icon-left">🔍</span>
                <input 
                    type="text" 
                    name="cari" 
                    placeholder="Cari nama barang, kategori..." 
                    value="{{ request('cari') }}"
                    class="search-input-main"
                >
                <button type="submit" class="search-btn">Cari</button>
            </div>
        </form>
        <div class="action-buttons">
            <a href="/tambah" class="btn-tambah">➕ Tambah Barang</a>
            <a href="/transaksi" class="btn-transaksi">🛒 Ke Kasir</a>
        </div>
    </div>

    <!-- PRODUCTS GRID -->
    <div class="products-grid">
        @forelse($data as $index => $row)
        <div class="product-card">
            <div class="product-image-wrapper">
                @if($row->gambar && file_exists(public_path($row->gambar)))
                    <img src="{{ asset($row->gambar) }}" alt="{{ $row->nama_barang }}" class="product-image">
                @else
                    <div class="product-image-placeholder">
                        📦<br>Tidak ada gambar
                    </div>
                @endif
                <div class="stock-badge {{ $row->stok > 10 ? 'stock-ok' : ($row->stok > 0 ? 'stock-warning' : 'stock-empty') }}">
                    Stok: {{ $row->stok }}
                </div>
            </div>

            <div class="product-info">
                <h3 class="product-name">{{ $row->nama_barang }}</h3>
                
                <div class="product-meta">
                    <span class="category-badge">{{ $row->kategori }}</span>
                    <span class="unit-badge">{{ $row->satuan }}</span>
                </div>

                <div class="product-prices">
                    <div class="price-row">
                        <span class="price-label">Beli</span>
                        <span class="price-value">Rp {{ number_format($row->harga_beli, 0, ',', '.') }}</span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Jual</span>
                        <span class="price-sell">Rp {{ number_format($row->harga_jual, 0, ',', '.') }}</span>
                    </div>
                    <div class="price-row">
                        <span class="price-label">Margin</span>
                        <span class="price-margin">{{ round((($row->harga_jual - $row->harga_beli) / $row->harga_beli) * 100, 1) }}%</span>
                    </div>
                </div>

                <div class="product-actions">
                    <a class="btn-edit" href="/edit/{{ $row->id_barang }}">✏️ Edit</a>
                    <a class="btn-hapus" href="#" onclick="showDeleteModal('{{ $row->id_barang }}', '{{ $row->nama_barang }}'); return false;">🗑️ Hapus</a>
                    <a class="btn-buy" href="/beli-sekarang/{{ $row->id_barang }}">🛍️ Beli</a>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #999;">
            <h3>Tidak ada barang ditemukan</h3>
            <p>Mulai dengan <a href="/tambah" style="color: #3b82f6; text-decoration: none;">menambah barang baru</a></p>
        </div>
        @endforelse
    </div>

</div>

<!-- DELETE CONFIRMATION MODAL -->
<div id="deleteModal" class="modal">
    <div class="modal-content modal-danger">
        <div class="modal-header">
            <h2>⚠️ Konfirmasi Hapus</h2>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus produk <strong id="productName"></strong>?</p>
            <p class="warning-text">Tindakan ini tidak dapat dibatalkan!</p>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <button class="btn-confirm-delete" onclick="confirmDelete()">Ya, Hapus Produk</button>
        </div>
    </div>
</div>

<script>
    let deleteId = null;

    function showDeleteModal(id, name) {
        deleteId = id;
        document.getElementById('productName').textContent = name;
        document.getElementById('deleteModal').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');
        deleteId = null;
    }

    function confirmDelete() {
        if(deleteId) {
            window.location.href = '/hapus/' + deleteId;
        }
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if(e.target === this) {
            closeDeleteModal();
        }
    });

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
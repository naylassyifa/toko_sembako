<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Sembako Mataram</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body class="login-page">

    <div class="login-container">
        <!-- LEFT SIDE - BRANDING -->
        <div class="login-branding">
            <div class="branding-content">
                <div class="logo-circle">
                    🛒
                </div>
                <h1>Toko Sembako</h1>
                <p class="tagline">Mataram</p>
                <p class="subtitle">Sistem Manajemen Inventory & Penjualan</p>
                
                <div class="features-list">
                    <div class="feature-item">
                        <span class="feature-icon">📦</span>
                        <span>Kelola Inventory</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">💰</span>
                        <span>Kelola Penjualan</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon">📊</span>
                        <span>Dashboard Analitik</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE - LOGIN FORM -->
        <div class="login-form-wrapper">
            <div class="login-card">
                <h2 class="login-title">Masuk Akun Admin</h2>
                <p class="login-subtitle">Kelola toko sembako Anda dengan mudah</p>

                @if($errors->has('login'))
                    <div class="alert alert-error">
                        <span class="alert-icon">❌</span>
                        <span>Username atau password salah!</span>
                    </div>
                @endif

                <form method="POST" action="/login" class="login-form">
                    @csrf

                    <div class="input-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <span class="input-icon">👤</span>
                            <input 
                                type="text" 
                                id="username"
                                name="username" 
                                placeholder="Masukkan username"
                                required
                                autofocus
                            >
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <span class="input-icon">🔒</span>
                            <input 
                                type="password" 
                                id="password"
                                name="password" 
                                placeholder="Masukkan password"
                                required
                            >
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        <span class="btn-icon">🚀</span>
                        <span>Masuk Sekarang</span>
                    </button>
                </form>

                <div class="login-footer">
                    <p class="hint">💡 Demo Username: admin | Password: admin</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
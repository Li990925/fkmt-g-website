<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | FKMT-G</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="/assets/images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #f8fafc;
        }

        .login-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left Side - Branding/Image */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1528459801416-a9e53bbf4e17?auto=format&fit=crop&q=80&w=1000') center/cover;
            opacity: 0.15;
            mix-blend-mode: overlay;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 400px;
        }

        .brand-logo {
            width: 110px;
            height: 110px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            padding: 8px;
        }

        .brand-logo i {
            font-size: 3rem;
            color: #059669;
        }

        .brand-title {
            font-size: 2.25rem;
            font-weight: 700;
            margin: 0 0 1rem;
            letter-spacing: -0.5px;
            white-space: nowrap;
        }

        .brand-subtitle {
            font-size: 1.1rem;
            font-weight: 300;
            opacity: 0.9;
            line-height: 1.6;
            padding: 0 1rem;
        }

        /* Right Side - Login Form */
        .login-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            padding: 2rem;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            padding: 2.5rem;
        }

        .login-header {
            margin-bottom: 2.5rem;
        }

        .login-header h2 {
            font-size: 2.25rem;
            color: #1e293b;
            margin: 0 0 0.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .login-header p {
            color: #64748b;
            margin: 0;
            font-size: 1.05rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 600;
            color: #334155;
            font-size: 0.95rem;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: color 0.3s ease;
        }

        .form-group input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1.05rem;
            font-family: inherit;
            box-sizing: border-box;
            background: #f8fafc;
            color: #334155;
            transition: all 0.3s ease;
        }

        /* Menghilangkan background kuning bawaan browser saat autofill */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #f8fafc inset !important;
            -webkit-text-fill-color: #334155 !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #059669;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        /* Saat autofill aktif dan di-focus */
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 30px #ffffff inset !important;
        }

        .form-group input:focus + i,
        .form-group input:focus ~ i {
            color: #059669;
        }

        .btn-login {
            width: 100%;
            padding: 1.1rem;
            background-color: #059669;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.6rem;
            letter-spacing: 0.5px;
        }

        .btn-login:hover {
            background-color: #047857;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.2);
        }

        .error-msg {
            color: #ef4444;
            background-color: #fef2f2;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border-left: 4px solid #ef4444;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
            color: #64748b;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #059669;
        }

        /* Loading Overlay Styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .loading-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .loader-container {
            text-align: center;
            color: #059669;
            transform: translateY(20px);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .loading-overlay.active .loader-container {
            transform: translateY(0);
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #e2e8f0;
            border-top-color: #059669;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 1.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loader-text {
            font-size: 1.25rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin: 0;
        }
        
        .loader-subtext {
            font-size: 0.9rem;
            color: #64748b;
            margin-top: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-left {
                display: none;
            }
            .login-right {
                padding: 1.5rem;
            }
            .login-card {
                background: white;
                padding: 2.5rem 1.5rem;
                border-radius: 16px;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            }
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loader-container">
            <div class="spinner"></div>
            <p class="loader-text">Mengautentikasi...</p>
            <p class="loader-subtext">Mempersiapkan panel admin Anda</p>
        </div>
    </div>

    <div class="login-container">
        <!-- Left Side -->
        <div class="login-left">
            <div class="brand-content">
                <div class="brand-logo">
                    <img src="/assets/images/logo.png" alt="Logo FKMT-G" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <h1 class="brand-title">Panel Admin FKMT-G</h1>
                <p class="brand-subtitle">Kelola konten website, anggota, dan informasi kegiatan dengan mudah dan cepat.</p>
            </div>
        </div>

        <!-- Right Side -->
        <div class="login-right">
            <div class="login-card">
                <div class="login-header">
                    <h2>Selamat Datang!</h2>
                    <p>Silakan masuk ke akun Anda</p>
                </div>
                
                <?php if (!empty($error)): ?>
                    <div class="error-msg">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <form action="/login" method="POST" id="loginForm">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <input type="text" id="username" name="username" required autofocus placeholder="Masukkan username admin">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" required placeholder="Masukkan password">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        Masuk 
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
                
                <a href="/" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah submit langsung
            
            const form = this;
            const btn = form.querySelector('.btn-login');
            
            // Ubah state tombol
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memproses...';
            btn.style.opacity = '0.8';
            btn.style.cursor = 'wait';
            
            // Tampilkan animasi loading full-screen
            document.getElementById('loadingOverlay').classList.add('active');
            
            // Beri waktu 1.5 detik agar animasi terlihat, lalu submit form
            setTimeout(function() {
                form.submit();
            }, 1500);
        });
    </script>
</body>
</html>

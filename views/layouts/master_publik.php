<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= !empty($title) ? htmlspecialchars($title) : 'FKMT-G | Forum Komunikasi Mahasiswa Toili-Gorontalo' ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Website Resmi Forum Komunikasi Mahasiswa Toili-Gorontalo (FKMT-G). Wadah silaturahmi, informasi kegiatan, kepengurusan, dan kebersamaan mahasiswa Toili di Gorontalo.">
    <meta name="keywords" content="FKMT-G, Forum Komunikasi Mahasiswa Toili Gorontalo, FKMT, Toili, Gorontalo, Paguyuban Toili, Organisasi Daerah Mahasiswa">
    <meta name="author" content="FKMT-G">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="http://fkmt-g.ifree.page<?= htmlspecialchars($currentUri ?? '') ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="FKMT-G">
    <meta property="og:title" content="<?= !empty($title) ? htmlspecialchars($title) : 'FKMT-G | Forum Komunikasi Mahasiswa Toili-Gorontalo' ?>">
    <meta property="og:description" content="Wadah silaturahmi mahasiswa Toili di Gorontalo. Bersama merawat persaudaraan dan membangun daerah.">
    
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/logo.png">
    <link rel="apple-touch-icon" href="/assets/images/logo.png">
    <!-- Android & PWA Meta Tags -->
    <meta name="theme-color" content="#059669">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="FKMT-G">
    <link rel="manifest" href="/manifest.json">

    <!-- Custom Stylesheet with Cache Busting -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= @filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/css/style.css') ?: '20261012' ?>">

    <!-- Critical CSS: Mencegah SVG Meledak & Menyembunyikan Nav Mobile di Desktop -->
    <style>
        .mobile-bottom-nav {
            display: none !important;
        }
        @media (max-width: 768px) {
            .mobile-bottom-nav {
                display: flex !important;
            }
        }
        .bottom-nav-item svg {
            width: 22px !important;
            height: 22px !important;
            max-width: 22px !important;
            max-height: 22px !important;
        }
        .pwa-install-banner {
            display: none !important;
        }
        @media (max-width: 768px) {
            .pwa-install-banner.pwa-active {
                display: flex !important;
            }
        }
    </style>
</head>
<body>
    <?php 
    $currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    ?>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="logo">
            <img src="/assets/images/logo.png" alt="Logo FKMT-G" class="logo-img">
            <div class="logo-text">
                <span class="logo-title">FKMT-G</span>
                <span class="logo-subtitle">Forum Komunikasi Mahasiswa Toili-Gorontalo</span>
            </div>
        </a>
        
        <!-- Hamburger Button untuk Layar Mobile -->
        <button class="nav-toggle" id="navToggle" aria-label="Buka Menu Navigasi">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Menu Links -->
        <ul class="nav-links" id="navLinks">
            <li><a href="/" class="<?= ($currentUri === '/') ? 'active' : '' ?>">Beranda</a></li>
            <li><a href="/tentang" class="<?= ($currentUri === '/tentang') ? 'active' : '' ?>">Tentang</a></li>
            <li><a href="/pengurus" class="<?= ($currentUri === '/pengurus') ? 'active' : '' ?>">Pengurus</a></li>
            <li><a href="/berita" class="<?= (strpos($currentUri, '/berita') === 0) ? 'active' : '' ?>">Berita</a></li>
            <li><a href="/galeri" class="<?= ($currentUri === '/galeri') ? 'active' : '' ?>">Galeri</a></li>
            <li class="nav-login-item">
                <a href="/login" class="btn-login-nav">Login Admin</a>
            </li>
        </ul>
    </nav>
    
    <!-- Overlay latar belakang menu mobile -->
    <div class="nav-overlay" id="navOverlay"></div>
    
    <!-- Main Content Area -->
    <main>
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <!-- FKMT-G (Kiri) -->
            <div class="footer-brand">
                <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 0.85rem;">
                    <img src="/assets/images/logo.png" alt="Logo FKMT-G" style="width: 44px; height: 44px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.25));">
                    <h4 style="margin: 0; font-size: 1.35rem; color: #FFFFFF;">FKMT-G</h4>
                </div>
                <p>Forum Komunikasi Mahasiswa Toili-Gorontalo. Wadah silaturahmi untuk mempererat persaudaraan dan membangun komunitas yang lebih baik.</p>
            </div>
            
            <!-- Hubungi Kami (Kanan) -->
            <div class="footer-contact">
                <h4>Hubungi Kami</h4>
                <ul class="footer-links">
                    <li>
                        <a href="https://instagram.com/fkmt.gorontalo" target="_blank" rel="noopener noreferrer">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: white; flex-shrink: 0;">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                            <span>@fkmt.gorontalo</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://facebook.com/fkmt.gorontalo" target="_blank" rel="noopener noreferrer">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: white; flex-shrink: 0;">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                            <span>FKMT Gorontalo</span>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:fkmt.gtlo@gmail.com">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: white; flex-shrink: 0;">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span>fkmt.gtlo@gmail.com</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> FKMT-G. All rights reserved.</p>
        </div>
    </footer>

    <!-- Script Hamburger Menu Mobile -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');
        const navOverlay = document.getElementById('navOverlay');

        if (navToggle && navLinks) {
            function toggleMenu() {
                navToggle.classList.toggle('open');
                navLinks.classList.toggle('active');
                if (navOverlay) navOverlay.classList.toggle('active');
                document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
            }

            function closeMenu() {
                navToggle.classList.remove('open');
                navLinks.classList.remove('active');
                if (navOverlay) navOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            navToggle.addEventListener('click', toggleMenu);
            if (navOverlay) navOverlay.addEventListener('click', closeMenu);

            navLinks.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', closeMenu);
            });
        }
    });
    </script>
    <!-- Floating WhatsApp Contact Button -->
    <a href="https://wa.me/6281234567890?text=Halo%20Pengurus%20FKMT-G%2C%20saya%20ingin%20bertanya%20seputar%20paguyuban." 
       target="_blank" 
       rel="noopener noreferrer" 
       class="floating-whatsapp" 
       title="Hubungi Pengurus FKMT-G via WhatsApp"
       aria-label="Hubungi Pengurus FKMT-G via WhatsApp">
        <svg viewBox="0 0 24 24" width="28" height="28" fill="currentColor">
            <path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.978-.276-.1-.476-.15-.676.15-.2.301-.776.978-.951 1.179-.175.2-.351.226-.652.075-.301-.15-1.272-.469-2.423-1.497-.896-.799-1.501-1.787-1.677-2.088-.175-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.175.2-.301.301-.501.1-.2.05-.376-.025-.526-.075-.15-.676-1.63-.927-2.232-.244-.587-.492-.507-.676-.516l-.577-.01c-.2 0-.526.075-.802.376-.276.301-1.052 1.028-1.052 2.508 0 1.48 1.077 2.909 1.228 3.109.15.2 2.12 3.238 5.136 4.542.717.311 1.277.497 1.714.636.721.23 1.377.197 1.896.12.578-.087 1.78-.727 2.03-1.429.25-.702.25-1.304.175-1.43-.075-.125-.276-.2-.577-.35zM12.04 2C6.51 2 2.03 6.48 2.03 12.01c0 1.98.58 3.82 1.58 5.37L2 22l4.8-1.55c1.49.91 3.24 1.44 5.24 1.44 5.53 0 10.01-4.48 10.01-10.01C22.05 6.48 17.57 2 12.04 2z"/>
        </svg>
        <span class="floating-whatsapp-tooltip">Hubungi Kami</span>
    </a>

    <!-- PWA Install Banner (Khusus Android/Mobile) -->
    <div id="pwaInstallBanner" class="pwa-install-banner" style="display: none;">
        <img src="/assets/images/logo.png" alt="Logo FKMT-G" class="pwa-install-icon">
        <div class="pwa-install-text">
            <h4 class="pwa-install-title">Pasang Aplikasi FKMT-G</h4>
            <p class="pwa-install-subtitle">Akses instan di layar utama Android & hemat kuota</p>
        </div>
        <button id="pwaInstallBtn" class="pwa-install-btn" type="button">Pasang</button>
        <button id="pwaInstallClose" class="pwa-install-close" type="button" aria-label="Tutup">&times;</button>
    </div>

    <!-- Mobile Bottom Navigation Bar (App Dock Khusus Android / Smartphone) -->
    <nav class="mobile-bottom-nav" aria-label="Navigasi Bawah Mobile" style="display: none;">
        <a href="/" class="bottom-nav-item <?= ($currentUri === '/') ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;max-width:22px;max-height:22px;">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span>Beranda</span>
        </a>
        <a href="/tentang" class="bottom-nav-item <?= ($currentUri === '/tentang') ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;max-width:22px;max-height:22px;">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <span>Tentang</span>
        </a>
        <a href="/pengurus" class="bottom-nav-item <?= ($currentUri === '/pengurus') ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;max-width:22px;max-height:22px;">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Pengurus</span>
        </a>
        <a href="/berita" class="bottom-nav-item <?= (strpos($currentUri, '/berita') === 0) ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;max-width:22px;max-height:22px;">
                <path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1"></path>
                <path d="M19 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-5"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="14" y2="14"></line>
            </svg>
            <span>Berita</span>
        </a>
        <a href="/galeri" class="bottom-nav-item <?= ($currentUri === '/galeri') ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:22px;height:22px;max-width:22px;max-height:22px;">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
            </svg>
            <span>Galeri</span>
        </a>
    </nav>

    <!-- Script Service Worker & PWA Install Handlers -->
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').then(function(reg) {
                console.log('ServiceWorker registered:', reg.scope);
            }).catch(function(err) {
                console.log('ServiceWorker error:', err);
            });
        });
    }

    let deferredPrompt = null;
    const pwaBanner = document.getElementById('pwaInstallBanner');
    const pwaBtn = document.getElementById('pwaInstallBtn');
    const pwaClose = document.getElementById('pwaInstallClose');

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        if (pwaBanner && window.innerWidth <= 768 && !sessionStorage.getItem('pwa_dismissed')) {
            pwaBanner.classList.add('pwa-active');
            pwaBanner.style.display = 'flex';
        }
    });

    if (pwaBtn) {
        pwaBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    console.log('User installed the PWA');
                }
                deferredPrompt = null;
            }
            if (pwaBanner) {
                pwaBanner.classList.remove('pwa-active');
                pwaBanner.style.display = 'none';
            }
        });
    }

    if (pwaClose) {
        pwaClose.addEventListener('click', () => {
            if (pwaBanner) {
                pwaBanner.classList.remove('pwa-active');
                pwaBanner.style.display = 'none';
            }
            sessionStorage.setItem('pwa_dismissed', '1');
        });
    }
    </script>
</body>
</html>

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
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="/assets/css/style.css">
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
</body>
</html>

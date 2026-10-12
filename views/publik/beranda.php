<?php $title = "Beranda | Website FKMT-G"; ?>
<?php ob_start(); ?>

<div class="hero">
    <div class="hero-slider">
        <?php if(!empty($sliders)): ?>
            <?php foreach($sliders as $index => $slider): ?>
                <div class="slide <?= $index === 0 ? 'active' : '' ?>" style="background-image: url('/assets/images/slider/<?= htmlspecialchars($slider['foto']) ?>');"></div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="slide active" style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);"></div>
        <?php endif; ?>
    </div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Selamat Datang di FKMT-G</h1>
        <h2 class="hero-subtitle">Forum Komunikasi Mahasiswa Toili-Gorontalo</h2>
        <p>Wadah silaturahmi untuk mempererat persaudaraan, berbagi informasi, dan berkolaborasi membangun komunitas yang lebih baik.</p>
        <a href="/tentang" class="btn-primary">Pelajari Lebih Lanjut</a>
    </div>

    <?php if(!empty($sliders) && count($sliders) > 1): ?>
        <!-- Slider Navigation Controls -->
        <button class="hero-nav-btn prev" id="heroPrevBtn" aria-label="Foto Sebelumnya">&lsaquo;</button>
        <button class="hero-nav-btn next" id="heroNextBtn" aria-label="Foto Selanjutnya">&rsaquo;</button>
        
        <!-- Slider Dots -->
        <div class="hero-dots" id="heroDots">
            <?php foreach($sliders as $index => $s): ?>
                <button class="hero-dot <?= $index === 0 ? 'active' : '' ?>" data-index="<?= $index ?>" aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slider .slide');
    const dots = document.querySelectorAll('.hero-dots .hero-dot');
    const prevBtn = document.getElementById('heroPrevBtn');
    const nextBtn = document.getElementById('heroNextBtn');
    
    if (slides.length > 1) {
        let currentSlide = 0;
        let slideInterval;

        function goToSlide(n) {
            slides[currentSlide].classList.remove('active');
            if (dots[currentSlide]) dots[currentSlide].classList.remove('active');
            
            currentSlide = (n + slides.length) % slides.length;
            
            slides[currentSlide].classList.add('active');
            if (dots[currentSlide]) dots[currentSlide].classList.add('active');
        }

        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        function startAutoPlay() {
            stopAutoPlay();
            slideInterval = setInterval(nextSlide, 5000);
        }

        function stopAutoPlay() {
            if (slideInterval) clearInterval(slideInterval);
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                startAutoPlay();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                startAutoPlay();
            });
        }

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                goToSlide(idx);
                startAutoPlay();
            });
        });

        startAutoPlay();
    }
});
</script>

<section class="features">
    <div class="feature-card">
        <h3>Kebersamaan</h3>
        <p>Membangun solidaritas dan gotong royong antar anggota untuk kesejahteraan bersama.</p>
    </div>
    <div class="feature-card">
        <h3>Transparansi</h3>
        <p>Informasi kepengurusan dan kegiatan selalu terbuka untuk semua anggota aktif.</p>
    </div>
    <div class="feature-card">
        <h3>Kabar Terbaru</h3>
        <p>Dapatkan update seputar kegiatan sosial, pertemuan, dan berita dari FKMT-G.</p>
    </div>
</section>

<section style="max-width: 1240px; margin: 4rem auto; padding: 0 5%;">
    <div class="section-title">
        <h2>Cuplikan Galeri Kegiatan</h2>
        <div class="divider"></div>
        <p style="color: #64748B; font-size: 0.95rem; margin-top: 0.5rem; text-align: center;">Dokumentasi kebersamaan dan berbagai aktivitas terbaru Forum Komunikasi Mahasiswa Toili-Gorontalo</p>
    </div>
    <div class="mini-galeri-grid">
        <?php if(!empty($galeriTerbaru)): ?>
            <?php foreach($galeriTerbaru as $g): ?>
            <?php 
                $lower = strtolower($g['judul']);
                $kat = 'Kegiatan';
                if (strpos($lower, 'mubes') !== false || strpos($lower, 'musyawarah') !== false) $kat = 'Musyawarah';
                elseif (strpos($lower, 'baksos') !== false || strpos($lower, 'bakti') !== false || strpos($lower, 'sosial') !== false) $kat = 'Bakti Sosial';
                elseif (strpos($lower, 'workshop') !== false || strpos($lower, 'ilmiah') !== false) $kat = 'Akademik';
                elseif (strpos($lower, 'pelantikan') !== false || strpos($lower, 'upgrading') !== false) $kat = 'Organisasi';
                elseif (strpos($lower, 'puasa') !== false || strpos($lower, 'keakraban') !== false) $kat = 'Keakraban';
            ?>
            <a href="/galeri" class="mini-galeri-item" title="Lihat Foto: <?= htmlspecialchars($g['judul']) ?>">
                <img src="/assets/images/galeri/<?= htmlspecialchars($g['foto']) ?>" 
                     alt="<?= htmlspecialchars($g['judul']) ?>" 
                     class="mini-galeri-img" 
                     loading="lazy">
                <div class="mini-galeri-overlay">
                    <div class="mini-galeri-top">
                        <span class="mini-galeri-badge"><?= htmlspecialchars($kat) ?></span>
                        <div class="mini-galeri-zoom">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                <line x1="11" y1="8" x2="11" y2="14"></line>
                                <line x1="8" y1="11" x2="14" y2="11"></line>
                            </svg>
                        </div>
                    </div>
                    <div class="mini-galeri-bottom">
                        <h3 class="mini-galeri-title"><?= htmlspecialchars($g['judul']) ?></h3>
                        <div class="mini-galeri-date">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span><?= date('d M Y', strtotime($g['created_at'])) ?></span>
                        </div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: 1/-1; text-align: center; color: #64748B;">Belum ada dokumentasi galeri terbaru.</p>
        <?php endif; ?>
    </div>
    <div style="text-align: center; margin-top: 3rem;">
        <a href="/galeri" class="btn-primary" style="background: transparent; color: #059669; border: 2px solid #059669; padding: 0.65rem 1.6rem; border-radius: 9999px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; text-decoration: none;">
            <span>Lihat Semua Galeri</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </a>
    </div>
</section>

<section style="max-width: 1200px; margin: 4rem auto; padding: 0 2rem;">
    <div class="section-title">
        <h2>Berita & Kegiatan Terbaru</h2>
        <div class="divider"></div>
    </div>
    <div class="berita-grid" style="margin-top: 2rem;">
        <?php if(!empty($semuaBerita)): ?>
            <?php foreach($semuaBerita as $b): ?>
            <?php $detailUrl = '/berita/detail/' . htmlspecialchars($b['slug'] ?? $b['id']); ?>
            <article class="berita-card">
                <div class="berita-image">
                    <?php if(!empty($b['gambar'])): ?>
                        <a href="<?= $detailUrl ?>" style="display: block; width: 100%; height: 100%;">
                            <img src="/assets/images/berita/<?= htmlspecialchars($b['gambar']) ?>" alt="<?= htmlspecialchars($b['judul']) ?>">
                        </a>
                    <?php else: ?>
                        <a href="<?= $detailUrl ?>" style="display: block; width: 100%; height: 100%; text-decoration: none;">
                            <div class="image-placeholder gradient-secondary">
                                <span>Foto <?= htmlspecialchars($b['kategori']) ?></span>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="berita-content">
                    <div class="berita-meta">
                        <span class="berita-tag"><?= htmlspecialchars($b['kategori']) ?></span>
                        <span class="berita-date"><?= date('d M Y', strtotime($b['created_at'])) ?></span>
                    </div>
                    <h3><a href="<?= $detailUrl ?>"><?= htmlspecialchars($b['judul']) ?></a></h3>
                    <p><?= htmlspecialchars(mb_strimwidth(strip_tags($b['konten']), 0, 100, '...')) ?></p>
                    <a href="<?= $detailUrl ?>" class="read-more">Baca Selengkapnya &rarr;</a>
                </div>
            </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="grid-column: 1/-1; text-align: center; color: #64748B;">Belum ada berita terbaru.</p>
        <?php endif; ?>
    </div>
    <div style="text-align: center; margin-top: 3rem;">
        <a href="/berita" class="btn-primary" style="background: transparent; color: #059669; border: 2px solid #059669;">Lihat Semua Berita</a>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section">
    <div class="cta-card">
        <div class="cta-badge">Bergabung Bersama Kami</div>
        <h2>Mahasiswa Asal Toili di Gorontalo?</h2>
        <p>Mari bergabung bersama keluarga besar FKMT-G. Jalin kebersamaan, perluas jaringan kekeluargaan, dan saling bahu-membahu di tanah rantau.</p>
        <div class="cta-actions">
            <a href="https://wa.me/6281234567890?text=Halo%20Pengurus%20FKMT-G%2C%20saya%20ingin%20bergabung%20dengan%20paguyuban." target="_blank" rel="noopener noreferrer" class="btn-cta-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.978-.276-.1-.476-.15-.676.15-.2.301-.776.978-.951 1.179-.175.2-.351.226-.652.075-.301-.15-1.272-.469-2.423-1.497-.896-.799-1.501-1.787-1.677-2.088-.175-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.175.2-.301.301-.501.1-.2.05-.376-.025-.526-.075-.15-.676-1.63-.927-2.232-.244-.587-.492-.507-.676-.516l-.577-.01c-.2 0-.526.075-.802.376-.276.301-1.052 1.028-1.052 2.508 0 1.48 1.077 2.909 1.228 3.109.15.2 2.12 3.238 5.136 4.542.717.311 1.277.497 1.714.636.721.23 1.377.197 1.896.12.578-.087 1.78-.727 2.03-1.429.25-.702.25-1.304.175-1.43-.075-.125-.276-.2-.577-.35zM12.04 2C6.51 2 2.03 6.48 2.03 12.01c0 1.98.58 3.82 1.58 5.37L2 22l4.8-1.55c1.49.91 3.24 1.44 5.24 1.44 5.53 0 10.01-4.48 10.01-10.01C22.05 6.48 17.57 2 12.04 2z"/>
                </svg>
                <span>Hubungi Pengurus Paguyuban</span>
            </a>
            <a href="/pengurus" class="btn-cta-secondary">
                Lihat Susunan Pengurus &rarr;
            </a>
        </div>
    </div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_publik.php'; ?>

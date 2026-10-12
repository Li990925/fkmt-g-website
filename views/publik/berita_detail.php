<?php $title = htmlspecialchars($berita['judul']) . " | FKMT-G"; ?>
<?php ob_start(); ?>

<!-- Breadcrumb Header -->
<div class="page-header" style="padding: 3rem 5% 2.5rem; text-align: left;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <nav class="breadcrumb-nav" style="margin-bottom: 1rem; font-size: 0.9rem; color: #64748B;">
            <a href="/" style="color: var(--primary); text-decoration: none; font-weight: 500;">Beranda</a>
            <span style="margin: 0 0.5rem;">/</span>
            <a href="/berita" style="color: var(--primary); text-decoration: none; font-weight: 500;">Berita</a>
            <span style="margin: 0 0.5rem;">/</span>
            <span style="color: #94A3B8;"><?= htmlspecialchars(mb_strimwidth($berita['judul'], 0, 45, '...')) ?></span>
        </nav>
        <div style="display: flex; gap: 0.8rem; align-items: center; margin-bottom: 0.75rem;">
            <span class="berita-tag"><?= htmlspecialchars($berita['kategori'] ?? 'Umum') ?></span>
            <span style="color: #64748B; font-size: 0.9rem;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: -2px; margin-right: 4px;">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <?= date('d F Y', strtotime($berita['created_at'])) ?>
            </span>
        </div>
        <h1 style="font-size: 2.2rem; color: var(--dark); line-height: 1.3; font-weight: 700; margin: 0; max-width: 900px;">
            <?= htmlspecialchars($berita['judul']) ?>
        </h1>
    </div>
</div>

<div class="container" style="max-width: 1200px; padding: 3rem 5% 5rem;">
    <div class="article-layout">
        <!-- Konten Utama Berita -->
        <article class="article-main">
            <!-- Gambar Utama / Hero Berita -->
            <?php if(!empty($berita['gambar'])): ?>
                <div class="article-image-wrapper">
                    <img src="/assets/images/berita/<?= htmlspecialchars($berita['gambar']) ?>" alt="<?= htmlspecialchars($berita['judul']) ?>" class="article-featured-img">
                </div>
            <?php else: ?>
                <div class="article-image-fallback gradient-primary">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.8;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span style="margin-top: 0.5rem; font-weight: 500; font-size: 0.95rem;">Dokumentasi <?= htmlspecialchars($berita['kategori']) ?></span>
                </div>
            <?php endif; ?>

            <!-- Isi Paragraf Berita -->
            <div class="article-body">
                <?= nl2br(htmlspecialchars($berita['konten'])) ?>
            </div>

            <!-- Tombol Bagikan & Navigasi -->
            <div class="article-share-bar">
                <div class="share-label">
                    <strong>Bagikan Informasi:</strong>
                </div>
                <div class="share-buttons">
                    <?php
                        $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        $shareText = urlencode($berita['judul'] . " - Website FKMT-G");
                    ?>
                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text=<?= $shareText ?>%20<?= urlencode($currentUrl) ?>" target="_blank" class="btn-share share-wa" title="Bagikan ke WhatsApp">
                        WhatsApp
                    </a>
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrl) ?>" target="_blank" class="btn-share share-fb" title="Bagikan ke Facebook">
                        Facebook
                    </a>
                    <!-- Salin Tautan -->
                    <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berita berhasil disalin ke clipboard!');" class="btn-share share-copy" title="Salin Tautan">
                        Salin Tautan
                    </button>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div style="margin-top: 2rem;">
                <a href="/berita" class="btn-back">&larr; Kembali ke Semua Berita</a>
            </div>
        </article>

        <!-- Sidebar Berita Terkait -->
        <aside class="article-sidebar">
            <div class="sidebar-card">
                <h3 class="sidebar-heading">Berita Lainnya</h3>
                <div class="sidebar-divider"></div>

                <?php if(!empty($beritaTerkait)): ?>
                    <div class="sidebar-news-list">
                        <?php foreach($beritaTerkait as $terkait): ?>
                        <a href="/berita/detail/<?= htmlspecialchars($terkait['slug'] ?? $terkait['id']) ?>" class="sidebar-news-item">
                            <div class="sidebar-news-info">
                                <span class="sidebar-news-tag"><?= htmlspecialchars($terkait['kategori']) ?></span>
                                <h4 class="sidebar-news-title"><?= htmlspecialchars($terkait['judul']) ?></h4>
                                <span class="sidebar-news-date"><?= date('d M Y', strtotime($terkait['created_at'])) ?></span>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="color: #94A3B8; font-size: 0.9rem; text-align: center; padding: 1.5rem 0;">Belum ada berita lainnya.</p>
                <?php endif; ?>
            </div>

            <!-- Info Kontak / Gabung -->
            <div class="sidebar-card sidebar-banner">
                <h4 style="font-size: 1.1rem; color: var(--dark); font-weight: 700; margin-bottom: 0.5rem;">FKMT-G Gorontalo</h4>
                <p style="color: #64748B; font-size: 0.88rem; line-height: 1.5; margin-bottom: 1rem;">Wadah silaturahmi mahasiswa Toili di Gorontalo. Bersama membangun rasa persaudaraan dan kepedulian bersama.</p>
                <a href="/tentang" class="btn-primary" style="display: block; text-align: center; font-size: 0.85rem; padding: 0.6rem 1rem; border-radius: 8px; text-decoration: none;">Tentang Kami &rarr;</a>
            </div>
        </aside>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_publik.php'; ?>

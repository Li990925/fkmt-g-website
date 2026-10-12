<?php 
$title = "Berita & Kegiatan | Website FKMT-G"; 
$selectedKategori = $selectedKategori ?? '';
$searchKeyword = $searchKeyword ?? '';
$hasFilter = !empty($selectedKategori) || !empty($searchKeyword);

// Daftar kategori gabungan default & dari database
$defaultKategori = ['Semua', 'Organisasi', 'Kegiatan', 'Sosial', 'Pendidikan', 'Pengumuman'];
if (!empty($kategoriList)) {
    foreach ($kategoriList as $k) {
        if (!in_array($k, $defaultKategori)) {
            $defaultKategori[] = $k;
        }
    }
}
?>
<?php ob_start(); ?>

<div class="page-header">
    <div class="header-content">
        <h1>Berita & Kegiatan</h1>
        <p>Ikuti terus perkembangan terbaru, kegiatan sosial, dan pengumuman penting dari FKMT-G.</p>
    </div>
</div>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem 4rem;">
    <!-- Search & Filter Bar -->
    <div class="berita-filter-section">
        <form action="/berita" method="GET" class="berita-search-form">
            <?php if (!empty($selectedKategori) && strtolower($selectedKategori) !== 'semua'): ?>
                <input type="hidden" name="kategori" value="<?= htmlspecialchars($selectedKategori) ?>">
            <?php endif; ?>
            <div class="berita-search-input-wrapper">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" class="berita-search-input" placeholder="Cari judul atau topik berita..." value="<?= htmlspecialchars($searchKeyword) ?>">
            </div>
            <button type="submit" class="btn-search-berita">
                <span>Cari</span>
            </button>
        </form>

        <!-- Category Pills -->
        <div class="berita-category-bar">
            <span class="category-bar-label">Kategori:</span>
            <?php foreach ($defaultKategori as $kat): ?>
                <?php 
                    $isSemua = ($kat === 'Semua');
                    $isActive = ($isSemua && empty($selectedKategori)) || (strtolower($selectedKategori) === strtolower($kat));
                    
                    // Bangun query params
                    $queryParams = [];
                    if (!$isSemua) {
                        $queryParams['kategori'] = $kat;
                    }
                    if (!empty($searchKeyword)) {
                        $queryParams['q'] = $searchKeyword;
                    }
                    $pillUrl = '/berita' . (!empty($queryParams) ? '?' . http_build_query($queryParams) : '');
                ?>
                <a href="<?= $pillUrl ?>" class="category-pill <?= $isActive ? 'active' : '' ?>">
                    <?= htmlspecialchars($kat) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($hasFilter): ?>
            <div class="filter-status-info">
                <span>
                    Menampilkan <strong><?= count($semuaBerita) ?></strong> artikel
                    <?php if (!empty($searchKeyword)): ?>
                        untuk kata kunci "<strong><?= htmlspecialchars($searchKeyword) ?></strong>"
                    <?php endif; ?>
                    <?php if (!empty($selectedKategori) && strtolower($selectedKategori) !== 'semua'): ?>
                        pada kategori "<strong><?= htmlspecialchars($selectedKategori) ?></strong>"
                    <?php endif; ?>
                </span>
                <a href="/berita" class="btn-reset-filter">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    Reset Filter
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Berita Grid -->
    <div class="berita-grid">
        <?php if (empty($semuaBerita)): ?>
            <div class="empty-state-box">
                <div class="empty-state-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        <line x1="8" y1="11" x2="14" y2="11"></line>
                    </svg>
                </div>
                <h3>Tidak Ada Berita Ditemukan</h3>
                <p>
                    <?= $hasFilter ? 'Tidak ada artikel yang cocok dengan pencarian atau filter yang Anda pilih. Coba gunakan kata kunci lain.' : 'Belum ada berita yang diterbitkan saat ini.' ?>
                </p>
                <?php if ($hasFilter): ?>
                    <a href="/berita" class="btn-primary" style="display: inline-block;">Lihat Semua Berita</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <?php foreach ($semuaBerita as $index => $b): ?>
            <?php 
                // Jika sedang filter/pencarian, jangan buat item pertama jadi banner lebar agar grid konsisten
                $isUtama = (!$hasFilter && $index === 0); 
                $detailUrl = '/berita/detail/' . htmlspecialchars($b['slug'] ?? $b['id']);
            ?>
            <article class="berita-card <?= $isUtama ? 'berita-utama' : '' ?>">
                <div class="berita-image">
                    <?php if (!empty($b['gambar'])): ?>
                        <a href="<?= $detailUrl ?>" style="display: block; width: 100%; height: 100%;">
                            <img src="/assets/images/berita/<?= htmlspecialchars($b['gambar']) ?>" alt="<?= htmlspecialchars($b['judul']) ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        </a>
                    <?php else: ?>
                        <a href="<?= $detailUrl ?>" style="display: block; width: 100%; height: 100%; text-decoration: none;">
                            <div class="image-placeholder gradient-<?= $isUtama ? 'primary' : 'secondary' ?>">
                                <span>Foto <?= htmlspecialchars($b['kategori']) ?></span>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="berita-content">
                    <div class="berita-meta">
                        <a href="/berita?kategori=<?= urlencode($b['kategori']) ?>" class="berita-tag" style="text-decoration: none;"><?= htmlspecialchars($b['kategori']) ?></a>
                        <span class="berita-date"><?= date('d F Y', strtotime($b['created_at'])) ?></span>
                    </div>
                    <?php if ($isUtama): ?>
                        <h2><a href="<?= $detailUrl ?>"><?= htmlspecialchars($b['judul']) ?></a></h2>
                    <?php else: ?>
                        <h3><a href="<?= $detailUrl ?>"><?= htmlspecialchars($b['judul']) ?></a></h3>
                    <?php endif; ?>
                    <p><?= htmlspecialchars(mb_strimwidth(strip_tags($b['konten']), 0, 150, '...')) ?></p>
                    <a href="<?= $detailUrl ?>" class="read-more">Baca Selengkapnya &rarr;</a>
                </div>
            </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_publik.php'; ?>

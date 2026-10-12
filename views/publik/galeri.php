<?php $title = "Galeri Kegiatan | FKMT-G"; ?>
<?php ob_start(); ?>

<?php
function getKategoriGaleri($judul) {
    $lower = strtolower($judul);
    if (strpos($lower, 'mubes') !== false || strpos($lower, 'musyawarah') !== false) return 'Musyawarah';
    if (strpos($lower, 'baksos') !== false || strpos($lower, 'bakti') !== false || strpos($lower, 'sosial') !== false) return 'Bakti Sosial';
    if (strpos($lower, 'workshop') !== false || strpos($lower, 'ilmiah') !== false || strpos($lower, 'pelatihan') !== false) return 'Akademik';
    if (strpos($lower, 'pelantikan') !== false || strpos($lower, 'upgrading') !== false) return 'Organisasi';
    if (strpos($lower, 'puasa') !== false || strpos($lower, 'keakraban') !== false || strpos($lower, 'silaturahmi') !== false) return 'Keakraban';
    return 'Kegiatan';
}
?>

<div class="page-header">
    <div class="header-content">
        <h1>Galeri Dokumentasi</h1>
        <p>Potret kebersamaan, dedikasi, dan dinamika kegiatan Forum Komunikasi Mahasiswa Toili-Gorontalo.</p>
    </div>
</div>

<div class="container" style="max-width: 1240px; padding: 2.5rem 5% 5rem;">
    <?php if(empty($semuaGaleri)): ?>
        <div style="text-align: center; padding: 4rem 2rem; background: #ffffff; border-radius: 16px; border: 1px dashed #CBD5E1; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); max-width: 600px; margin: 0 auto;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
            </svg>
            <h3 style="font-size: 1.2rem; color: #1E293B; margin-bottom: 0.5rem; font-weight: 600;">Belum Ada Foto Galeri</h3>
            <p style="color: #64748B; font-size: 0.95rem; margin-bottom: 1.5rem;">Dokumentasi kegiatan terbaru akan segera diunggah oleh pengurus.</p>
            <a href="/" class="btn-primary" style="padding: 0.6rem 1.25rem; font-size: 0.9rem;">Kembali ke Beranda</a>
        </div>
    <?php else: ?>
        <!-- Controls Bar: Filter Pills & Layout Switcher -->
        <div class="galeri-controls-bar">
            <!-- Filter Kategori -->
            <div class="galeri-filter-pills" id="galeriFilterPills">
                <button class="galeri-filter-btn active" onclick="filterGaleri('all', this)">
                    Semua Foto <span class="galeri-filter-count"><?= count($semuaGaleri) ?></span>
                </button>
                <button class="galeri-filter-btn" onclick="filterGaleri('Organisasi', this)">
                    Organisasi
                </button>
                <button class="galeri-filter-btn" onclick="filterGaleri('Musyawarah', this)">
                    Musyawarah
                </button>
                <button class="galeri-filter-btn" onclick="filterGaleri('Bakti Sosial', this)">
                    Bakti Sosial
                </button>
                <button class="galeri-filter-btn" onclick="filterGaleri('Akademik', this)">
                    Akademik
                </button>
                <button class="galeri-filter-btn" onclick="filterGaleri('Keakraban', this)">
                    Keakraban
                </button>
            </div>

            <!-- Layout Switcher: Masonry, Bento Mosaic, Grid -->
            <div class="galeri-view-toggle">
                <button class="galeri-view-btn active" id="btnLayoutMasonry" onclick="setLayout('masonry')" title="Tampilan Air Terjun (Masonry)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="11" rx="1"></rect>
                        <rect x="14" y="3" width="7" height="6" rx="1"></rect>
                        <rect x="14" y="12" width="7" height="9" rx="1"></rect>
                        <rect x="3" y="17" width="7" height="4" rx="1"></rect>
                    </svg>
                    Masonry
                </button>
                <button class="galeri-view-btn" id="btnLayoutBento" onclick="setLayout('bento')" title="Tampilan Mosaik Majalah (Bento)">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="11" height="11" rx="1"></rect>
                        <rect x="17" y="3" width="4" height="8" rx="1"></rect>
                        <rect x="17" y="14" width="4" height="7" rx="1"></rect>
                        <rect x="3" y="17" width="11" height="4" rx="1"></rect>
                    </svg>
                    Bento
                </button>
                <button class="galeri-view-btn" id="btnLayoutGrid" onclick="setLayout('grid')" title="Tampilan Grid Simetris">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"></rect>
                        <rect x="14" y="3" width="7" height="7" rx="1"></rect>
                        <rect x="14" y="14" width="7" height="7" rx="1"></rect>
                        <rect x="3" y="14" width="7" height="7" rx="1"></rect>
                    </svg>
                    Grid
                </button>
            </div>
        </div>

        <!-- Dynamic Galeri Container -->
        <div class="galeri-container layout-masonry" id="galeriContainer">
            <?php 
            $ratios = ['ratio-wide bento-hero', 'ratio-tall bento-tall', 'ratio-standard', 'ratio-tall', 'ratio-wide bento-wide', 'ratio-square'];
            foreach($semuaGaleri as $index => $g): 
                $kategori = getKategoriGaleri($g['judul']);
                $ratioClass = $ratios[$index % count($ratios)];
            ?>
            <div class="galeri-item <?= $ratioClass ?>" data-kategori="<?= htmlspecialchars($kategori) ?>" data-index="<?= $index ?>">
                <div class="galeri-card <?= $ratioClass ?>" 
                     onclick="openLightboxIndex(<?= $index ?>)" 
                     title="Klik untuk melihat foto: <?= htmlspecialchars($g['judul']) ?>">
                    
                    <img src="/assets/images/galeri/<?= htmlspecialchars($g['foto']) ?>" 
                         alt="<?= htmlspecialchars($g['judul']) ?>" 
                         class="galeri-card-img"
                         loading="lazy">
                    
                    <!-- Full Bleed Gradient Overlay -->
                    <div class="galeri-card-overlay">
                        <div class="galeri-card-top">
                            <span class="galeri-badge-kategori"><?= htmlspecialchars($kategori) ?></span>
                            <div class="galeri-zoom-pill" title="Perbesar Foto">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    <line x1="11" y1="8" x2="11" y2="14"></line>
                                    <line x1="8" y1="11" x2="14" y2="11"></line>
                                </svg>
                            </div>
                        </div>
                        <div class="galeri-card-bottom">
                            <h3 class="galeri-card-title"><?= htmlspecialchars($g['judul']) ?></h3>
                            <div class="galeri-card-date">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <span><?= date('d M Y', strtotime($g['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div id="noGaleriMatch" style="display: none; text-align: center; padding: 4rem 2rem; background: #FFFFFF; border-radius: 16px; border: 1px dashed #CBD5E1; margin: 2rem auto; max-width: 500px;">
            <p style="color: #64748B; font-size: 1rem; margin-bottom: 1rem;">Tidak ada foto pada kategori ini.</p>
            <button onclick="filterGaleri('all', document.querySelector('.galeri-filter-btn'))" class="btn-primary" style="padding: 0.5rem 1.2rem; font-size: 0.88rem;">Tampilkan Semua</button>
        </div>
    <?php endif; ?>
</div>

<!-- Modern Lightbox Modal with Next / Prev Navigation -->
<div id="lightboxModal" class="lightbox-modal">
    <button class="lightbox-close-btn" onclick="closeLightbox()" title="Tutup (Esc)">
        &times;
    </button>
    <div class="lightbox-container" onclick="event.stopPropagation()">
        <!-- Prev Button -->
        <button class="lightbox-nav-btn prev" onclick="prevLightbox(event)" title="Foto Sebelumnya (&larr;)">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>

        <!-- Main Photo -->
        <div class="lightbox-img-wrapper">
            <img id="lightboxImg" src="" alt="Detail Galeri" class="lightbox-img">
        </div>

        <!-- Next Button -->
        <button class="lightbox-nav-btn next" onclick="nextLightbox(event)" title="Foto Selanjutnya (&rarr;)">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>

        <!-- Captions & Metadata -->
        <div class="lightbox-caption-box">
            <h4 id="lightboxTitle"></h4>
            <div class="lightbox-meta-info">
                <span id="lightboxCategory" class="lightbox-counter-badge"></span>
                <span id="lightboxDate"></span>
                <span id="lightboxCounter" style="color: #64748B;"></span>
            </div>
        </div>
    </div>
</div>

<script>
// Data galeri untuk lightbox navigation
const galeriData = [
<?php if(!empty($semuaGaleri)): ?>
    <?php foreach($semuaGaleri as $g): ?>
    {
        src: '/assets/images/galeri/<?= htmlspecialchars($g['foto']) ?>',
        title: <?= json_encode($g['judul']) ?>,
        date: '<?= date('d M Y', strtotime($g['created_at'])) ?>',
        kategori: <?= json_encode(getKategoriGaleri($g['judul'])) ?>
    },
    <?php endforeach; ?>
<?php endif; ?>
];

let currentLightboxIndex = 0;

function openLightboxIndex(index) {
    if (index < 0 || index >= galeriData.length) return;
    currentLightboxIndex = index;
    renderLightboxItem();
    
    const modal = document.getElementById('lightboxModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function renderLightboxItem() {
    const item = galeriData[currentLightboxIndex];
    if (!item) return;

    const img = document.getElementById('lightboxImg');
    const titleEl = document.getElementById('lightboxTitle');
    const dateEl = document.getElementById('lightboxDate');
    const catEl = document.getElementById('lightboxCategory');
    const counterEl = document.getElementById('lightboxCounter');

    img.style.opacity = '0.4';
    img.src = item.src;
    img.onload = () => { img.style.opacity = '1'; };

    titleEl.textContent = item.title;
    dateEl.textContent = 'Diunggah: ' + item.date;
    catEl.textContent = item.kategori;
    counterEl.textContent = `Foto ${currentLightboxIndex + 1} dari ${galeriData.length}`;
}

function nextLightbox(e) {
    if (e) e.stopPropagation();
    currentLightboxIndex = (currentLightboxIndex + 1) % galeriData.length;
    renderLightboxItem();
}

function prevLightbox(e) {
    if (e) e.stopPropagation();
    currentLightboxIndex = (currentLightboxIndex - 1 + galeriData.length) % galeriData.length;
    renderLightboxItem();
}

function closeLightbox() {
    const modal = document.getElementById('lightboxModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

document.getElementById('lightboxModal').addEventListener('click', closeLightbox);
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('lightboxModal').classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') nextLightbox();
    if (e.key === 'ArrowLeft') prevLightbox();
});

// Filter Galeri Interaktif
function filterGaleri(kategori, btn) {
    // Update active pill
    document.querySelectorAll('.galeri-filter-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');

    const items = document.querySelectorAll('.galeri-item');
    let visibleCount = 0;

    items.forEach(item => {
        const itemCat = item.getAttribute('data-kategori');
        if (kategori === 'all' || itemCat.toLowerCase() === kategori.toLowerCase()) {
            item.style.display = '';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    const noMatch = document.getElementById('noGaleriMatch');
    if (noMatch) {
        noMatch.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}

// Layout Switcher (Masonry, Bento, Grid)
function setLayout(layoutName) {
    const container = document.getElementById('galeriContainer');
    if (!container) return;

    container.classList.remove('layout-masonry', 'layout-bento', 'layout-grid');
    container.classList.add('layout-' + layoutName);

    document.querySelectorAll('.galeri-view-btn').forEach(btn => btn.classList.remove('active'));
    if (layoutName === 'masonry') document.getElementById('btnLayoutMasonry').classList.add('active');
    if (layoutName === 'bento') document.getElementById('btnLayoutBento').classList.add('active');
    if (layoutName === 'grid') document.getElementById('btnLayoutGrid').classList.add('active');
}
</script>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_publik.php'; ?>


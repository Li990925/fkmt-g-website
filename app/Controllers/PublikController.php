<?php
namespace app\Controllers;

class PublikController {
    public function beranda() {
        require_once __DIR__ . '/../../app/Models/Berita.php';
        require_once __DIR__ . '/../../app/Models/Slider.php';
        require_once __DIR__ . '/../../app/Models/Galeri.php';
        
        $beritaModel = new \app\Models\Berita();
        $sliderModel = new \app\Models\Slider();
        $galeriModel = new \app\Models\Galeri();
        
        // Cukup ambil 3 terbaru
        $semuaBerita = array_slice($beritaModel->readAll(), 0, 3);
        $sliders = $sliderModel->readAll();
        
        // Ambil 4 galeri terbaru
        $galeriTerbaru = array_slice($galeriModel->readAll(), 0, 4);
        
        require_once __DIR__ . '/../../views/publik/beranda.php';
    }

    public function tentang() {
        require_once __DIR__ . '/../../views/publik/tentang.php';
    }

    public function pengurus() {
        require_once __DIR__ . '/../../app/Models/Pengurus.php';
        $pengurusModel = new \app\Models\Pengurus();
        $semuaPengurus = $pengurusModel->readAll();
        require_once __DIR__ . '/../../views/publik/pengurus.php';
    }

    public function berita() {
        require_once __DIR__ . '/../../app/Models/Berita.php';
        $beritaModel = new \app\Models\Berita();

        $selectedKategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
        $searchKeyword = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (!empty($selectedKategori) || !empty($searchKeyword)) {
            $semuaBerita = $beritaModel->searchAndFilter($searchKeyword, $selectedKategori);
        } else {
            $semuaBerita = $beritaModel->readAll();
        }

        $kategoriList = $beritaModel->getCategories();
        require_once __DIR__ . '/../../views/publik/berita.php';
    }

    public function beritaDetail($identifier) {
        require_once __DIR__ . '/../../app/Models/Berita.php';
        $beritaModel = new \app\Models\Berita();
        
        // Cari berdasarkan slug, fallback ke id jika angka
        $berita = $beritaModel->readBySlug($identifier);
        if (!$berita && is_numeric($identifier)) {
            $berita = $beritaModel->readById((int)$identifier);
        }

        if (!$berita) {
            http_response_code(404);
            $title = "Berita Tidak Ditemukan | FKMT-G";
            ob_start();
            ?>
            <div class="page-header">
                <div class="header-content">
                    <h1>Berita Tidak Ditemukan</h1>
                    <p>Artikel yang Anda cari mungkin telah dipindahkan atau tautan tidak valid.</p>
                </div>
            </div>
            <div class="container" style="text-align:center; padding: 4rem 1rem;">
                <p style="color: #64748B; margin-bottom: 2rem;">Silakan periksa kembali tautan Anda atau telusuri artikel menarik lainnya.</p>
                <a href="/berita" class="btn-primary" style="padding: 0.8rem 1.8rem; text-decoration: none; border-radius: 8px;">&larr; Kembali ke Daftar Berita</a>
            </div>
            <?php
            $content = ob_get_clean();
            require_once __DIR__ . '/../../views/layouts/master_publik.php';
            return;
        }

        // URL kanonik tunggal untuk artikel (hindari duplikasi /berita/{id}, /berita/{slug}, /berita/detail/{slug})
        $currentUri = '/berita/detail/' . (!empty($berita['slug']) ? $berita['slug'] : $berita['id']);

        // Ambil berita terbaru lainnya untuk rekomendasi bacaan
        $beritaTerkait = $beritaModel->readRecentExcept($berita['id'], 4);

        require_once __DIR__ . '/../../views/publik/berita_detail.php';
    }

    public function galeri() {
        require_once __DIR__ . '/../../app/Models/Galeri.php';
        $galeriModel = new \app\Models\Galeri();
        $semuaGaleri = $galeriModel->readAll();
        require_once __DIR__ . '/../../views/publik/galeri.php';
    }
}

<?php
use app\Controllers\PublikController;
use app\Controllers\AdminController;
use app\Controllers\AuthController;
use app\Config\Csrf;

$publik = new PublikController();
$admin = new AdminController();
$auth = new AuthController();

$isPost = ($_SERVER['REQUEST_METHOD'] === 'POST');

/**
 * Pastikan aksi yang mengubah data (hapus) hanya bisa dijalankan via POST.
 * Request GET (crawler, prefetch, link jahat) akan diarahkan kembali tanpa menghapus apa pun.
 */
function requirePost($fallbackUrl) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ' . $fallbackUrl);
        exit;
    }
}

// Routing untuk Publik
if ($uri === '/' || $uri === '/index.php') {
    $publik->beranda();
} elseif ($uri === '/tentang') {
    $publik->tentang();
} elseif ($uri === '/pengurus') {
    $publik->pengurus();
} elseif ($uri === '/berita') {
    $publik->berita();
} elseif (preg_match('#^/berita/(?:detail/)?([a-zA-Z0-9_-]+)$#', $uri, $matches)) {
    $publik->beritaDetail($matches[1]);
} elseif ($uri === '/galeri') {
    $publik->galeri();
} elseif ($uri === '/login') {
    $auth->login();
} elseif ($uri === '/logout') {
    $auth->logout();
} 
// Routing untuk Admin
elseif ($uri === '/admin' || strpos($uri, '/admin/') === 0) {
    // Cek apakah admin sudah login
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: /login');
        exit;
    }

    // Validasi seluruh request POST di area admin
    if ($isPost) {
        // Jika total upload melebihi post_max_size, PHP mengosongkan $_POST & $_FILES
        if (empty($_POST) && empty($_FILES) && (int)($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
            $_SESSION['flash_error'] = "Ukuran data/file yang dikirim terlalu besar (batas server: " . ini_get('post_max_size') . ").";
            header('Location: ' . $uri);
            exit;
        }
        if (!Csrf::verify()) {
            $_SESSION['flash_error'] = "Sesi formulir tidak valid atau kedaluwarsa. Silakan muat ulang halaman dan coba lagi.";
            header('Location: ' . $uri);
            exit;
        }
    }
    
    if ($uri === '/admin') {
        $admin->dashboard();
    } elseif ($uri === '/admin/berita') {
        $admin->berita();
    } elseif ($uri === '/admin/berita/tambah') {
        if ($isPost) {
            $admin->beritaSimpan();
        } else {
            $admin->beritaTambah();
        }
    } elseif (preg_match('#^/admin/berita/hapus/(\d+)$#', $uri, $matches)) {
        requirePost('/admin/berita');
        $admin->beritaHapus($matches[1]);
    } elseif (preg_match('#^/admin/berita/edit/(\d+)$#', $uri, $matches)) {
        $admin->beritaEdit($matches[1]);
    } elseif (preg_match('#^/admin/berita/update/(\d+)$#', $uri, $matches)) {
        requirePost('/admin/berita');
        $admin->beritaUpdate($matches[1]);
    } elseif ($uri === '/admin/pengurus') {
        $admin->pengurus();
    } elseif ($uri === '/admin/pengurus/tambah') {
        if ($isPost) {
            $admin->pengurusSimpan();
        } else {
            $admin->pengurusTambah();
        }
    } elseif (preg_match('#^/admin/pengurus/hapus/(\d+)$#', $uri, $matches)) {
        requirePost('/admin/pengurus');
        $admin->pengurusHapus($matches[1]);
    } elseif (preg_match('#^/admin/pengurus/edit/(\d+)$#', $uri, $matches)) {
        $admin->pengurusEdit($matches[1]);
    } elseif (preg_match('#^/admin/pengurus/update/(\d+)$#', $uri, $matches)) {
        requirePost('/admin/pengurus');
        $admin->pengurusUpdate($matches[1]);
    } elseif ($uri === '/admin/galeri') {
        $admin->galeri();
    } elseif ($uri === '/admin/galeri/tambah') {
        if ($isPost) {
            $admin->galeriSimpan();
        } else {
            $admin->galeriTambah();
        }
    } elseif (preg_match('#^/admin/galeri/hapus/(\d+)$#', $uri, $matches)) {
        requirePost('/admin/galeri');
        $admin->galeriHapus($matches[1]);
    } elseif ($uri === '/admin/anggota') {
        $admin->anggota();
    } elseif ($uri === '/admin/anggota/export') {
        $admin->anggotaExport();
    } elseif ($uri === '/admin/anggota/tambah') {
        if ($isPost) {
            $admin->anggotaSimpan();
        } else {
            $admin->anggotaTambah();
        }
    } elseif (preg_match('#^/admin/anggota/hapus/(\d+)$#', $uri, $matches)) {
        requirePost('/admin/anggota');
        $admin->anggotaHapus($matches[1]);
    } elseif (preg_match('#^/admin/anggota/edit/(\d+)$#', $uri, $matches)) {
        $admin->anggotaEdit($matches[1]);
    } elseif (preg_match('#^/admin/anggota/update/(\d+)$#', $uri, $matches)) {
        requirePost('/admin/anggota');
        $admin->anggotaUpdate($matches[1]);
    } elseif ($uri === '/admin/slider') {
        $admin->slider();
    } elseif ($uri === '/admin/slider/tambah') {
        if ($isPost) {
            $admin->sliderSimpan();
        } else {
            $admin->sliderTambah();
        }
    } elseif (preg_match('#^/admin/slider/hapus/(\d+)$#', $uri, $matches)) {
        requirePost('/admin/slider');
        $admin->sliderHapus($matches[1]);
    } elseif ($uri === '/admin/password') {
        if ($isPost) {
            $admin->passwordUpdate();
        } else {
            $admin->passwordForm();
        }
    } else {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404_admin.php';
    }
} 
// 404 Umum
else {
    http_response_code(404);
    require_once __DIR__ . '/../views/errors/404.php';
}

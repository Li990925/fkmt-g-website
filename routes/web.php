<?php
use app\Controllers\PublikController;
use app\Controllers\AdminController;
use app\Controllers\AuthController;

$publik = new PublikController();
$admin = new AdminController();
$auth = new AuthController();

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
elseif (strpos($uri, '/admin') === 0) {
    // Cek apakah admin sudah login
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: /login');
        exit;
    }
    
    if ($uri === '/admin') {
        $admin->dashboard();
    } elseif ($uri === '/admin/berita') {
        $admin->berita();
    } elseif ($uri === '/admin/berita/tambah') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin->beritaSimpan();
        } else {
            $admin->beritaTambah();
        }
    } elseif (preg_match('#^/admin/berita/hapus/(\d+)$#', $uri, $matches)) {
        $admin->beritaHapus($matches[1]);
    } elseif (preg_match('#^/admin/berita/edit/(\d+)$#', $uri, $matches)) {
        $admin->beritaEdit($matches[1]);
    } elseif (preg_match('#^/admin/berita/update/(\d+)$#', $uri, $matches)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin->beritaUpdate($matches[1]);
        } else {
            header('Location: /admin/berita');
            exit;
        }
    } elseif ($uri === '/admin/pengurus') {
        $admin->pengurus();
    } elseif ($uri === '/admin/pengurus/tambah') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin->pengurusSimpan();
        } else {
            $admin->pengurusTambah();
        }
    } elseif (preg_match('#^/admin/pengurus/hapus/(\d+)$#', $uri, $matches)) {
        $admin->pengurusHapus($matches[1]);
    } elseif (preg_match('#^/admin/pengurus/edit/(\d+)$#', $uri, $matches)) {
        $admin->pengurusEdit($matches[1]);
    } elseif (preg_match('#^/admin/pengurus/update/(\d+)$#', $uri, $matches)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin->pengurusUpdate($matches[1]);
        } else {
            header('Location: /admin/pengurus');
            exit;
        }
    } elseif ($uri === '/admin/galeri') {
        $admin->galeri();
    } elseif ($uri === '/admin/galeri/tambah') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin->galeriSimpan();
        } else {
            $admin->galeriTambah();
        }
    } elseif (preg_match('#^/admin/galeri/hapus/(\d+)$#', $uri, $matches)) {
        $admin->galeriHapus($matches[1]);
    } elseif ($uri === '/admin/anggota') {
        $admin->anggota();
    } elseif ($uri === '/admin/anggota/export') {
        $admin->anggotaExport();
    } elseif ($uri === '/admin/anggota/tambah') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin->anggotaSimpan();
        } else {
            $admin->anggotaTambah();
        }
    } elseif (preg_match('#^/admin/anggota/hapus/(\d+)$#', $uri, $matches)) {
        $admin->anggotaHapus($matches[1]);
    } elseif (preg_match('#^/admin/anggota/edit/(\d+)$#', $uri, $matches)) {
        $admin->anggotaEdit($matches[1]);
    } elseif (preg_match('#^/admin/anggota/update/(\d+)$#', $uri, $matches)) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin->anggotaUpdate($matches[1]);
        } else {
            header('Location: /admin/anggota');
            exit;
        }
    } elseif ($uri === '/admin/slider') {
        $admin->slider();
    } elseif ($uri === '/admin/slider/tambah') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin->sliderSimpan();
        } else {
            $admin->sliderTambah();
        }
    } elseif (preg_match('#^/admin/slider/hapus/(\d+)$#', $uri, $matches)) {
        $admin->sliderHapus($matches[1]);
    } elseif ($uri === '/admin/password') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

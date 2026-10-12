<?php
// Jika request mengarah ke file statis fisik (CSS, JS, gambar) pada PHP built-in server, layani langsung
if (php_sapi_name() === 'cli-server') {
    $filePath = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($filePath)) {
        return false;
    }
}

// Pengaturan keamanan session
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Autoloader sederhana untuk memuat class secara otomatis berdasarkan namespace
spl_autoload_register(function ($class) {
    // Ubah namespace (app\Controllers) menjadi path file (app/Controllers)
    $file = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Muat variabel lingkungan (.env)
\app\Config\Env::load(__DIR__ . '/../.env');

// Atur pelaporan error sesuai mode APP_DEBUG
if (\app\Config\Env::get('APP_DEBUG', true)) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Deteksi URI yang diakses
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Muat file routing
require_once __DIR__ . '/../routes/web.php';

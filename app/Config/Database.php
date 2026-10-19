<?php
namespace app\Config;

use PDO;
use PDOException;

class Database {
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    public $conn;
    private static $sharedConn = null;

    public function __construct() {
        $this->host = Env::get('DB_HOST', '127.0.0.1');
        $this->port = Env::get('DB_PORT', '3306');
        $this->db_name = Env::get('DB_NAME', 'fkmtg_db');
        $this->username = Env::get('DB_USER', 'root');
        $this->password = Env::get('DB_PASS', '');
    }

    public function getConnection() {
        // Gunakan ulang koneksi yang sudah ada dalam satu request
        if (self::$sharedConn instanceof PDO) {
            $this->conn = self::$sharedConn;
            return $this->conn;
        }

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Agar hasil query dikembalikan sebagai associative array
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$sharedConn = $this->conn;
        } catch(PDOException $exception) {
            error_log('Koneksi database gagal: ' . $exception->getMessage());
            self::renderConnectionError($exception);
        }

        return $this->conn;
    }

    /**
     * Tampilkan halaman error 503 dan hentikan eksekusi,
     * agar tidak terjadi Fatal Error "Call to a member function prepare() on null"
     */
    private static function renderConnectionError(PDOException $exception) {
        if (!headers_sent()) {
            http_response_code(503);
            header('Content-Type: text/html; charset=UTF-8');
            header('Retry-After: 120');
        }
        // Buang output setengah jadi (mis. dari ob_start di view)
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $detail = Env::get('APP_DEBUG', false)
            ? '<p style="color:#991B1B;font-size:.85rem;background:#FEF2F2;padding:.75rem;border-radius:8px;word-break:break-word;">' . htmlspecialchars($exception->getMessage()) . '</p>'
            : '';

        echo '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">'
            . '<title>Layanan Sedang Gangguan | FKMT-G</title></head>'
            . '<body style="margin:0;font-family:system-ui,sans-serif;background:#F8FAFC;display:flex;align-items:center;justify-content:center;min-height:100vh;">'
            . '<div style="background:#fff;max-width:520px;margin:1rem;padding:2.5rem 2rem;border-radius:16px;border:1px solid #E2E8F0;text-align:center;box-shadow:0 4px 20px rgba(0,0,0,.05);">'
            . '<div style="font-size:2.5rem;font-weight:800;color:#059669;">503</div>'
            . '<h1 style="font-size:1.3rem;color:#1E293B;">Layanan Sedang Mengalami Gangguan</h1>'
            . '<p style="color:#64748B;line-height:1.6;">Terjadi kendala pada koneksi basis data. Silakan coba beberapa saat lagi atau hubungi administrator.</p>'
            . $detail
            . '</div></body></html>';
        exit;
    }
}

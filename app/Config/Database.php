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

    public function __construct() {
        $this->host = Env::get('DB_HOST', '127.0.0.1');
        $this->port = Env::get('DB_PORT', '3306');
        $this->db_name = Env::get('DB_NAME', 'fkmtg_db');
        $this->username = Env::get('DB_USER', 'root');
        $this->password = Env::get('DB_PASS', '');
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Agar hasil query dikembalikan sebagai associative array
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            if (Env::get('APP_DEBUG', true)) {
                echo "Koneksi Database Gagal: " . $exception->getMessage();
            } else {
                echo "Terjadi kendala pada koneksi basis data. Silakan hubungi administrator.";
            }
        }

        return $this->conn;
    }
}

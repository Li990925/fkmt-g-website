<?php
namespace app\Models;

use app\Config\Database;
use PDO;

class Admin {
    private $conn;
    private $table_name = "admin";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->ensureSchema();
    }

    /**
     * Memastikan kolom nama dan role tersedia di tabel admin (self-healing migration)
     */
    public function ensureSchema() {
        try {
            $stmt = $this->conn->query("SHOW COLUMNS FROM {$this->table_name} LIKE 'role'");
            if (!$stmt->fetch()) {
                $this->conn->exec("ALTER TABLE {$this->table_name} ADD COLUMN nama VARCHAR(100) DEFAULT NULL AFTER username");
                $this->conn->exec("ALTER TABLE {$this->table_name} ADD COLUMN role ENUM('super_admin', 'admin') NOT NULL DEFAULT 'admin' AFTER password");
                $this->conn->exec("UPDATE {$this->table_name} SET role = 'super_admin', nama = 'Administrator Utama' WHERE id = 1");
            }
        } catch (\Exception $e) {
            // Abaikan jika tidak memiliki izin DDL, biarkan fallback
        }
    }

    public function getAll() {
        $query = "SELECT id, username, nama, role, created_at FROM " . $this->table_name . " ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE LOWER(username) = LOWER(:username) LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isUsernameTaken($username, $excludeId = null) {
        if ($excludeId) {
            $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE LOWER(username) = LOWER(:username) AND id != :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':id', $excludeId, PDO::PARAM_INT);
        } else {
            $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE LOWER(username) = LOWER(:username)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
        }
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return ((int)($res['total'] ?? 0)) > 0;
    }

    public function countSuperAdmins() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE role = 'super_admin'";
        $stmt = $this->conn->query($query);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($res['total'] ?? 0);
    }

    public function create($username, $nama, $password, $role = 'admin') {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO " . $this->table_name . " (username, nama, password, role) VALUES (:username, :nama, :password, :role)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':password', $hashed);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    public function update($id, $username, $nama, $role, $newPassword = null) {
        if (!empty($newPassword)) {
            $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
            $query = "UPDATE " . $this->table_name . " SET username = :username, nama = :nama, role = :role, password = :password WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $hashed);
        } else {
            $query = "UPDATE " . $this->table_name . " SET username = :username, nama = :nama, role = :role WHERE id = :id";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updatePassword($id, $hashedPassword) {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateUsername($id, $newUsername) {
        $query = "UPDATE " . $this->table_name . " SET username = :username WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $newUsername);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}


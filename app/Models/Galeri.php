<?php
namespace app\Models;

use app\Config\Database;
use PDO;

class Galeri {
    private $conn;
    private $table_name = "galeri";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($judul, $foto) {
        $query = "INSERT INTO " . $this->table_name . " (judul, foto) VALUES (:judul, :foto)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':foto', $foto);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

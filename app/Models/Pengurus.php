<?php
namespace app\Models;

use app\Config\Database;
use PDO;

class Pengurus {
    private $conn;
    private $table_name = "pengurus";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY urutan ASC, created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($nama, $jabatan, $kategori, $urutan, $deskripsi, $foto) {
        $query = "INSERT INTO " . $this->table_name . " (nama, jabatan, kategori, urutan, deskripsi, foto) VALUES (:nama, :jabatan, :kategori, :urutan, :deskripsi, :foto)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':jabatan', $jabatan);
        $stmt->bindParam(':kategori', $kategori);
        $stmt->bindParam(':urutan', $urutan);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':foto', $foto);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function readById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nama, $jabatan, $kategori, $urutan, $deskripsi, $foto = null) {
        if ($foto !== null) {
            $query = "UPDATE " . $this->table_name . " SET nama = :nama, jabatan = :jabatan, kategori = :kategori, urutan = :urutan, deskripsi = :deskripsi, foto = :foto WHERE id = :id";
        } else {
            $query = "UPDATE " . $this->table_name . " SET nama = :nama, jabatan = :jabatan, kategori = :kategori, urutan = :urutan, deskripsi = :deskripsi WHERE id = :id";
        }
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':jabatan', $jabatan);
        $stmt->bindParam(':kategori', $kategori);
        $stmt->bindParam(':urutan', $urutan);
        $stmt->bindParam(':deskripsi', $deskripsi);
        
        if ($foto !== null) {
            $stmt->bindParam(':foto', $foto);
        }
        
        return $stmt->execute();
    }
}

<?php
namespace app\Models;

use app\Config\Database;
use PDO;

class Berita {
    private $conn;
    private $table_name = "berita";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function searchAndFilter($keyword = null, $kategori = null) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE 1=1";
        $params = [];
        if (!empty($keyword)) {
            $sql .= " AND (judul LIKE :kw1 OR konten LIKE :kw2)";
            $params[':kw1'] = '%' . $keyword . '%';
            $params[':kw2'] = '%' . $keyword . '%';
        }
        if (!empty($kategori) && strtolower($kategori) !== 'semua') {
            $sql .= " AND LOWER(kategori) = :kat";
            $params[':kat'] = strtolower($kategori);
        }
        $sql .= " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCategories() {
        $sql = "SELECT DISTINCT kategori FROM " . $this->table_name . " WHERE kategori IS NOT NULL AND kategori != '' ORDER BY kategori ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function readById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function readBySlug($slug) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE slug = :slug LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function isSlugExists($slug, $excludeId = null) {
        if ($excludeId) {
            $query = "SELECT COUNT(*) as cnt FROM " . $this->table_name . " WHERE slug = :slug AND id != :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':id', $excludeId);
        } else {
            $query = "SELECT COUNT(*) as cnt FROM " . $this->table_name . " WHERE slug = :slug";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':slug', $slug);
        }
        $stmt->execute();
        $row = $stmt->fetch();
        return ($row && (int)$row['cnt'] > 0);
    }

    public function readRecentExcept($excludeId, $limit = 4) {
        $limit = (int)$limit;
        $query = "SELECT * FROM " . $this->table_name . " WHERE id != :id ORDER BY created_at DESC LIMIT " . $limit;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $excludeId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($judul, $slug, $konten, $kategori, $gambar = null) {
        $query = "INSERT INTO " . $this->table_name . " (judul, slug, konten, kategori, gambar) VALUES (:judul, :slug, :konten, :kategori, :gambar)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':konten', $konten);
        $stmt->bindParam(':kategori', $kategori);
        $stmt->bindParam(':gambar', $gambar);
        
        return $stmt->execute();
    }

    public function update($id, $judul, $slug, $konten, $kategori, $gambar = null) {
        if ($gambar !== null) {
            $query = "UPDATE " . $this->table_name . " SET judul = :judul, slug = :slug, konten = :konten, kategori = :kategori, gambar = :gambar WHERE id = :id";
        } else {
            $query = "UPDATE " . $this->table_name . " SET judul = :judul, slug = :slug, konten = :konten, kategori = :kategori WHERE id = :id";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':judul', $judul);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':konten', $konten);
        $stmt->bindParam(':kategori', $kategori);
        if ($gambar !== null) {
            $stmt->bindParam(':gambar', $gambar);
        }
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

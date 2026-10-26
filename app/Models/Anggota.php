<?php
namespace app\Models;

use app\Config\Database;
use PDO;

class Anggota {
    private $conn;
    private $table_name = "anggota";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->ensureSchema();
    }

    private function ensureSchema() {
        try {
            // Pastikan kolom golongan_darah minimal varchar(20) agar aman untuk berbagai variasi input
            $this->conn->exec("ALTER TABLE " . $this->table_name . " MODIFY COLUMN golongan_darah VARCHAR(20) DEFAULT NULL");
        } catch (\Throwable $e) {
            // Abaikan jika tidak memiliki izin ALTER atau sudah sesuai
        }
    }

    public function readAll($angkatanFilter = null, $sort = null) {
        $query = "SELECT * FROM " . $this->table_name;
        if (!empty($angkatanFilter)) {
            $query .= " WHERE angkatan = :angkatan";
        }
        
        if ($sort === 'nama_asc') {
            $query .= " ORDER BY nama ASC";
        } elseif ($sort === 'nama_desc') {
            $query .= " ORDER BY nama DESC";
        } elseif ($sort === 'terlama') {
            $query .= " ORDER BY created_at ASC";
        } else {
            $query .= " ORDER BY created_at DESC";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if (!empty($angkatanFilter)) {
            $stmt->bindParam(':angkatan', $angkatanFilter);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($nama, $alamat, $kampus, $fakultas, $jurusan, $angkatan, $no_wa, $email, $golongan_darah) {
        $query = "INSERT INTO " . $this->table_name . " (nama, alamat, kampus, fakultas, jurusan, angkatan, no_wa, email, golongan_darah) VALUES (:nama, :alamat, :kampus, :fakultas, :jurusan, :angkatan, :no_wa, :email, :golongan_darah)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':alamat', $alamat);
        $stmt->bindParam(':kampus', $kampus);
        $stmt->bindParam(':fakultas', $fakultas);
        $stmt->bindParam(':jurusan', $jurusan);
        $stmt->bindParam(':angkatan', $angkatan);
        $stmt->bindParam(':no_wa', $no_wa);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':golongan_darah', $golongan_darah);
        
        return $stmt->execute();
    }

    public function readById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function update($id, $nama, $alamat, $kampus, $fakultas, $jurusan, $angkatan, $no_wa, $email, $golongan_darah) {
        $query = "UPDATE " . $this->table_name . " 
                  SET nama = :nama, 
                      alamat = :alamat, 
                      kampus = :kampus, 
                      fakultas = :fakultas, 
                      jurusan = :jurusan, 
                      angkatan = :angkatan,
                      no_wa = :no_wa, 
                      email = :email, 
                      golongan_darah = :golongan_darah 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':alamat', $alamat);
        $stmt->bindParam(':kampus', $kampus);
        $stmt->bindParam(':fakultas', $fakultas);
        $stmt->bindParam(':jurusan', $jurusan);
        $stmt->bindParam(':angkatan', $angkatan);
        $stmt->bindParam(':no_wa', $no_wa);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':golongan_darah', $golongan_darah);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteAll($angkatan = null) {
        if (!empty($angkatan)) {
            $query = "DELETE FROM " . $this->table_name . " WHERE angkatan = :angkatan";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':angkatan', $angkatan, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } else {
            $query = "DELETE FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $deletedCount = $stmt->rowCount();
            try {
                $this->conn->exec("ALTER TABLE " . $this->table_name . " AUTO_INCREMENT = 1");
            } catch (\Throwable $e) {}
            return $deletedCount;
        }
    }
}

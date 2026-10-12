<?php
namespace app\Controllers;

class AdminController {
    public function dashboard() {
        global $uri;
        
        $db = new \app\Config\Database();
        $conn = $db->getConnection();
        
        $totalBerita = (int)$conn->query("SELECT COUNT(*) as total FROM berita")->fetch()['total'];
        $totalPengurus = (int)$conn->query("SELECT COUNT(*) as total FROM pengurus")->fetch()['total'];
        $totalAnggota = (int)$conn->query("SELECT COUNT(*) as total FROM anggota")->fetch()['total'];
        $totalGaleri = (int)$conn->query("SELECT COUNT(*) as total FROM galeri")->fetch()['total'];
        $totalSlider = (int)$conn->query("SELECT COUNT(*) as total FROM slider")->fetch()['total'];

        // Data aktivitas terbaru untuk dashboard
        $recentBerita = $conn->query("SELECT id, judul, slug, kategori, created_at FROM berita ORDER BY created_at DESC LIMIT 4")->fetchAll();
        $recentPengurus = $conn->query("SELECT id, nama, jabatan, kategori FROM pengurus ORDER BY id ASC LIMIT 4")->fetchAll();
        $recentAnggota = $conn->query("SELECT id, nama, kampus, angkatan FROM anggota ORDER BY id DESC LIMIT 4")->fetchAll();

        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function berita() {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Berita.php';
        
        $beritaModel = new \app\Models\Berita();
        $semuaBerita = $beritaModel->readAll();
        
        require_once __DIR__ . '/../../views/admin/berita_index.php';
    }

    public function beritaTambah() {
        global $uri;
        require_once __DIR__ . '/../../views/admin/berita_tambah.php';
    }

    public function beritaSimpan() {
        require_once __DIR__ . '/../../app/Models/Berita.php';
        $beritaModel = new \app\Models\Berita();
        
        $judul = trim($_POST['judul'] ?? '');
        $kategori = $_POST['kategori'] ?? 'Umum';
        $konten = trim($_POST['konten'] ?? '');
        
        if (!empty($judul) && !empty($konten)) {
            // Generate unique slug
            $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul), '-'));
            if (empty($baseSlug)) {
                $baseSlug = 'berita-' . time();
            }
            $slug = $baseSlug;
            $counter = 1;
            while ($beritaModel->isSlugExists($slug)) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            // Handle optional image upload
            $gambar = null;
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assets/images/berita/';
                if (!is_dir($uploadDir)) {
                    @mkdir($uploadDir, 0755, true);
                }
                $fileExtension = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $gambarName = 'berita_' . uniqid() . '.' . $fileExtension;
                    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambarName)) {
                        $gambar = $gambarName;
                    }
                }
            }

            $beritaModel->create($judul, $slug, $konten, $kategori, $gambar);
            $_SESSION['flash_success'] = "Berita baru berhasil ditambahkan!";
        }
        
        header('Location: /admin/berita');
        exit;
    }

    public function beritaEdit($id) {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Berita.php';
        $beritaModel = new \app\Models\Berita();
        $b = $beritaModel->readById($id);
        
        if (!$b) {
            $_SESSION['flash_error'] = "Berita tidak ditemukan!";
            header('Location: /admin/berita');
            exit;
        }
        
        require_once __DIR__ . '/../../views/admin/berita_edit.php';
    }

    public function beritaUpdate($id) {
        require_once __DIR__ . '/../../app/Models/Berita.php';
        $beritaModel = new \app\Models\Berita();
        
        $current = $beritaModel->readById($id);
        if (!$current) {
            $_SESSION['flash_error'] = "Berita tidak ditemukan!";
            header('Location: /admin/berita');
            exit;
        }
        
        $judul = trim($_POST['judul'] ?? '');
        $kategori = $_POST['kategori'] ?? 'Umum';
        $konten = trim($_POST['konten'] ?? '');
        
        if (!empty($judul) && !empty($konten)) {
            // Generate unique slug
            $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul), '-'));
            if (empty($baseSlug)) {
                $baseSlug = 'berita-' . $id;
            }
            $slug = $baseSlug;
            $counter = 1;
            while ($beritaModel->isSlugExists($slug, $id)) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            // Handle optional new image upload
            $gambar = null; // null means keep existing image
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/assets/images/berita/';
                if (!is_dir($uploadDir)) {
                    @mkdir($uploadDir, 0755, true);
                }
                $fileExtension = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $gambarName = 'berita_' . uniqid() . '.' . $fileExtension;
                    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambarName)) {
                        $gambar = $gambarName;
                        // Hapus file gambar lama jika ada
                        if (!empty($current['gambar'])) {
                            $oldFile = $uploadDir . $current['gambar'];
                            if (file_exists($oldFile)) {
                                @unlink($oldFile);
                            }
                        }
                    }
                }
            }

            $beritaModel->update($id, $judul, $slug, $konten, $kategori, $gambar);
            $_SESSION['flash_success'] = "Perubahan data berita berhasil disimpan!";
        }
        
        header('Location: /admin/berita');
        exit;
    }

    public function beritaHapus($id) {
        require_once __DIR__ . '/../../app/Models/Berita.php';
        $beritaModel = new \app\Models\Berita();
        
        $current = $beritaModel->readById($id);
        if ($current && !empty($current['gambar'])) {
            $filePath = __DIR__ . '/../../public/assets/images/berita/' . $current['gambar'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
        
        $beritaModel->delete($id);
        $_SESSION['flash_success'] = "Berita berhasil dihapus!";
        
        header('Location: /admin/berita');
        exit;
    }

    public function pengurus() {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Pengurus.php';
        
        $pengurusModel = new \app\Models\Pengurus();
        $semuaPengurus = $pengurusModel->readAll();
        
        require_once __DIR__ . '/../../views/admin/pengurus_index.php';
    }

    public function pengurusTambah() {
        global $uri;
        require_once __DIR__ . '/../../views/admin/pengurus_tambah.php';
    }

    public function pengurusSimpan() {
        require_once __DIR__ . '/../../app/Models/Pengurus.php';
        $pengurusModel = new \app\Models\Pengurus();
        
        $nama = $_POST['nama'] ?? '';
        $jabatan = $_POST['jabatan'] ?? '';
        $kategori = $_POST['kategori'] ?? 'bidang';
        $urutan = $_POST['urutan'] ?? 0;
        $deskripsi = $_POST['deskripsi'] ?? '';
        $foto = null;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/assets/images/pengurus/';
            $fileExtension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            
            if (in_array($fileExtension, $allowedExtensions) && $_FILES['foto']['size'] <= $maxFileSize) {
                $fotoName = uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fotoName;
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
                    $foto = $fotoName;
                }
            }
        }
        
        if (!empty($nama) && !empty($jabatan)) {
            $pengurusModel->create($nama, $jabatan, $kategori, $urutan, $deskripsi, $foto);
            $_SESSION['flash_success'] = "Data pengurus baru berhasil ditambahkan!";
        }
        
        header('Location: /admin/pengurus');
        exit;
    }

    public function pengurusHapus($id) {
        require_once __DIR__ . '/../../app/Models/Pengurus.php';
        $pengurusModel = new \app\Models\Pengurus();
        
        $p = $pengurusModel->readById($id);
        if ($p && !empty($p['foto'])) {
            $filePath = __DIR__ . '/../../public/assets/images/pengurus/' . $p['foto'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $pengurusModel->delete($id);
        $_SESSION['flash_success'] = "Data pengurus berhasil dihapus!";
        
        header('Location: /admin/pengurus');
        exit;
    }

    public function pengurusEdit($id) {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Pengurus.php';
        $pengurusModel = new \app\Models\Pengurus();
        
        $p = $pengurusModel->readById($id);
        
        if (!$p) {
            $_SESSION['flash_error'] = "Data pengurus tidak ditemukan!";
            header('Location: /admin/pengurus');
            exit;
        }
        
        require_once __DIR__ . '/../../views/admin/pengurus_edit.php';
    }

    public function pengurusUpdate($id) {
        require_once __DIR__ . '/../../app/Models/Pengurus.php';
        $pengurusModel = new \app\Models\Pengurus();
        
        $nama = $_POST['nama'] ?? '';
        $jabatan = $_POST['jabatan'] ?? '';
        $kategori = $_POST['kategori'] ?? 'bidang';
        $urutan = $_POST['urutan'] ?? 0;
        $deskripsi = $_POST['deskripsi'] ?? '';
        $foto = null;
        
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/assets/images/pengurus/';
            $fileExtension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            
            if (in_array($fileExtension, $allowedExtensions) && $_FILES['foto']['size'] <= $maxFileSize) {
                $fotoName = uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fotoName;
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
                    $foto = $fotoName;
                    
                    // hapus foto lama
                    $p = $pengurusModel->readById($id);
                    if ($p && !empty($p['foto'])) {
                        $oldFilePath = $uploadDir . $p['foto'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                }
            }
        }
        
        if (!empty($nama) && !empty($jabatan)) {
            $pengurusModel->update($id, $nama, $jabatan, $kategori, $urutan, $deskripsi, $foto);
            $_SESSION['flash_success'] = "Perubahan data pengurus berhasil disimpan!";
        }
        
        header('Location: /admin/pengurus');
        exit;
    }

    public function anggota() {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Anggota.php';
        
        $anggotaModel = new \app\Models\Anggota();
        $angkatanFilter = $_GET['angkatan'] ?? null;
        $sort = $_GET['sort'] ?? null;
        
        $semuaAnggota = $anggotaModel->readAll($angkatanFilter, $sort);
        
        require_once __DIR__ . '/../../views/admin/anggota_index.php';
    }

    public function anggotaTambah() {
        global $uri;
        require_once __DIR__ . '/../../views/admin/anggota_tambah.php';
    }

    public function anggotaSimpan() {
        require_once __DIR__ . '/../../app/Models/Anggota.php';
        $anggotaModel = new \app\Models\Anggota();
        
        $nama = $_POST['nama'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $kampus = $_POST['kampus'] ?? '';
        $fakultas = $_POST['fakultas'] ?? '';
        $jurusan = $_POST['jurusan'] ?? '';
        $angkatan = !empty($_POST['angkatan']) ? (int)$_POST['angkatan'] : null;
        $no_wa = $_POST['no_wa'] ?? '';
        $email = $_POST['email'] ?? '';
        $golongan_darah = $_POST['golongan_darah'] ?? '';
        
        if (!empty($nama) && !empty($kampus)) {
            $anggotaModel->create($nama, $alamat, $kampus, $fakultas, $jurusan, $angkatan, $no_wa, $email, $golongan_darah);
            $_SESSION['flash_success'] = "Data anggota baru berhasil ditambahkan!";
        }
        
        header('Location: /admin/anggota');
        exit;
    }

    public function anggotaEdit($id) {
        require_once __DIR__ . '/../../app/Models/Anggota.php';
        $anggotaModel = new \app\Models\Anggota();
        $anggota = $anggotaModel->readById($id);
        
        if (!$anggota) {
            $_SESSION['flash_error'] = "Data anggota tidak ditemukan!";
            header('Location: /admin/anggota');
            exit;
        }
        
        require_once __DIR__ . '/../../views/admin/anggota_edit.php';
    }

    public function anggotaUpdate($id) {
        require_once __DIR__ . '/../../app/Models/Anggota.php';
        $anggotaModel = new \app\Models\Anggota();
        
        $nama = $_POST['nama'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $kampus = $_POST['kampus'] ?? '';
        $fakultas = $_POST['fakultas'] ?? '';
        $jurusan = $_POST['jurusan'] ?? '';
        $angkatan = !empty($_POST['angkatan']) ? (int)$_POST['angkatan'] : null;
        $no_wa = $_POST['no_wa'] ?? '';
        $email = $_POST['email'] ?? '';
        $golongan_darah = $_POST['golongan_darah'] ?? '';
        
        if (!empty($nama) && !empty($kampus)) {
            $anggotaModel->update($id, $nama, $alamat, $kampus, $fakultas, $jurusan, $angkatan, $no_wa, $email, $golongan_darah);
            $_SESSION['flash_success'] = "Perubahan data anggota berhasil disimpan!";
        }
        
        header('Location: /admin/anggota');
        exit;
    }

    public function anggotaHapus($id) {
        require_once __DIR__ . '/../../app/Models/Anggota.php';
        $anggotaModel = new \app\Models\Anggota();
        $anggotaModel->delete($id);
        $_SESSION['flash_success'] = "Data anggota berhasil dihapus!";
        
        header('Location: /admin/anggota');
        exit;
    }

    public function anggotaExport() {
        require_once __DIR__ . '/../../app/Models/Anggota.php';
        $anggotaModel = new \app\Models\Anggota();
        $data = $anggotaModel->readAll();

        $filename = 'data_anggota_fkmtg_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        // UTF-8 BOM for Microsoft Excel compatibility
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Header row
        fputcsv($output, ['No', 'Nama Lengkap', 'Kampus', 'Fakultas', 'Jurusan', 'Angkatan', 'No WhatsApp', 'Email', 'Gol. Darah', 'Alamat / Domisili', 'Tanggal Terdaftar']);

        $no = 1;
        foreach ($data as $row) {
            fputcsv($output, [
                $no++,
                $row['nama'],
                $row['kampus'],
                $row['fakultas'],
                $row['jurusan'],
                $row['angkatan'],
                $row['no_wa'],
                $row['email'] ?? '-',
                $row['golongan_darah'] ?? '-',
                $row['alamat'] ?? '-',
                date('d-m-Y H:i', strtotime($row['created_at']))
            ]);
        }

        fclose($output);
        exit;
    }

    public function galeri() {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Galeri.php';
        $galeriModel = new \app\Models\Galeri();
        $semuaGaleri = $galeriModel->readAll();
        require_once __DIR__ . '/../../views/admin/galeri_index.php';
    }

    public function galeriTambah() {
        global $uri;
        require_once __DIR__ . '/../../views/admin/galeri_tambah.php';
    }

    public function galeriSimpan() {
        require_once __DIR__ . '/../../app/Models/Galeri.php';
        $galeriModel = new \app\Models\Galeri();
        
        $judul = $_POST['judul'] ?? '';
        $foto = null;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/assets/images/galeri/';
            $fileExtension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            
            if (in_array($fileExtension, $allowedExtensions) && $_FILES['foto']['size'] <= $maxFileSize) {
                $fotoName = uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fotoName;
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
                    $foto = $fotoName;
                }
            }
        }
        
        if (!empty($judul) && !empty($foto)) {
            $galeriModel->create($judul, $foto);
            $_SESSION['flash_success'] = "Foto dokumentasi galeri berhasil diunggah!";
        }
        
        header('Location: /admin/galeri');
        exit;
    }

    public function galeriHapus($id) {
        require_once __DIR__ . '/../../app/Models/Galeri.php';
        $galeriModel = new \app\Models\Galeri();
        
        $g = $galeriModel->readById($id);
        if ($g && !empty($g['foto'])) {
            $filePath = __DIR__ . '/../../public/assets/images/galeri/' . $g['foto'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $galeriModel->delete($id);
        $_SESSION['flash_success'] = "Foto galeri berhasil dihapus!";
        
        header('Location: /admin/galeri');
        exit;
    }
    public function slider() {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Slider.php';
        $sliderModel = new \app\Models\Slider();
        $sliders = $sliderModel->readAll();
        require_once __DIR__ . '/../../views/admin/slider_index.php';
    }

    public function sliderTambah() {
        global $uri;
        require_once __DIR__ . '/../../views/admin/slider_tambah.php';
    }

    public function sliderSimpan() {
        require_once __DIR__ . '/../../app/Models/Slider.php';
        $sliderModel = new \app\Models\Slider();
        
        $foto = null;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/assets/images/slider/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileExtension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $fotoName = uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fotoName;
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadFile)) {
                    $foto = $fotoName;
                }
            }
        }
        
        if (!empty($foto)) {
            $sliderModel->create($foto);
            $_SESSION['flash_success'] = "Foto slider beranda berhasil ditambahkan!";
        }
        
        header('Location: /admin/slider');
        exit;
    }

    public function sliderHapus($id) {
        require_once __DIR__ . '/../../app/Models/Slider.php';
        $sliderModel = new \app\Models\Slider();
        
        $s = $sliderModel->readById($id);
        if ($s && !empty($s['foto'])) {
            $filePath = __DIR__ . '/../../public/assets/images/slider/' . $s['foto'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $sliderModel->delete($id);
        $_SESSION['flash_success'] = "Foto slider berhasil dihapus!";
        
        header('Location: /admin/slider');
        exit;
    }

    public function passwordForm() {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Admin.php';
        $adminModel = new \app\Models\Admin();
        
        $adminId = $_SESSION['admin_id'] ?? null;
        $admin = null;
        if ($adminId) {
            $admin = $adminModel->findById($adminId);
        }
        if (!$admin && !empty($_SESSION['admin_username'])) {
            $admin = $adminModel->findByUsername($_SESSION['admin_username']);
            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
            }
        }

        $error = $_SESSION['flash_error'] ?? null;
        $success = $_SESSION['flash_success'] ?? null;
        unset($_SESSION['flash_error'], $_SESSION['flash_success']);

        require_once __DIR__ . '/../../views/admin/password.php';
    }

    public function passwordUpdate() {
        require_once __DIR__ . '/../../app/Models/Admin.php';
        $adminModel = new \app\Models\Admin();

        $adminId = $_SESSION['admin_id'] ?? null;
        $admin = null;
        if ($adminId) {
            $admin = $adminModel->findById($adminId);
        }
        if (!$admin && !empty($_SESSION['admin_username'])) {
            $admin = $adminModel->findByUsername($_SESSION['admin_username']);
            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
            }
        }

        if (!$admin) {
            $_SESSION['flash_error'] = "Sesi admin tidak valid. Silakan login kembali.";
            header('Location: /admin/password');
            exit;
        }

        $passwordLama = $_POST['password_lama'] ?? '';
        $passwordBaru = $_POST['password_baru'] ?? '';
        $konfirmasiPassword = $_POST['konfirmasi_password'] ?? '';
        $newUsername = trim($_POST['username'] ?? '');

        // Validasi password lama
        if (!password_verify($passwordLama, $admin['password'])) {
            $_SESSION['flash_error'] = "Password lama yang Anda masukkan salah!";
            header('Location: /admin/password');
            exit;
        }

        // Validasi panjang password baru
        if (strlen($passwordBaru) < 6) {
            $_SESSION['flash_error'] = "Password baru minimal harus 6 karakter!";
            header('Location: /admin/password');
            exit;
        }

        // Validasi konfirmasi password
        if ($passwordBaru !== $konfirmasiPassword) {
            $_SESSION['flash_error'] = "Konfirmasi password baru tidak sesuai!";
            header('Location: /admin/password');
            exit;
        }

        // Update username jika diubah dan valid
        if (!empty($newUsername) && $newUsername !== $admin['username']) {
            $existing = $adminModel->findByUsername($newUsername);
            if ($existing && $existing['id'] != $admin['id']) {
                $_SESSION['flash_error'] = "Username '" . htmlspecialchars($newUsername) . "' sudah digunakan!";
                header('Location: /admin/password');
                exit;
            }
            $adminModel->updateUsername($admin['id'], $newUsername);
            $_SESSION['admin_username'] = $newUsername;
        }

        // Update password hash
        $newHash = password_hash($passwordBaru, PASSWORD_DEFAULT);
        $adminModel->updatePassword($admin['id'], $newHash);

        $_SESSION['flash_success'] = "Password akun admin berhasil diperbarui!";
        header('Location: /admin/password');
        exit;
    }
}

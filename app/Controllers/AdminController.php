<?php
namespace app\Controllers;

class AdminController {
    const MAX_UPLOAD_SIZE = 5242880; // 5MB
    const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];
    // MIME type asli => ekstensi file yang disimpan
    const ALLOWED_IMAGE_MIMES = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    // =====================================================================
    // Helper internal
    // =====================================================================

    private function imageDir($subDir) {
        return __DIR__ . '/../../public/assets/images/' . $subDir . '/';
    }

    private function redirectWithError($url, $message) {
        $_SESSION['flash_error'] = $message;
        header('Location: ' . $url);
        exit;
    }

    private function detectMime($path) {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo) {
                $mime = finfo_file($finfo, $path);
                finfo_close($finfo);
                return $mime ?: '';
            }
        }
        if (function_exists('mime_content_type')) {
            return mime_content_type($path) ?: '';
        }
        $info = @getimagesize($path);
        return $info['mime'] ?? '';
    }

    /**
     * Upload gambar dengan validasi ekstensi, MIME type asli, isi gambar, dan ukuran.
     * Folder tujuan dibuat otomatis jika belum ada.
     *
     * @return array ['file' => string|null, 'error' => string|null]
     */
    private function handleImageUpload($field, $subDir, $prefix = '', $required = false) {
        $file = $_FILES[$field] ?? null;

        if (!$file || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['file' => null, 'error' => $required ? 'Foto wajib dipilih.' : null];
        }
        if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
            return ['file' => null, 'error' => 'Ukuran file melebihi batas maksimal server (' . ini_get('upload_max_filesize') . ').'];
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['file' => null, 'error' => 'Gagal mengunggah file (kode error: ' . (int)$file['error'] . ').'];
        }
        if ($file['size'] > self::MAX_UPLOAD_SIZE) {
            return ['file' => null, 'error' => 'Ukuran file maksimal 5MB.'];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
            return ['file' => null, 'error' => 'Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.'];
        }

        // Cek isi file yang sebenarnya, bukan hanya nama/ekstensinya
        $mime = $this->detectMime($file['tmp_name']);
        if (!isset(self::ALLOWED_IMAGE_MIMES[$mime]) || @getimagesize($file['tmp_name']) === false) {
            return ['file' => null, 'error' => 'File yang diunggah bukan gambar yang valid.'];
        }

        $dir = $this->imageDir($subDir);
        if (!is_dir($dir) && !@mkdir($dir, 0755, true)) {
            return ['file' => null, 'error' => 'Folder upload tidak dapat dibuat. Periksa izin folder di server.'];
        }
        if (!is_writable($dir)) {
            return ['file' => null, 'error' => 'Folder upload tidak memiliki izin tulis.'];
        }

        // Ekstensi ditentukan dari MIME asli agar tidak bisa dimanipulasi
        $name = $prefix . bin2hex(random_bytes(8)) . '.' . self::ALLOWED_IMAGE_MIMES[$mime];
        if (!move_uploaded_file($file['tmp_name'], $dir . $name)) {
            return ['file' => null, 'error' => 'Gagal menyimpan file ke server.'];
        }

        return ['file' => $name, 'error' => null];
    }

    /**
     * Hapus file gambar secara aman (tidak menghentikan proses jika file tidak ada / gagal dihapus)
     */
    private function deleteImage($subDir, $filename) {
        if (empty($filename)) {
            return;
        }
        $path = $this->imageDir($subDir) . basename($filename);
        if (is_file($path) && !@unlink($path)) {
            error_log('Gagal menghapus file: ' . $path);
        }
    }

    /**
     * Cegah CSV/Formula Injection saat file dibuka di Excel / Spreadsheet
     */
    private function csvSafe($value) {
        $value = (string)($value ?? '');
        if (strlen($value) > 1 && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $value;
        }
        return $value;
    }

    private function generateSlug($beritaModel, $judul, $fallback, $excludeId = null) {
        $baseSlug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul), '-'));
        if (empty($baseSlug)) {
            $baseSlug = $fallback;
        }
        $slug = $baseSlug;
        $counter = 1;
        while ($beritaModel->isSlugExists($slug, $excludeId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }

    // =====================================================================
    // Dashboard
    // =====================================================================

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

    // =====================================================================
    // Berita
    // =====================================================================

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
        $kategori = trim($_POST['kategori'] ?? '') ?: 'Umum';
        $konten = trim($_POST['konten'] ?? '');
        
        if (empty($judul) || empty($konten)) {
            $this->redirectWithError('/admin/berita/tambah', 'Judul dan konten berita wajib diisi!');
        }

        // Generate unique slug
        $slug = $this->generateSlug($beritaModel, $judul, 'berita-' . time());

        // Handle optional image upload
        $upload = $this->handleImageUpload('gambar', 'berita', 'berita_');
        if ($upload['error']) {
            $this->redirectWithError('/admin/berita/tambah', 'Berita belum disimpan: ' . $upload['error']);
        }

        $beritaModel->create($judul, $slug, $konten, $kategori, $upload['file']);
        $_SESSION['flash_success'] = "Berita baru berhasil ditambahkan!";
        
        header('Location: /admin/berita');
        exit;
    }

    public function beritaEdit($id) {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Berita.php';
        $beritaModel = new \app\Models\Berita();
        $b = $beritaModel->readById($id);
        
        if (!$b) {
            $this->redirectWithError('/admin/berita', 'Berita tidak ditemukan!');
        }
        
        require_once __DIR__ . '/../../views/admin/berita_edit.php';
    }

    public function beritaUpdate($id) {
        require_once __DIR__ . '/../../app/Models/Berita.php';
        $beritaModel = new \app\Models\Berita();
        
        $current = $beritaModel->readById($id);
        if (!$current) {
            $this->redirectWithError('/admin/berita', 'Berita tidak ditemukan!');
        }
        
        $judul = trim($_POST['judul'] ?? '');
        $kategori = trim($_POST['kategori'] ?? '') ?: 'Umum';
        $konten = trim($_POST['konten'] ?? '');
        $editUrl = '/admin/berita/edit/' . (int)$id;
        
        if (empty($judul) || empty($konten)) {
            $this->redirectWithError($editUrl, 'Judul dan konten berita wajib diisi!');
        }

        // Generate unique slug
        $slug = $this->generateSlug($beritaModel, $judul, 'berita-' . (int)$id, $id);

        // Handle optional new image upload (null = tetap gunakan gambar lama)
        $upload = $this->handleImageUpload('gambar', 'berita', 'berita_');
        if ($upload['error']) {
            $this->redirectWithError($editUrl, 'Perubahan belum disimpan: ' . $upload['error']);
        }

        $beritaModel->update($id, $judul, $slug, $konten, $kategori, $upload['file']);

        // Hapus file gambar lama jika diganti
        if ($upload['file'] !== null) {
            $this->deleteImage('berita', $current['gambar'] ?? null);
        }

        $_SESSION['flash_success'] = "Perubahan data berita berhasil disimpan!";
        header('Location: /admin/berita');
        exit;
    }

    public function beritaHapus($id) {
        require_once __DIR__ . '/../../app/Models/Berita.php';
        $beritaModel = new \app\Models\Berita();
        
        $current = $beritaModel->readById($id);
        if (!$current) {
            $this->redirectWithError('/admin/berita', 'Berita tidak ditemukan!');
        }

        $beritaModel->delete($id);
        $this->deleteImage('berita', $current['gambar'] ?? null);
        $_SESSION['flash_success'] = "Berita berhasil dihapus!";
        
        header('Location: /admin/berita');
        exit;
    }

    // =====================================================================
    // Pengurus
    // =====================================================================

    private function readPengurusInput() {
        $kategori = $_POST['kategori'] ?? 'bidang';
        if (!in_array($kategori, ['inti', 'harian', 'bidang'], true)) {
            $kategori = 'bidang';
        }
        return [
            'nama'      => trim($_POST['nama'] ?? ''),
            'jabatan'   => trim($_POST['jabatan'] ?? ''),
            'kategori'  => $kategori,
            'urutan'    => (int)($_POST['urutan'] ?? 0),
            'deskripsi' => trim($_POST['deskripsi'] ?? ''),
        ];
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
        
        $in = $this->readPengurusInput();
        if (empty($in['nama']) || empty($in['jabatan'])) {
            $this->redirectWithError('/admin/pengurus/tambah', 'Nama dan jabatan pengurus wajib diisi!');
        }

        $upload = $this->handleImageUpload('foto', 'pengurus', 'pengurus_');
        if ($upload['error']) {
            $this->redirectWithError('/admin/pengurus/tambah', 'Data belum disimpan: ' . $upload['error']);
        }
        
        $pengurusModel->create($in['nama'], $in['jabatan'], $in['kategori'], $in['urutan'], $in['deskripsi'], $upload['file']);
        $_SESSION['flash_success'] = "Data pengurus baru berhasil ditambahkan!";
        
        header('Location: /admin/pengurus');
        exit;
    }

    public function pengurusHapus($id) {
        require_once __DIR__ . '/../../app/Models/Pengurus.php';
        $pengurusModel = new \app\Models\Pengurus();
        
        $p = $pengurusModel->readById($id);
        if (!$p) {
            $this->redirectWithError('/admin/pengurus', 'Data pengurus tidak ditemukan!');
        }

        $pengurusModel->delete($id);
        $this->deleteImage('pengurus', $p['foto'] ?? null);
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
            $this->redirectWithError('/admin/pengurus', 'Data pengurus tidak ditemukan!');
        }
        
        require_once __DIR__ . '/../../views/admin/pengurus_edit.php';
    }

    public function pengurusUpdate($id) {
        require_once __DIR__ . '/../../app/Models/Pengurus.php';
        $pengurusModel = new \app\Models\Pengurus();

        $current = $pengurusModel->readById($id);
        if (!$current) {
            $this->redirectWithError('/admin/pengurus', 'Data pengurus tidak ditemukan!');
        }
        
        $in = $this->readPengurusInput();
        $editUrl = '/admin/pengurus/edit/' . (int)$id;
        if (empty($in['nama']) || empty($in['jabatan'])) {
            $this->redirectWithError($editUrl, 'Nama dan jabatan pengurus wajib diisi!');
        }

        $upload = $this->handleImageUpload('foto', 'pengurus', 'pengurus_');
        if ($upload['error']) {
            $this->redirectWithError($editUrl, 'Perubahan belum disimpan: ' . $upload['error']);
        }
        
        $pengurusModel->update($id, $in['nama'], $in['jabatan'], $in['kategori'], $in['urutan'], $in['deskripsi'], $upload['file']);

        // hapus foto lama jika diganti
        if ($upload['file'] !== null) {
            $this->deleteImage('pengurus', $current['foto'] ?? null);
        }

        $_SESSION['flash_success'] = "Perubahan data pengurus berhasil disimpan!";
        header('Location: /admin/pengurus');
        exit;
    }

    // =====================================================================
    // Anggota
    // =====================================================================

    private function readAnggotaInput() {
        return [
            'nama'           => trim($_POST['nama'] ?? ''),
            'alamat'         => trim($_POST['alamat'] ?? ''),
            'kampus'         => trim($_POST['kampus'] ?? ''),
            'fakultas'       => trim($_POST['fakultas'] ?? ''),
            'jurusan'        => trim($_POST['jurusan'] ?? ''),
            'angkatan'       => !empty($_POST['angkatan']) ? (int)$_POST['angkatan'] : null,
            'no_wa'          => trim($_POST['no_wa'] ?? ''),
            'email'          => trim($_POST['email'] ?? ''),
            'golongan_darah' => trim($_POST['golongan_darah'] ?? ''),
        ];
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
        
        $in = $this->readAnggotaInput();
        if (empty($in['nama']) || empty($in['kampus'])) {
            $this->redirectWithError('/admin/anggota/tambah', 'Nama dan asal kampus wajib diisi!');
        }

        $anggotaModel->create($in['nama'], $in['alamat'], $in['kampus'], $in['fakultas'], $in['jurusan'], $in['angkatan'], $in['no_wa'], $in['email'], $in['golongan_darah']);
        $_SESSION['flash_success'] = "Data anggota baru berhasil ditambahkan!";
        
        header('Location: /admin/anggota');
        exit;
    }

    public function anggotaEdit($id) {
        global $uri;
        require_once __DIR__ . '/../../app/Models/Anggota.php';
        $anggotaModel = new \app\Models\Anggota();
        $anggota = $anggotaModel->readById($id);
        
        if (!$anggota) {
            $this->redirectWithError('/admin/anggota', 'Data anggota tidak ditemukan!');
        }
        
        require_once __DIR__ . '/../../views/admin/anggota_edit.php';
    }

    public function anggotaUpdate($id) {
        require_once __DIR__ . '/../../app/Models/Anggota.php';
        $anggotaModel = new \app\Models\Anggota();
        
        $in = $this->readAnggotaInput();
        if (empty($in['nama']) || empty($in['kampus'])) {
            $this->redirectWithError('/admin/anggota/edit/' . (int)$id, 'Nama dan asal kampus wajib diisi!');
        }

        $anggotaModel->update($id, $in['nama'], $in['alamat'], $in['kampus'], $in['fakultas'], $in['jurusan'], $in['angkatan'], $in['no_wa'], $in['email'], $in['golongan_darah']);
        $_SESSION['flash_success'] = "Perubahan data anggota berhasil disimpan!";
        
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
                $this->csvSafe($row['nama']),
                $this->csvSafe($row['kampus']),
                $this->csvSafe($row['fakultas']),
                $this->csvSafe($row['jurusan']),
                $this->csvSafe($row['angkatan']),
                $this->csvSafe($row['no_wa']),
                $this->csvSafe(!empty($row['email']) ? $row['email'] : '-'),
                $this->csvSafe(!empty($row['golongan_darah']) ? $row['golongan_darah'] : '-'),
                $this->csvSafe(!empty($row['alamat']) ? $row['alamat'] : '-'),
                !empty($row['created_at']) ? date('d-m-Y H:i', strtotime($row['created_at'])) : '-'
            ]);
        }

        fclose($output);
        exit;
    }

    // =====================================================================
    // Galeri
    // =====================================================================

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
        
        $judul = trim($_POST['judul'] ?? '');
        if (empty($judul)) {
            $this->redirectWithError('/admin/galeri/tambah', 'Judul kegiatan wajib diisi!');
        }

        $upload = $this->handleImageUpload('foto', 'galeri', 'galeri_', true);
        if ($upload['error']) {
            $this->redirectWithError('/admin/galeri/tambah', 'Foto gagal diunggah: ' . $upload['error']);
        }
        
        $galeriModel->create($judul, $upload['file']);
        $_SESSION['flash_success'] = "Foto dokumentasi galeri berhasil diunggah!";
        
        header('Location: /admin/galeri');
        exit;
    }

    public function galeriHapus($id) {
        require_once __DIR__ . '/../../app/Models/Galeri.php';
        $galeriModel = new \app\Models\Galeri();
        
        $g = $galeriModel->readById($id);
        if (!$g) {
            $this->redirectWithError('/admin/galeri', 'Foto galeri tidak ditemukan!');
        }

        $galeriModel->delete($id);
        $this->deleteImage('galeri', $g['foto'] ?? null);
        $_SESSION['flash_success'] = "Foto galeri berhasil dihapus!";
        
        header('Location: /admin/galeri');
        exit;
    }

    // =====================================================================
    // Slider
    // =====================================================================

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
        
        $upload = $this->handleImageUpload('foto', 'slider', 'slider_', true);
        if ($upload['error']) {
            $this->redirectWithError('/admin/slider/tambah', 'Foto slider gagal diunggah: ' . $upload['error']);
        }
        
        $sliderModel->create($upload['file']);
        $_SESSION['flash_success'] = "Foto slider beranda berhasil ditambahkan!";
        
        header('Location: /admin/slider');
        exit;
    }

    public function sliderHapus($id) {
        require_once __DIR__ . '/../../app/Models/Slider.php';
        $sliderModel = new \app\Models\Slider();
        
        $s = $sliderModel->readById($id);
        if (!$s) {
            $this->redirectWithError('/admin/slider', 'Foto slider tidak ditemukan!');
        }

        $sliderModel->delete($id);
        $this->deleteImage('slider', $s['foto'] ?? null);
        $_SESSION['flash_success'] = "Foto slider berhasil dihapus!";
        
        header('Location: /admin/slider');
        exit;
    }

    // =====================================================================
    // Akun Admin
    // =====================================================================

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
            $this->redirectWithError('/admin/password', 'Sesi admin tidak valid. Silakan login kembali.');
        }

        $passwordLama = $_POST['password_lama'] ?? '';
        $passwordBaru = $_POST['password_baru'] ?? '';
        $konfirmasiPassword = $_POST['konfirmasi_password'] ?? '';
        $newUsername = trim($_POST['username'] ?? '');

        // Validasi password lama
        if (!password_verify($passwordLama, $admin['password'])) {
            $this->redirectWithError('/admin/password', 'Password lama yang Anda masukkan salah!');
        }

        // Validasi panjang password baru
        if (strlen($passwordBaru) < 6) {
            $this->redirectWithError('/admin/password', 'Password baru minimal harus 6 karakter!');
        }

        // Validasi konfirmasi password
        if ($passwordBaru !== $konfirmasiPassword) {
            $this->redirectWithError('/admin/password', 'Konfirmasi password baru tidak sesuai!');
        }

        // Update username jika diubah dan valid
        if (!empty($newUsername) && $newUsername !== $admin['username']) {
            $existing = $adminModel->findByUsername($newUsername);
            if ($existing && $existing['id'] != $admin['id']) {
                $this->redirectWithError('/admin/password', "Username '" . $newUsername . "' sudah digunakan!");
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

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
        $totalUsers = (int)$conn->query("SELECT COUNT(*) as total FROM admin")->fetch()['total'];

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

    public function anggotaTemplate() {
        require_once __DIR__ . '/../../app/Helpers/ExcelHelper.php';

        $format = strtolower($_GET['format'] ?? 'xlsx');
        if ($format === 'csv') {
            $filename = 'template_data_anggota_fkmtg.csv';
            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');

            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($output, [
                'Nama Lengkap', 'Asal Kampus', 'Fakultas', 'Jurusan', 'Tahun Angkatan', 'Nomor WhatsApp', 'Email', 'Golongan Darah', 'Alamat Domisili'
            ]);
            fputcsv($output, [
                'Ahmad Fauzi', 'Universitas Negeri Gorontalo', 'Fakultas Teknik', 'Teknik Informatika', '2022', '081234567890', 'ahmad.fauzi@gmail.com', 'O', 'Jl. Trans Sulawesi, Toili'
            ]);
            fputcsv($output, [
                'Siti Nurhaliza', 'IAIN Sultan Amai Gorontalo', 'Fakultas Tarbiyah', 'Pendidikan Agama Islam', '2023', '085298765432', 'siti.nur@gmail.com', 'A', 'Desa Mansahang, Kec. Toili'
            ]);
            fclose($output);
            exit;
        }

        // Default: Unduh file Excel asli (.xlsx)
        \app\Helpers\ExcelHelper::streamTemplateXlsx('template_data_anggota_fkmtg.xlsx');
    }

    public function anggotaImportForm() {
        global $uri;
        require_once __DIR__ . '/../../views/admin/anggota_import.php';
    }

    public function anggotaImportProses() {
        require_once __DIR__ . '/../../app/Models/Anggota.php';
        require_once __DIR__ . '/../../app/Helpers/ExcelHelper.php';
        $anggotaModel = new \app\Models\Anggota();

        $file = $_FILES['file_excel'] ?? null;
        if (!$file || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            $this->redirectWithError('/admin/anggota/import', 'Silakan pilih berkas file Excel (.xlsx) atau CSV (.csv) terlebih dahulu.');
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->redirectWithError('/admin/anggota/import', 'Gagal mengunggah file (kode error: ' . (int)$file['error'] . ').');
        }

        $filename = $file['name'] ?? '';
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (!in_array($ext, ['xlsx', 'csv', 'txt'], true)) {
            $this->redirectWithError('/admin/anggota/import', 'Format file tidak didukung! Harap unggah file Microsoft Excel (.xlsx) atau CSV (.csv).');
        }

        $filepath = $file['tmp_name'];
        if (!is_uploaded_file($filepath)) {
            $this->redirectWithError('/admin/anggota/import', 'File unggahan tidak valid.');
        }

        // Baca seluruh baris data menggunakan ExcelHelper
        $allRows = \app\Helpers\ExcelHelper::parseRows($filepath, $filename);
        if ($allRows === false || empty($allRows)) {
            $this->redirectWithError('/admin/anggota/import', 'Gagal membaca berkas Excel. Pastikan berkas tidak rusak atau terproteksi kata sandi.');
        }

        $defaultAngkatan = !empty($_POST['default_angkatan']) ? (int)$_POST['default_angkatan'] : null;

        $berhasil = 0;
        $dilewati = 0;
        $angkatanSummary = [];

        // 1. Deteksi Baris Header Secara Cerdas (Smart Dynamic Header Mapping)
        $headerMap = null;
        $dataStartIndex = 0;

        for ($i = 0; $i < min(5, count($allRows)); $i++) {
            $candidateRow = $allRows[$i];
            $map = [];
            foreach ($candidateRow as $colIdx => $colVal) {
                $cleaned = strtolower(trim((string)$colVal));
                $cleaned = preg_replace('/[^a-z0-9_]/', ' ', $cleaned);
                $cleaned = trim(preg_replace('/\s+/', ' ', $cleaned));

                if (empty($cleaned)) continue;

                if (!isset($map['nama']) && (preg_match('/^(no|nomor)$/', $cleaned) === 0) && (strpos($cleaned, 'nama') !== false || strpos($cleaned, 'name') !== false || strpos($cleaned, 'anggota') !== false)) {
                    $map['nama'] = $colIdx;
                } elseif (!isset($map['kampus']) && (strpos($cleaned, 'kampus') !== false || strpos($cleaned, 'universitas') !== false || strpos($cleaned, 'univ') !== false || strpos($cleaned, 'perguruan tinggi') !== false || strpos($cleaned, 'institusi') !== false || strpos($cleaned, 'university') !== false)) {
                    $map['kampus'] = $colIdx;
                } elseif (!isset($map['fakultas']) && (strpos($cleaned, 'fakultas') !== false || strpos($cleaned, 'faculty') !== false || strpos($cleaned, 'fak') !== false)) {
                    $map['fakultas'] = $colIdx;
                } elseif (!isset($map['jurusan']) && (strpos($cleaned, 'jurusan') !== false || strpos($cleaned, 'prodi') !== false || strpos($cleaned, 'program studi') !== false || strpos($cleaned, 'major') !== false || strpos($cleaned, 'departemen') !== false)) {
                    $map['jurusan'] = $colIdx;
                } elseif (!isset($map['angkatan']) && (strpos($cleaned, 'angkatan') !== false || strpos($cleaned, 'tahun masuk') !== false || strpos($cleaned, 'thn masuk') !== false || strpos($cleaned, 'cohort') !== false || strpos($cleaned, 'batch') !== false || $cleaned === 'tahun' || $cleaned === 'year')) {
                    $map['angkatan'] = $colIdx;
                } elseif (!isset($map['no_wa']) && (strpos($cleaned, 'wa') !== false || strpos($cleaned, 'whatsapp') !== false || strpos($cleaned, 'hp') !== false || strpos($cleaned, 'telepon') !== false || strpos($cleaned, 'telp') !== false || strpos($cleaned, 'phone') !== false || strpos($cleaned, 'kontak') !== false || strpos($cleaned, 'mobile') !== false)) {
                    $map['no_wa'] = $colIdx;
                } elseif (!isset($map['email']) && (strpos($cleaned, 'email') !== false || strpos($cleaned, 'surel') !== false || strpos($cleaned, 'mail') !== false)) {
                    $map['email'] = $colIdx;
                } elseif (!isset($map['golongan_darah']) && (strpos($cleaned, 'darah') !== false || strpos($cleaned, 'goldar') !== false || strpos($cleaned, 'blood') !== false)) {
                    $map['golongan_darah'] = $colIdx;
                } elseif (!isset($map['alamat']) && (strpos($cleaned, 'alamat') !== false || strpos($cleaned, 'domisili') !== false || strpos($cleaned, 'address') !== false || strpos($cleaned, 'tempat tinggal') !== false)) {
                    $map['alamat'] = $colIdx;
                }
            }

            // Jika setidaknya menemukan kolom nama atau kampus dan total minimal 2 kolom terpetakan
            if (isset($map['nama']) || (isset($map['kampus']) && count($map) >= 2)) {
                $headerMap = $map;
                $dataStartIndex = $i + 1;
                break;
            }
        }

        // Fallback jika tidak ditemukan header tertulis
        if ($headerMap === null) {
            $firstRow = $allRows[0] ?? [];
            // Jika kolom pertama bernilai angka (contoh kolom No / urutan), geser index +1
            $isFirstColNumeric = isset($firstRow[0]) && is_numeric(trim((string)$firstRow[0]));
            $offset = $isFirstColNumeric ? 1 : 0;

            $headerMap = [
                'nama'           => 0 + $offset,
                'kampus'         => 1 + $offset,
                'fakultas'       => 2 + $offset,
                'jurusan'        => 3 + $offset,
                'angkatan'       => 4 + $offset,
                'no_wa'          => 5 + $offset,
                'email'          => 6 + $offset,
                'golongan_darah' => 7 + $offset,
                'alamat'         => 8 + $offset,
            ];
            $dataStartIndex = 0;
        }

        // 2. Proses Setiap Baris Data
        for ($rowIndex = $dataStartIndex; $rowIndex < count($allRows); $rowIndex++) {
            $row = $allRows[$rowIndex];

            // Lewati baris kosong
            if (empty(array_filter($row, fn($v) => trim((string)$v) !== ''))) {
                continue;
            }

            $namaRaw           = $row[$headerMap['nama'] ?? 0] ?? '';
            $kampusRaw         = $row[$headerMap['kampus'] ?? 1] ?? '';
            $fakultasRaw       = $row[$headerMap['fakultas'] ?? 2] ?? '';
            $jurusanRaw        = $row[$headerMap['jurusan'] ?? 3] ?? '';
            $angkatanRaw       = $row[$headerMap['angkatan'] ?? 4] ?? '';
            $noWaRaw           = $row[$headerMap['no_wa'] ?? 5] ?? '';
            $emailRaw          = $row[$headerMap['email'] ?? 6] ?? '';
            $golDarahRaw       = $row[$headerMap['golongan_darah'] ?? 7] ?? '';
            $alamatRaw         = $row[$headerMap['alamat'] ?? 8] ?? '';

            $nama     = mb_substr(trim((string)$namaRaw), 0, 255);
            $kampus   = mb_substr(trim((string)$kampusRaw), 0, 255);
            $fakultas = mb_substr(trim((string)$fakultasRaw), 0, 255);
            $jurusan  = mb_substr(trim((string)$jurusanRaw), 0, 255);
            $no_wa    = mb_substr(trim((string)$noWaRaw), 0, 20);
            $email    = mb_substr(trim((string)$emailRaw), 0, 255);
            $alamat   = trim((string)$alamatRaw);

            // Sanitasi cerdas Golongan Darah agar tidak error SQL data truncation
            $golDarahClean = strtoupper(trim((string)$golDarahRaw));
            if (strpos($golDarahClean, '@') !== false || mb_strlen($golDarahClean) > 20) {
                $golongan_darah = '';
            } else {
                $normBlood = preg_replace('/^(GOLONGAN\s+DARAH|GOL\.\s*DARAH|GOL\s+DARAH|GOLDAR|GOLONGAN|GOL)\s*/i', '', $golDarahClean);
                $normBlood = trim($normBlood);
                if (preg_match('/^(AB|A|B|O)(?:\s*(\+|\-|POSITIF|NEGATIF))?$/i', $normBlood, $bloodMatch)) {
                    $bType = $bloodMatch[1];
                    if (!empty($bloodMatch[2])) {
                        $bSign = (stripos($bloodMatch[2], '+') !== false || stripos($bloodMatch[2], 'pos') !== false) ? '+' : '-';
                        $bType .= $bSign;
                    }
                    $golongan_darah = $bType;
                } elseif (in_array($golDarahClean, ['-', 'TIDAK TAHU', 'BELUM TAHU', 'N/A', ''])) {
                    $golongan_darah = ($golDarahClean === '-') ? '-' : '';
                } else {
                    $golongan_darah = mb_substr($normBlood, 0, 10);
                }
            }

            // Ekstraksi Angkatan (deteksi 4 digit tahun)
            $angkatan = null;
            if (!empty($angkatanRaw)) {
                if (preg_match('/\b(19\d{2}|20\d{2})\b/', (string)$angkatanRaw, $yearMatch)) {
                    $angkatan = (int)$yearMatch[1];
                } elseif (is_numeric($angkatanRaw)) {
                    $angkatan = (int)$angkatanRaw;
                }
            }
            if (!$angkatan) {
                $angkatan = $defaultAngkatan;
            }

            // Validasi field wajib (Nama dan Kampus)
            if (empty($nama) || empty($kampus)) {
                $dilewati++;
                continue;
            }

            // Jangan masukkan baris jika ternyata masih baris judul/header yang berulang
            if (strtolower($nama) === 'nama' || strtolower($nama) === 'nama lengkap') {
                continue;
            }

            try {
                $saved = $anggotaModel->create(
                    $nama,
                    $alamat,
                    $kampus,
                    $fakultas,
                    $jurusan,
                    $angkatan,
                    $no_wa,
                    $email,
                    $golongan_darah
                );
            } catch (\Throwable $e) {
                $saved = false;
                error_log("Gagal import baris anggota: " . $e->getMessage());
            }

            if ($saved) {
                $berhasil++;
                $labelAngkatan = $angkatan ? "Angkatan {$angkatan}" : "Tanpa Angkatan";
                $angkatanSummary[$labelAngkatan] = ($angkatanSummary[$labelAngkatan] ?? 0) + 1;
            } else {
                $dilewati++;
            }
        }

        if ($berhasil > 0) {
            // Rangkum pemetaan per angkatan untuk notifikasi sukses
            $breakdown = [];
            ksort($angkatanSummary);
            foreach ($angkatanSummary as $lbl => $count) {
                $breakdown[] = "{$count} {$lbl}";
            }
            $breakdownText = !empty($breakdown) ? " (Terpetakan: " . implode(', ', $breakdown) . ")" : "";

            $msg = "Berhasil mengimpor {$berhasil} data anggota baru{$breakdownText}!";
            if ($dilewati > 0) {
                $msg .= " Catatan: {$dilewati} baris dilewati karena kolom nama/kampus kosong.";
            }
            $_SESSION['flash_success'] = $msg;
            header('Location: /admin/anggota');
            exit;
        } else {
            $this->redirectWithError('/admin/anggota/import', 'Tidak ada data valid yang dapat diimpor. Pastikan file memiliki baris data dengan kolom Nama dan Kampus yang terisi.');
        }
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

    // =====================================================================
    // Otorisasi Super Admin
    // =====================================================================

    private function requireSuperAdmin() {
        if (($_SESSION['admin_role'] ?? '') !== 'super_admin') {
            $this->redirectWithError('/admin', 'Akses ditolak: Menu ini hanya dapat diakses oleh Super Admin.');
        }
    }

    // =====================================================================
    // Kelola Pengguna / Admin (Khusus Super Admin)
    // =====================================================================

    public function users() {
        global $uri;
        $this->requireSuperAdmin();
        require_once __DIR__ . '/../../app/Models/Admin.php';
        $adminModel = new \app\Models\Admin();
        $semuaAdmin = $adminModel->getAll();
        require_once __DIR__ . '/../../views/admin/users_index.php';
    }

    public function usersTambah() {
        global $uri;
        $this->requireSuperAdmin();
        require_once __DIR__ . '/../../views/admin/users_tambah.php';
    }

    public function usersSimpan() {
        $this->requireSuperAdmin();
        require_once __DIR__ . '/../../app/Models/Admin.php';
        $adminModel = new \app\Models\Admin();

        $username = strtolower(trim($_POST['username'] ?? ''));
        $nama = trim($_POST['nama'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = trim($_POST['role'] ?? 'admin');

        if (!in_array($role, ['super_admin', 'admin'], true)) {
            $role = 'admin';
        }

        if (empty($username) || strlen($username) < 3) {
            $this->redirectWithError('/admin/users/tambah', 'Username minimal 3 karakter!');
        }

        if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $username)) {
            $this->redirectWithError('/admin/users/tambah', 'Username hanya boleh huruf, angka, underscore (_), titik (.), atau tanda hubung (-).');
        }

        if (empty($nama)) {
            $nama = ucfirst($username);
        }

        if (empty($password) || strlen($password) < 6) {
            $this->redirectWithError('/admin/users/tambah', 'Password minimal 6 karakter!');
        }

        if ($adminModel->isUsernameTaken($username)) {
            $this->redirectWithError('/admin/users/tambah', "Username '{$username}' sudah terdaftar! Gunakan username lain.");
        }

        $adminModel->create($username, $nama, $password, $role);
        $_SESSION['flash_success'] = "Akun admin baru '{$username}' berhasil ditambahkan!";
        header('Location: /admin/users');
        exit;
    }

    public function usersEdit($id) {
        global $uri;
        $this->requireSuperAdmin();
        require_once __DIR__ . '/../../app/Models/Admin.php';
        $adminModel = new \app\Models\Admin();

        $adminUser = $adminModel->findById((int)$id);
        if (!$adminUser) {
            $this->redirectWithError('/admin/users', 'Data pengguna tidak ditemukan!');
        }

        require_once __DIR__ . '/../../views/admin/users_edit.php';
    }

    public function usersUpdate($id) {
        $this->requireSuperAdmin();
        require_once __DIR__ . '/../../app/Models/Admin.php';
        $adminModel = new \app\Models\Admin();

        $id = (int)$id;
        $adminUser = $adminModel->findById($id);
        if (!$adminUser) {
            $this->redirectWithError('/admin/users', 'Data pengguna tidak ditemukan!');
        }

        $username = strtolower(trim($_POST['username'] ?? ''));
        $nama = trim($_POST['nama'] ?? '');
        $role = trim($_POST['role'] ?? 'admin');
        $newPassword = $_POST['password_baru'] ?? '';

        if (!in_array($role, ['super_admin', 'admin'], true)) {
            $role = 'admin';
        }

        if (empty($username) || strlen($username) < 3) {
            $this->redirectWithError("/admin/users/edit/{$id}", 'Username minimal 3 karakter!');
        }

        if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $username)) {
            $this->redirectWithError("/admin/users/edit/{$id}", 'Username hanya boleh huruf, angka, underscore (_), titik (.), atau tanda hubung (-).');
        }

        if (empty($nama)) {
            $nama = ucfirst($username);
        }

        // Cegah Super Admin terakhir menurunkan perannya sendiri menjadi admin biasa
        if ($adminUser['role'] === 'super_admin' && $role !== 'super_admin') {
            if ($adminModel->countSuperAdmins() <= 1) {
                $this->redirectWithError("/admin/users/edit/{$id}", 'Gagal mengubah role: Sistem harus memiliki setidaknya satu Super Admin.');
            }
        }

        if ($adminModel->isUsernameTaken($username, $id)) {
            $this->redirectWithError("/admin/users/edit/{$id}", "Username '{$username}' sudah digunakan oleh pengguna lain!");
        }

        if (!empty($newPassword) && strlen($newPassword) < 6) {
            $this->redirectWithError("/admin/users/edit/{$id}", 'Password baru minimal 6 karakter!');
        }

        $adminModel->update($id, $username, $nama, $role, !empty($newPassword) ? $newPassword : null);

        // Jika mengedit akun diri sendiri, perbarui data session
        if (($adminUser['id'] ?? 0) === (int)($_SESSION['admin_id'] ?? 0)) {
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_nama'] = $nama;
            $_SESSION['admin_role'] = $role;
        }

        $_SESSION['flash_success'] = "Data akun '{$username}' berhasil diperbarui!";
        header('Location: /admin/users');
        exit;
    }

    public function usersHapus($id) {
        $this->requireSuperAdmin();
        require_once __DIR__ . '/../../app/Models/Admin.php';
        $adminModel = new \app\Models\Admin();

        $id = (int)$id;
        $adminUser = $adminModel->findById($id);
        if (!$adminUser) {
            $this->redirectWithError('/admin/users', 'Data pengguna tidak ditemukan!');
        }

        // Cegah menghapus akun sendiri
        if ($id === (int)($_SESSION['admin_id'] ?? 0)) {
            $this->redirectWithError('/admin/users', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang aktif login!');
        }

        // Cegah menghapus super admin jika hanya tinggal satu
        if ($adminUser['role'] === 'super_admin' && $adminModel->countSuperAdmins() <= 1) {
            $this->redirectWithError('/admin/users', 'Gagal menghapus: Sistem harus memiliki setidaknya satu Super Admin.');
        }

        $adminModel->delete($id);
        $_SESSION['flash_success'] = "Akun pengguna '{$adminUser['username']}' berhasil dihapus.";
        header('Location: /admin/users');
        exit;
    }
}

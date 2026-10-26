<?php $title = "Kelola Anggota | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<!-- Toolbar Minimalis: Judul, Saringan Cepat, & Aksi Utama dalam 1 Baris Ringkas -->
<div class="table-toolbar">
    <div class="toolbar-left">
        <h1 class="table-toolbar-title">
            Data Anggota
            <span class="badge-count" title="Total Anggota"><?= count($semuaAnggota) ?></span>
        </h1>
        
        <form action="" method="GET" class="toolbar-filter-form">
            <select name="angkatan" onchange="this.form.submit()" class="compact-select" title="Saring berdasarkan Angkatan">
                <option value="">Semua Angkatan</option>
                <?php 
                $startYear = date('Y');
                for($i = $startYear; $i >= 2008; $i--) {
                    $selected = (isset($_GET['angkatan']) && $_GET['angkatan'] == $i) ? 'selected' : '';
                    echo "<option value=\"$i\" $selected>Angkatan $i</option>";
                }
                ?>
            </select>

            <select name="sort" onchange="this.form.submit()" class="compact-select" title="Urutkan Data">
                <option value="">Urutan (Terbaru)</option>
                <option value="nama_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'nama_asc') ? 'selected' : '' ?>>Nama (A-Z)</option>
                <option value="nama_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'nama_desc') ? 'selected' : '' ?>>Nama (Z-A)</option>
                <option value="terlama" <?= (isset($_GET['sort']) && $_GET['sort'] === 'terlama') ? 'selected' : '' ?>>Terlama</option>
            </select>

            <?php if (!empty($_GET['sort']) || !empty($_GET['angkatan'])): ?>
                <a href="/admin/anggota" class="compact-reset-btn" title="Reset Saringan">
                    <span>✕</span> Reset
                </a>
            <?php endif; ?>
        </form>
    </div>

    <div class="toolbar-right">
        <a href="/admin/anggota/export" class="btn-action-compact btn-export" title="Unduh Rekapitulasi Data Anggota (Excel/CSV)">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Ekspor Excel
        </a>
        <a href="/admin/anggota/import" class="btn-action-compact btn-import" title="Unggah / Impor Data Anggota Massal dari File Excel atau CSV">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="17 8 12 3 7 8"></polyline>
                <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
            Impor Excel
        </a>
        <a href="/admin/anggota/tambah" class="btn-action-compact btn-add" title="Tambah Anggota Baru">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Anggota
        </a>
    </div>
</div>

<!-- Card Tabel Anggota dengan Internal Scroll & Sticky Header -->
<div class="table-card">
    <div class="table-scroll-wrapper">
        <table class="table-compact">
            <thead class="sticky-table-header">
                <tr>
                    <th style="width: 44px; text-align: center; padding-left: 0.85rem;">No</th>
                    <th style="min-width: 170px;">Nama & Alamat</th>
                    <th style="min-width: 130px;">Kampus</th>
                    <th style="min-width: 140px;">Fakultas / Jurusan</th>
                    <th style="width: 80px; text-align: center;">Angkatan</th>
                    <th style="min-width: 135px;">Kontak</th>
                    <th style="width: 55px; text-align: center;">Gol</th>
                    <th style="width: 115px; text-align: right; padding-right: 0.85rem;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($semuaAnggota)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 3rem 1rem; color: #64748B;">
                            <div style="font-size: 2rem; margin-bottom: 0.4rem;">📂</div>
                            <div style="font-weight: 600; color: #334155; margin-bottom: 0.2rem; font-size: 0.95rem;">Belum ada data anggota</div>
                            <div style="font-size: 0.8rem; color: #94A3B8;">Gunakan tombol <strong>Tambah</strong> atau <strong>Impor Excel</strong> untuk menambahkan data.</div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($semuaAnggota as $a): ?>
                    <tr>
                        <td style="text-align: center; color: #94A3B8; font-weight: 500; font-size: 0.76rem; padding-left: 0.85rem;"><?= $no++ ?></td>
                        <td>
                            <div style="font-weight: 600; color: #064E3B; font-size: 0.84rem; line-height: 1.25;"><?= htmlspecialchars($a['nama']) ?></div>
                            <?php if (!empty($a['alamat'])): ?>
                                <div style="font-size: 0.72rem; color: #64748B; margin-top: 0.15rem; max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($a['alamat']) ?>">
                                    <?= htmlspecialchars($a['alamat']) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="font-weight: 500; color: #1E293B; font-size: 0.82rem; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($a['kampus']) ?>">
                                <?= htmlspecialchars($a['kampus']) ?>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500; color: #1E293B; font-size: 0.8rem; line-height: 1.25;"><?= htmlspecialchars($a['fakultas'] ?? '-') ?></div>
                            <div style="font-size: 0.72rem; color: #64748B; max-width: 160px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= htmlspecialchars($a['jurusan'] ?? '-') ?></div>
                        </td>
                        <td style="text-align: center;">
                            <span style="background: #F0FDF4; color: #166534; font-weight: 600; font-size: 0.76rem; padding: 0.15rem 0.45rem; border-radius: 4px; border: 1px solid #DCFCE7;">
                                <?= htmlspecialchars($a['angkatan'] ?? '-') ?>
                            </span>
                        </td>
                        <td>
                            <?php if (!empty($a['no_wa']) && $a['no_wa'] !== '-'): ?>
                                <div style="font-size: 0.76rem; color: #1E293B; white-space: nowrap; line-height: 1.3;">
                                    <span style="color: #059669; font-weight: 600; font-size: 0.7rem;">WA:</span> <?= htmlspecialchars($a['no_wa']) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($a['email']) && $a['email'] !== '-'): ?>
                                <div style="font-size: 0.72rem; color: #64748B; max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; line-height: 1.3;" title="<?= htmlspecialchars($a['email']) ?>">
                                    <?= htmlspecialchars($a['email']) ?>
                                </div>
                            <?php endif; ?>
                            <?php if ((empty($a['no_wa']) || $a['no_wa'] === '-') && (empty($a['email']) || $a['email'] === '-')): ?>
                                <span style="color: #CBD5E1; font-size: 0.75rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php if (!empty($a['golongan_darah']) && $a['golongan_darah'] !== '-'): ?>
                                <span style="font-weight: 700; font-size: 0.74rem; color: #DC2626; background: #FEF2F2; padding: 0.12rem 0.4rem; border-radius: 4px; border: 1px solid #FEE2E2;">
                                    <?= htmlspecialchars($a['golongan_darah']) ?>
                                </span>
                            <?php else: ?>
                                <span style="color: #CBD5E1; font-size: 0.75rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: right; white-space: nowrap; padding-right: 0.85rem;">
                            <a href="/admin/anggota/edit/<?= $a['id'] ?>" class="btn-table-edit">Edit</a>
                            <a href="/admin/anggota/hapus/<?= $a['id'] ?>" class="btn-table-delete btn-delete">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

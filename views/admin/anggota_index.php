<?php $title = "Kelola Anggota | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Data Anggota FKMT-G</h1>
    
    <div style="display: flex; gap: 1rem; align-items: center;">
        <form action="" method="GET" style="display: flex; gap: 0.5rem; align-items: center;">
            <select name="sort" style="padding: 0.6rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; background-color: white;">
                <option value="">Urutkan (Terbaru)</option>
                <option value="nama_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'nama_asc') ? 'selected' : '' ?>>Nama (A-Z)</option>
                <option value="nama_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'nama_desc') ? 'selected' : '' ?>>Nama (Z-A)</option>
                <option value="terlama" <?= (isset($_GET['sort']) && $_GET['sort'] === 'terlama') ? 'selected' : '' ?>>Terlama</option>
            </select>

            <select name="angkatan" style="padding: 0.6rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; background-color: white;">
                <option value="">Semua Angkatan</option>
                <?php 
                $startYear = date('Y');
                for($i = $startYear; $i >= 2008; $i--) {
                    $selected = (isset($_GET['angkatan']) && $_GET['angkatan'] == $i) ? 'selected' : '';
                    echo "<option value=\"$i\" $selected>$i</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn-primary" style="padding: 0.6rem 1rem; font-size: 0.9rem; border: none; background-color: #059669; cursor: pointer;">Filter</button>
        </form>

        <a href="/admin/anggota/export" class="btn-primary" style="padding: 0.8rem 1.25rem; font-size: 0.9rem; background-color: #0D9488; display: inline-flex; align-items: center; gap: 0.4rem; text-decoration: none;" title="Unduh Rekapitulasi Data Anggota (CSV/Excel)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            Ekspor Excel
        </a>
        <a href="/admin/anggota/tambah" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem;">+ Tambah Anggota</a>
    </div>
</div>

<div class="card">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #E2E8F0; color: #64748B;">
                    <th style="padding: 1rem 0;">No</th>
                    <th style="padding: 1rem;">Nama</th>
                    <th style="padding: 1rem;">Kampus</th>
                    <th style="padding: 1rem;">Fakultas / Jurusan</th>
                    <th style="padding: 1rem;">Angkatan</th>
                    <th style="padding: 1rem;">Kontak</th>
                    <th style="padding: 1rem;">Gol. Darah</th>
                    <th style="padding: 1rem; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($semuaAnggota)): ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 2rem;">Belum ada data anggota.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($semuaAnggota as $a): ?>
                    <tr style="border-bottom: 1px solid #F1F5F9;">
                        <td style="padding: 1rem 0;"><?= $no++ ?></td>
                        <td style="padding: 1rem; font-weight: 600; color: #064E3B;">
                            <?= htmlspecialchars($a['nama']) ?>
                            <div style="font-size: 0.8rem; font-weight: normal; color: #64748B; margin-top:0.2rem;"><?= htmlspecialchars($a['alamat'] ?? '') ?></div>
                        </td>
                        <td style="padding: 1rem;"><?= htmlspecialchars($a['kampus']) ?></td>
                        <td style="padding: 1rem;">
                            <?= htmlspecialchars($a['fakultas'] ?? '-') ?><br>
                            <small style="color: #64748B;"><?= htmlspecialchars($a['jurusan'] ?? '-') ?></small>
                        </td>
                        <td style="padding: 1rem; font-weight: 600; color: #064E3B;"><?= htmlspecialchars($a['angkatan'] ?? '-') ?></td>
                        <td style="padding: 1rem;">
                            WA: <span style="color: #64748B;"><?= htmlspecialchars($a['no_wa'] ?? '-') ?></span><br>
                            Email: <small style="color: #64748B;"><?= htmlspecialchars($a['email'] ?? '-') ?></small>
                        </td>
                        <td style="padding: 1rem; color: #EF4444; font-weight: 600;"><?= htmlspecialchars($a['golongan_darah'] ?? '-') ?></td>
                        <td style="padding: 1rem; text-align: right;">
                            <a href="/admin/anggota/edit/<?= $a['id'] ?>" style="color: #059669; text-decoration: none; margin-right: 1rem; font-weight:600;">Edit</a>
                            <a href="/admin/anggota/hapus/<?= $a['id'] ?>" class="btn-delete" style="color: #EF4444; text-decoration: none; font-weight:600;">Hapus</a>
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

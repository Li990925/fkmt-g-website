<?php $title = "Kelola Slider Beranda | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Daftar Gambar Slider</h1>
    <a href="/admin/slider/tambah" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem;">+ Tambah Slider</a>
</div>

<div class="card">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid #E2E8F0; color: #64748B;">
                <th style="padding: 1rem 0;">No</th>
                <th style="padding: 1rem;">Foto Slide</th>
                <th style="padding: 1rem;">Tanggal Upload</th>
                <th style="padding: 1rem; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($sliders)): ?>
                <tr>
                    <td colspan="4" style="text-align:center; padding: 2rem;">Belum ada foto slider.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($sliders as $s): ?>
                <tr style="border-bottom: 1px solid #F1F5F9;">
                    <td style="padding: 1rem 0;"><?= $no++ ?></td>
                    <td style="padding: 1rem;">
                        <img src="/assets/images/slider/<?= htmlspecialchars($s['foto']) ?>" alt="Slider" style="width: 150px; height: 80px; object-fit: cover; border-radius: 4px; border: 1px solid #E2E8F0;">
                    </td>
                    <td style="padding: 1rem; color: #64748B;"><?= date('d M Y', strtotime($s['created_at'])) ?></td>
                    <td style="padding: 1rem; text-align: right;">
                        <a href="/admin/slider/hapus/<?= $s['id'] ?>" class="btn-delete" style="color: #EF4444; text-decoration: none; font-weight:600;">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

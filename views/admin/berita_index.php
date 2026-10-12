<?php $title = "Kelola Berita | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Daftar Berita</h1>
    <a href="/admin/berita/tambah" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem;">+ Tambah Berita</a>
</div>

<div class="card">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid #E2E8F0; color: #64748B;">
                <th style="padding: 1rem 0;">No</th>
                <th style="padding: 1rem;">Foto</th>
                <th style="padding: 1rem;">Judul</th>
                <th style="padding: 1rem;">Kategori</th>
                <th style="padding: 1rem;">Tanggal</th>
                <th style="padding: 1rem; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($semuaBerita)): ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding: 2rem;">Belum ada berita.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($semuaBerita as $b): ?>
                <tr style="border-bottom: 1px solid #F1F5F9;">
                    <td style="padding: 1rem 0;"><?= $no++ ?></td>
                    <td style="padding: 1rem;">
                        <?php if(!empty($b['gambar'])): ?>
                            <img src="/assets/images/berita/<?= htmlspecialchars($b['gambar']) ?>" alt="Thumbnail" style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px; border: 1px solid #E2E8F0;">
                        <?php else: ?>
                            <div style="width: 48px; height: 48px; background: #F1F5F9; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: #94A3B8; font-size: 0.75rem; font-weight: 600;">
                                No Pic
                            </div>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 1rem; font-weight: 600; color: #064E3B;">
                        <?= htmlspecialchars($b['judul']) ?>
                    </td>
                    <td style="padding: 1rem;">
                        <span style="background: rgba(5,150,105,0.1); color: #059669; padding: 0.2rem 0.6rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">
                            <?= htmlspecialchars($b['kategori']) ?>
                        </span>
                    </td>
                    <td style="padding: 1rem; color: #64748B; font-size: 0.9rem;"><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                    <td style="padding: 1rem; text-align: right; white-space: nowrap;">
                        <a href="/berita/detail/<?= htmlspecialchars(!empty($b['slug']) ? $b['slug'] : $b['id']) ?>" target="_blank" style="color: #64748B; text-decoration: none; margin-right: 0.75rem; font-size: 0.88rem; font-weight: 500;">Lihat</a>
                        <a href="/admin/berita/edit/<?= $b['id'] ?>" style="color: #059669; text-decoration: none; margin-right: 0.75rem; font-weight: 600; font-size: 0.88rem;">Edit</a>
                        <a href="/admin/berita/hapus/<?= $b['id'] ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" style="color: #EF4444; text-decoration: none; font-weight: 600; font-size: 0.88rem;">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

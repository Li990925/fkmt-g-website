<?php $title = "Kelola Pengurus | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Daftar Pengurus</h1>
    <a href="/admin/pengurus/tambah" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem;">+ Tambah Pengurus</a>
</div>

<div class="card">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid #E2E8F0; color: #64748B;">
                <th style="padding: 1rem 0;">No</th>
                <th style="padding: 1rem;">Nama</th>
                <th style="padding: 1rem;">Jabatan</th>
                <th style="padding: 1rem;">Kategori</th>
                <th style="padding: 1rem;">Urutan</th>
                <th style="padding: 1rem; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($semuaPengurus)): ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding: 2rem;">Belum ada data pengurus.</td>
                </tr>
            <?php else: ?>
                <?php $no = 1; foreach($semuaPengurus as $p): ?>
                <tr style="border-bottom: 1px solid #F1F5F9;">
                    <td style="padding: 1rem 0;"><?= $no++ ?></td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <?php if(!empty($p['foto'])): ?>
                                <img src="/assets/images/pengurus/<?= htmlspecialchars($p['foto']) ?>" alt="Foto" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                            <?php else: ?>
                                <div style="width: 40px; height: 40px; background: #E2E8F0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748B; font-weight: bold;">
                                    <?= strtoupper(substr($p['nama'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                            <span style="font-weight: 600; color: #064E3B;"><?= htmlspecialchars($p['nama']) ?></span>
                        </div>
                    </td>
                    <td style="padding: 1rem;"><?= htmlspecialchars($p['jabatan']) ?></td>
                    <td style="padding: 1rem;">
                        <span style="background: <?= $p['kategori'] == 'inti' ? 'rgba(239,68,68,0.1)' : ($p['kategori'] == 'harian' ? 'rgba(245,158,11,0.1)' : 'rgba(5,150,105,0.1)') ?>; color: <?= $p['kategori'] == 'inti' ? '#EF4444' : ($p['kategori'] == 'harian' ? '#F59E0B' : '#059669') ?>; padding: 0.2rem 0.6rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600;">
                            <?= ucfirst($p['kategori']) ?>
                        </span>
                    </td>
                    <td style="padding: 1rem; color: #64748B;"><?= $p['urutan'] ?></td>
                    <td style="padding: 1rem; text-align: right;">
                        <a href="/admin/pengurus/edit/<?= $p['id'] ?>" style="color: #059669; text-decoration: none; margin-right: 1rem; font-weight:600;">Edit</a>
                        <a href="/admin/pengurus/hapus/<?= $p['id'] ?>" class="btn-delete" style="color: #EF4444; text-decoration: none; font-weight:600;">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

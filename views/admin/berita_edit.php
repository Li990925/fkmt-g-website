<?php $title = "Edit Berita | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Edit Berita</h1>
    <a href="/admin/berita" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem; background: #64748B;">Kembali</a>
</div>

<div class="card">
    <form action="/admin/berita/update/<?= htmlspecialchars($b['id']) ?>" method="POST" enctype="multipart/form-data">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Judul Berita</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($b['judul']) ?>" required placeholder="Masukkan judul berita..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Kategori</label>
            <select name="kategori" required style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem; background: white;">
                <?php 
                $kategoriList = ['Umum', 'Organisasi', 'Kegiatan', 'Sosial', 'Pendidikan', 'Pengumuman'];
                foreach($kategoriList as $kat):
                ?>
                    <option value="<?= $kat ?>" <?= (strcasecmp($b['kategori'], $kat) === 0) ? 'selected' : '' ?>>
                        <?= $kat ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Foto Utama Berita (Opsional)</label>
            <?php if(!empty($b['gambar'])): ?>
                <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem;">
                    <img src="/assets/images/berita/<?= htmlspecialchars($b['gambar']) ?>" alt="Foto Berita" style="width: 120px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #E2E8F0;">
                    <span style="color: #64748B; font-size: 0.88rem;">Foto saat ini: <code><?= htmlspecialchars($b['gambar']) ?></code></span>
                </div>
            <?php endif; ?>
            <input type="file" name="gambar" accept="image/png, image/jpeg, image/jpg, image/webp" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            <small style="color: #64748B; margin-top: 0.3rem; display: block;">Format yang didukung: JPG, JPEG, PNG, WEBP. Kosongkan jika tidak ingin mengubah foto berita.</small>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Konten Berita</label>
            <textarea name="konten" required rows="10" placeholder="Tuliskan isi berita di sini..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem; font-family: inherit; resize: vertical; line-height: 1.6;"><?= htmlspecialchars($b['konten']) ?></textarea>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center;">
            <button type="submit" class="btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem; cursor: pointer; border: none;">Simpan Perubahan</button>
            <a href="/admin/berita" style="color: #64748B; text-decoration: none; font-weight: 500; font-size: 0.95rem;">Batal</a>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

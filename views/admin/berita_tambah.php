<?php $title = "Tambah Berita | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Tambah Berita</h1>
    <a href="/admin/berita" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem; background: #64748B;">Kembali</a>
</div>

<div class="card">
    <form action="/admin/berita/tambah" method="POST" enctype="multipart/form-data">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Judul Berita</label>
            <input type="text" name="judul" required placeholder="Masukkan judul berita..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Kategori</label>
            <select name="kategori" required style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem; background: white;">
                <option value="Umum">Umum</option>
                <option value="Organisasi">Organisasi</option>
                <option value="Kegiatan">Kegiatan</option>
                <option value="Sosial">Sosial</option>
                <option value="Pendidikan">Pendidikan</option>
                <option value="Pengumuman">Pengumuman</option>
            </select>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Foto Utama Berita (Opsional)</label>
            <input type="file" name="gambar" accept="image/png, image/jpeg, image/jpg, image/webp" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            <small style="color: #64748B; margin-top: 0.3rem; display: block;">Format yang didukung: JPG, JPEG, PNG, WEBP.</small>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Konten Berita</label>
            <textarea name="konten" required rows="10" placeholder="Tuliskan isi berita di sini..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem; font-family: inherit; resize: vertical; line-height: 1.6;"></textarea>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center;">
            <button type="submit" class="btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem; cursor: pointer; border: none;">Simpan Berita</button>
            <a href="/admin/berita" style="color: #64748B; text-decoration: none; font-weight: 500; font-size: 0.95rem;">Batal</a>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

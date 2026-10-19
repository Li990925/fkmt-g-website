<?php $title = "Tambah Foto Galeri | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Tambah Foto Galeri</h1>
    <a href="/admin/galeri" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem; background: #64748B;">Kembali</a>
</div>

<div class="card">
    <form action="/admin/galeri/tambah" method="POST" enctype="multipart/form-data">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Judul Kegiatan</label>
            <input type="text" name="judul" required placeholder="Contoh: Makrab FKMT-G 2023..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Pilih Foto</label>
            <input type="file" name="foto" required accept="image/png, image/jpeg, image/webp" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            <small style="color: #64748B; margin-top: 0.3rem; display: block;">Format yang didukung: JPG, JPEG, PNG, WEBP. Maksimal 5MB. Wajib diisi.</small>
        </div>

        <div>
            <button type="submit" class="btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem; cursor: pointer; border: none;">Upload Foto</button>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

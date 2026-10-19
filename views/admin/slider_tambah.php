<?php $title = "Tambah Slider | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<h1 class="page-title">Tambah Gambar Slider Baru</h1>

<div class="card" style="max-width: 600px;">
    <form action="/admin/slider/tambah" method="POST" enctype="multipart/form-data">
        <div class="form-group" style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #1E293B;">Foto Slider (Mendatar / Landscape)</label>
            <input type="file" name="foto" accept="image/png, image/jpeg, image/webp" required style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px;">
            <small style="color: #64748B; display: block; margin-top: 0.5rem;">Format didukung: JPG, PNG, WEBP. Pastikan foto berbentuk landscape (mendatar) untuk hasil terbaik di beranda.</small>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn-primary" style="padding: 0.8rem 2rem;">Simpan Slider</button>
            <a href="/admin/slider" style="padding: 0.8rem 2rem; border: 1px solid #CBD5E1; border-radius: 50px; text-decoration: none; color: #475569; font-weight: 600;">Batal</a>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

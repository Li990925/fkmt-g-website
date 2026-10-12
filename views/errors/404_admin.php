<?php 
$title = "404 - Halaman Admin Tidak Ditemukan | FKMT-G"; 
?>
<?php ob_start(); ?>

<div style="background: white; border-radius: 16px; padding: 3.5rem 2rem; text-align: center; max-width: 650px; margin: 3rem auto; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #E2E8F0;">
    <div style="font-size: 3.5rem; font-weight: 800; color: #DC2626; line-height: 1; margin-bottom: 1rem;">404</div>
    <h2 style="font-size: 1.5rem; color: #1E293B; margin-bottom: 0.75rem;">Halaman Admin Tidak Ditemukan</h2>
    <p style="color: #64748B; font-size: 0.95rem; margin-bottom: 2rem; line-height: 1.5;">Menu atau tautan aksi admin yang Anda akses tidak tersedia atau telah dipindahkan.</p>
    <a href="/admin" class="btn-tambah" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; padding: 0.75rem 1.5rem; font-weight: 600; border-radius: 10px;">
        &larr; Kembali ke Dashboard Admin
    </a>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

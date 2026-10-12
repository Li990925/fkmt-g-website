<?php $title = "Ganti Password | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Pengaturan Akun & Ganti Password</h1>
</div>

<?php if(!empty($success)): ?>
    <div style="background-color: #ECFDF5; border-left: 4px solid #059669; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; color: #065F46;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
        </svg>
        <span style="font-weight: 500; font-size: 0.95rem;"><?= htmlspecialchars($success) ?></span>
    </div>
<?php endif; ?>

<?php if(!empty($error)): ?>
    <div style="background-color: #FEF2F2; border-left: 4px solid #EF4444; padding: 1rem 1.25rem; border-radius: 6px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem; color: #991B1B;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <span style="font-weight: 500; font-size: 0.95rem;"><?= htmlspecialchars($error) ?></span>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
    <!-- Form Ganti Password -->
    <div class="card">
        <h2 style="font-size: 1.15rem; color: #064E3B; margin-bottom: 1.25rem; font-weight: 700; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.75rem;">
            Formulir Pembaruan Password
        </h2>

        <form action="/admin/password" method="POST" id="passwordForm">
            <!-- Username Akun -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Username Admin</label>
                <input type="text" name="username" value="<?= htmlspecialchars($admin['username'] ?? $_SESSION['admin_username'] ?? 'admin') ?>" required style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
                <small style="color: #64748B; margin-top: 0.35rem; display: block; font-size: 0.85rem;">Anda juga dapat memperbarui username akun jika diperlukan.</small>
            </div>

            <!-- Password Lama -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Password Saat Ini</label>
                <div style="position: relative;">
                    <input type="password" name="password_lama" id="password_lama" required placeholder="Masukkan password saat ini..." style="width: 100%; padding: 0.8rem 2.8rem 0.8rem 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
                    <button type="button" onclick="togglePasswordVisibility('password_lama', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94A3B8; font-size: 0.85rem; padding: 4px;">
                        👁️
                    </button>
                </div>
            </div>

            <!-- Password Baru -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Password Baru</label>
                <div style="position: relative;">
                    <input type="password" name="password_baru" id="password_baru" minlength="6" required placeholder="Minimal 6 karakter..." style="width: 100%; padding: 0.8rem 2.8rem 0.8rem 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
                    <button type="button" onclick="togglePasswordVisibility('password_baru', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94A3B8; font-size: 0.85rem; padding: 4px;">
                        👁️
                    </button>
                </div>
            </div>

            <!-- Konfirmasi Password Baru -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Konfirmasi Password Baru</label>
                <div style="position: relative;">
                    <input type="password" name="konfirmasi_password" id="konfirmasi_password" minlength="6" required placeholder="Ulangi password baru..." style="width: 100%; padding: 0.8rem 2.8rem 0.8rem 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
                    <button type="button" onclick="togglePasswordVisibility('konfirmasi_password', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94A3B8; font-size: 0.85rem; padding: 4px;">
                        👁️
                    </button>
                </div>
            </div>

            <div>
                <button type="submit" class="btn-primary" style="padding: 0.85rem 2rem; font-size: 1rem; cursor: pointer; border: none; width: 100%; background: var(--primary); color: white; border-radius: 8px; font-weight: 600; transition: background 0.2s ease;" onmouseover="this.style.background='#047857'" onmouseout="this.style.background='var(--primary)'">
                    Simpan Password Baru
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi & Tips Keamanan -->
    <div class="card" style="background: #F8FAFC; border: 1px solid #E2E8F0;">
        <h3 style="font-size: 1rem; color: #064E3B; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #059669;">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            Petunjuk Keamanan
        </h3>
        <ul style="padding-left: 1.2rem; color: #475569; font-size: 0.88rem; line-height: 1.6; margin: 0;">
            <li style="margin-bottom: 0.5rem;">Gunakan minimal <strong>6 karakter</strong>.</li>
            <li style="margin-bottom: 0.5rem;">Kombinasikan huruf besar, huruf kecil, dan angka.</li>
            <li style="margin-bottom: 0.5rem;">Hindari memakai informasi pribadi seperti tanggal lahir.</li>
            <li style="margin-bottom: 0.5rem;">Setelah mengganti password, simpan password Anda di tempat yang aman.</li>
        </ul>
        <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #E2E8F0; font-size: 0.82rem; color: #64748B;">
            ID Pengguna: <strong>#<?= htmlspecialchars($admin['id'] ?? '1') ?></strong><br>
            Waktu Server: <strong><?= date('d M Y, H:i') ?> WITA</strong>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    if (input.type === 'password') {
        input.type = 'text';
        btn.style.opacity = '0.5';
    } else {
        input.type = 'password';
        btn.style.opacity = '1';
    }
}
</script>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

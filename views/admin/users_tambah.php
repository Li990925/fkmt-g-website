<?php $title = "Tambah Pengguna Baru | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 class="page-title" style="margin-bottom: 0.25rem;">Tambah Pengguna Baru</h1>
        <p style="color: #64748B; font-size: 0.95rem; margin: 0;">Buat akun baru untuk pengurus atau administrator sistem.</p>
    </div>
    <a href="/admin/users" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem; background: #64748B; text-decoration: none;">Kembali</a>
</div>

<div class="card" style="max-width: 760px;">
    <form action="/admin/users/tambah" method="POST">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Nama Lengkap Pengurus</label>
            <input type="text" name="nama" required placeholder="Contoh: Moh. Fadli Rahman" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 0.95rem;">
            <small style="color: #64748B; margin-top: 0.35rem; display: block;">Nama pengurus yang akan ditampilkan pada panel atas dan profil.</small>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Username Login</label>
            <input type="text" name="username" required placeholder="Contoh: fadli_toili" autocomplete="off" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 0.95rem;">
            <small style="color: #64748B; margin-top: 0.35rem; display: block;">Gunakan huruf kecil tanpa spasi, angka, underscore (_), atau titik (.). Minimal 3 karakter.</small>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Pilih Peran (*Role*)</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1rem; margin-top: 0.5rem;">
                <label style="border: 2px solid #E2E8F0; border-radius: 10px; padding: 1.25rem; cursor: pointer; transition: all 0.2s; display: block; position: relative;" id="roleCardAdmin">
                    <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                        <input type="radio" name="role" value="admin" checked style="margin-top: 3px;" onchange="updateRoleHighlight()">
                        <div>
                            <div style="font-weight: 700; color: #065F46; font-size: 1rem; display: flex; align-items: center; gap: 0.4rem;">
                                Admin / Pengurus
                            </div>
                            <div style="font-size: 0.82rem; color: #64748B; margin-top: 0.35rem; line-height: 1.4;">
                                Akses operasional untuk mengelola berita, galeri kegiatan, struktur kepengurusan, slider, dan data anggota. Tidak bisa mengelola akun admin lain.
                            </div>
                        </div>
                    </div>
                </label>

                <label style="border: 2px solid #E2E8F0; border-radius: 10px; padding: 1.25rem; cursor: pointer; transition: all 0.2s; display: block; position: relative;" id="roleCardSuper">
                    <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                        <input type="radio" name="role" value="super_admin" style="margin-top: 3px;" onchange="updateRoleHighlight()">
                        <div>
                            <div style="font-weight: 700; color: #6D28D9; font-size: 1rem; display: flex; align-items: center; gap: 0.4rem;">
                                🛡️ Super Admin
                            </div>
                            <div style="font-size: 0.82rem; color: #64748B; margin-top: 0.35rem; line-height: 1.4;">
                                Akses penuh 100% ke seluruh sistem, termasuk membuat akun baru, mengedit hak akses pengurus lain, dan menghapus akun.
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Password Pengguna</label>
            <div style="position: relative;">
                <input type="password" id="userPasswordInput" name="password" required placeholder="Minimal 6 karakter..." style="width: 100%; padding: 0.8rem 2.8rem 0.8rem 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 0.95rem;">
                <button type="button" onclick="togglePasswordVisibility('userPasswordInput', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #64748B; padding: 4px;" aria-label="Lihat Password">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
            <small style="color: #64748B; margin-top: 0.35rem; display: block;">Pastikan password cukup kuat dan berikan kepada pengurus yang bersangkutan.</small>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center;">
            <button type="submit" class="btn-primary" style="padding: 0.85rem 2rem; font-size: 0.95rem; cursor: pointer; border: none; background: #059669;">
                Simpan Akun Pengguna
            </button>
            <a href="/admin/users" style="color: #64748B; text-decoration: none; font-size: 0.95rem;">Batal</a>
        </div>
    </form>
</div>

<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        btn.style.color = '#059669';
    } else {
        input.type = 'password';
        btn.style.color = '#64748B';
    }
}

function updateRoleHighlight() {
    const adminRadio = document.querySelector('input[name="role"][value="admin"]');
    const superRadio = document.querySelector('input[name="role"][value="super_admin"]');
    const cardAdmin = document.getElementById('roleCardAdmin');
    const cardSuper = document.getElementById('roleCardSuper');

    if (adminRadio && adminRadio.checked) {
        cardAdmin.style.borderColor = '#059669';
        cardAdmin.style.backgroundColor = '#F0FDF4';
        cardSuper.style.borderColor = '#E2E8F0';
        cardSuper.style.backgroundColor = 'transparent';
    } else {
        cardSuper.style.borderColor = '#8B5CF6';
        cardSuper.style.backgroundColor = '#F5F3FF';
        cardAdmin.style.borderColor = '#E2E8F0';
        cardAdmin.style.backgroundColor = 'transparent';
    }
}
document.addEventListener('DOMContentLoaded', updateRoleHighlight);
</script>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

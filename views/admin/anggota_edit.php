<?php $title = "Edit Anggota | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Edit Anggota</h1>
    <a href="/admin/anggota" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem; background: #64748B;">Kembali</a>
</div>

<div class="card">
    <form action="/admin/anggota/update/<?= $anggota['id'] ?>" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($anggota['nama'] ?? '') ?>" required placeholder="Masukkan nama..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Alamat</label>
                <input type="text" name="alamat" value="<?= htmlspecialchars($anggota['alamat'] ?? '') ?>" placeholder="Contoh: Jl. Sudirman No. 10" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Asal Kampus</label>
            <input type="text" name="kampus" value="<?= htmlspecialchars($anggota['kampus'] ?? '') ?>" required placeholder="Contoh: Universitas Negeri Gorontalo" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Fakultas</label>
                <input type="text" name="fakultas" value="<?= htmlspecialchars($anggota['fakultas'] ?? '') ?>" placeholder="Contoh: Ilmu Sosial" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Jurusan</label>
                <input type="text" name="jurusan" value="<?= htmlspecialchars($anggota['jurusan'] ?? '') ?>" placeholder="Contoh: Ilmu Hukum" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Nomor WA</label>
                <input type="text" name="no_wa" value="<?= htmlspecialchars($anggota['no_wa'] ?? '') ?>" placeholder="Contoh: 08123456789" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($anggota['email'] ?? '') ?>" placeholder="Contoh: nama@gmail.com" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Angkatan</label>
                <input type="number" name="angkatan" value="<?= htmlspecialchars($anggota['angkatan'] ?? '') ?>" placeholder="Contoh: 2021" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Golongan Darah</label>
                <select name="golongan_darah" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem; background-color: white;">
                    <option value="" <?= empty($anggota['golongan_darah']) ? 'selected' : '' ?>>-- Pilih Golongan Darah --</option>
                    <option value="A" <?= ($anggota['golongan_darah'] === 'A') ? 'selected' : '' ?>>A</option>
                    <option value="B" <?= ($anggota['golongan_darah'] === 'B') ? 'selected' : '' ?>>B</option>
                    <option value="AB" <?= ($anggota['golongan_darah'] === 'AB') ? 'selected' : '' ?>>AB</option>
                    <option value="O" <?= ($anggota['golongan_darah'] === 'O') ? 'selected' : '' ?>>O</option>
                    <option value="-" <?= ($anggota['golongan_darah'] === '-') ? 'selected' : '' ?>>Tidak Tahu</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem; cursor: pointer; border: none;">Update Anggota</button>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

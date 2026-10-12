<?php $title = "Tambah Anggota | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Tambah Anggota</h1>
    <a href="/admin/anggota" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem; background: #64748B;">Kembali</a>
</div>

<div class="card">
    <form action="/admin/anggota/tambah" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Masukkan nama..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Alamat</label>
                <input type="text" name="alamat" placeholder="Contoh: Jl. Sudirman No. 10" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Asal Kampus</label>
            <input type="text" name="kampus" required placeholder="Contoh: Universitas Negeri Gorontalo" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Fakultas</label>
                <input type="text" name="fakultas" placeholder="Contoh: Ilmu Sosial" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Jurusan</label>
                <input type="text" name="jurusan" placeholder="Contoh: Ilmu Hukum" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Nomor WA</label>
                <input type="text" name="no_wa" placeholder="Contoh: 08123456789" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Email</label>
                <input type="email" name="email" placeholder="Contoh: nama@gmail.com" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Angkatan</label>
                <input type="number" name="angkatan" placeholder="Contoh: 2021" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Golongan Darah</label>
                <select name="golongan_darah" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem; background-color: white;">
                    <option value="">-- Pilih Golongan Darah --</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                    <option value="-">Tidak Tahu</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem; cursor: pointer; border: none;">Simpan Anggota</button>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

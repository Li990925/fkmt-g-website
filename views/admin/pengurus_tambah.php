<?php $title = "Tambah Pengurus | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0;">Tambah Pengurus</h1>
    <a href="/admin/pengurus" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem; background: #64748B;">Kembali</a>
</div>

<div class="card">
    <form action="/admin/pengurus/tambah" method="POST" enctype="multipart/form-data">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Nama Lengkap</label>
            <input type="text" name="nama" required placeholder="Masukkan nama..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Jabatan</label>
                <input type="text" name="jabatan" required placeholder="Contoh: Ketua Umum, Divisi Humas..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Kategori Pengurus</label>
                <select name="kategori" required style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem; background: white;">
                    <option value="inti">Pengurus Inti (Ketua, Sekretaris, Bendahara)</option>
                    <option value="harian">Ketua Bidang</option>
                    <option value="bidang" selected>Anggota Bidang</option>
                </select>
                <small style="color: #64748B; margin-top: 0.3rem; display: block;">Pengurus Inti untuk Ketua/Sekretaris/Bendahara, Ketua Bidang untuk koordinator, atau Anggota Bidang.</small>
            </div>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Foto Pengurus (Opsional)</label>
            <input type="file" name="foto" accept="image/png, image/jpeg, image/jpg" style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            <small style="color: #64748B; margin-top: 0.3rem; display: block;">Format yang didukung: JPG, JPEG, PNG.</small>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Nomor Urut Tampil</label>
            <input type="number" name="urutan" value="10" required style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem;">
            <small style="color: #64748B; margin-top: 0.3rem; display: block;">Semakin kecil angkanya, semakin di atas posisinya (contoh: Ketua = 1)</small>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Deskripsi Singkat (Opsional)</label>
            <textarea name="deskripsi" rows="3" placeholder="Tuliskan tugas/wewenang singkat di sini..." style="width: 100%; padding: 0.8rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; font-size: 1rem; font-family: inherit; resize: vertical;"></textarea>
        </div>

        <div>
            <button type="submit" class="btn-primary" style="padding: 0.8rem 2rem; font-size: 1rem; cursor: pointer; border: none;">Simpan Pengurus</button>
        </div>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

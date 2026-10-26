<?php $title = "Impor Data Anggota | Admin FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 class="page-title" style="margin-bottom: 0.25rem;">Impor Data Anggota Massal</h1>
        <p style="color: #64748B; font-size: 0.95rem; margin: 0;">Unggah data anggota FKMT-G sekaligus dari file Microsoft Excel atau Google Sheets.</p>
    </div>
    <a href="/admin/anggota" class="btn-primary" style="padding: 0.8rem 1.5rem; font-size: 0.9rem; background: #64748B; text-decoration: none;">Kembali</a>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; max-width: 900px;">
    
    <!-- Panduan & Download Template -->
    <div class="card" style="border-left: 4px solid #2563EB;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
            <div>
                <h3 style="margin: 0 0 0.4rem 0; color: #1E293B; font-size: 1.15rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📥 Langkah 1: Unduh Format Template</span>
                </h3>
                <p style="color: #64748B; font-size: 0.9rem; margin: 0;">
                    Gunakan template resmi ini agar data dari Excel / Spreadsheet Anda otomatis terbaca rapi oleh sistem.
                </p>
            </div>
            <div style="display: flex; gap: 0.6rem; flex-wrap: wrap;">
                <a href="/admin/anggota/template?format=xlsx" class="btn-primary" style="padding: 0.75rem 1.25rem; font-size: 0.9rem; background-color: #059669; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(5,150,105,0.2);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Unduh Format Excel (.XLSX)
                </a>
                <a href="/admin/anggota/template?format=csv" class="btn-primary" style="padding: 0.75rem 1rem; font-size: 0.85rem; background-color: #0D9488; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; border-radius: 8px;">
                    Format CSV
                </a>
            </div>
        </div>

        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 1rem 1.25rem;">
            <div style="font-weight: 600; color: #334155; font-size: 0.9rem; margin-bottom: 0.5rem;">Susunan Kolom pada Lembar Excel / Spreadsheet:</div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem; text-align: left;">
                    <thead>
                        <tr style="background: #E2E8F0; color: #1E293B;">
                            <th style="padding: 0.6rem; border: 1px solid #CBD5E1;">Kolom</th>
                            <th style="padding: 0.6rem; border: 1px solid #CBD5E1;">Nama Kolom</th>
                            <th style="padding: 0.6rem; border: 1px solid #CBD5E1;">Status</th>
                            <th style="padding: 0.6rem; border: 1px solid #CBD5E1;">Contoh Isi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">A</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">Nama Lengkap</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;"><span style="color: #DC2626; font-weight: 600;">Wajib</span></td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Ahmad Fauzi</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">B</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">Asal Kampus</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;"><span style="color: #DC2626; font-weight: 600;">Wajib</span></td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Universitas Negeri Gorontalo</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">C</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Fakultas</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; color: #64748B;">Opsional</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Fakultas Teknik</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">D</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Jurusan</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; color: #64748B;">Opsional</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Teknik Informatika</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">E</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Tahun Angkatan</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; color: #64748B;">Opsional</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">2023 (format 4 digit angka)</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">F</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Nomor WhatsApp</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; color: #64748B;">Opsional</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">081234567890</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">G</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Email</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; color: #64748B;">Opsional</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">ahmad.fauzi@gmail.com</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">H</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Golongan Darah</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; color: #64748B;">Opsional</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">O / A / B / AB</td>
                        </tr>
                        <tr>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; font-weight: 600;">I</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Alamat Domisili</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1; color: #64748B;">Opsional</td>
                            <td style="padding: 0.5rem; border: 1px solid #CBD5E1;">Kec. Toili, Kab. Banggai</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Upload File -->
    <div class="card" style="border-left: 4px solid #10B981;">
        <h3 style="margin: 0 0 0.5rem 0; color: #1E293B; font-size: 1.15rem; display: flex; align-items: center; gap: 0.5rem;">
            <span>📤 Langkah 2: Unggah Berkas & Proses Impor</span>
        </h3>
        <p style="color: #64748B; font-size: 0.9rem; margin-top: 0; margin-bottom: 1.5rem;">
            Pilih berkas Excel yang sudah Anda isi datanya. Sistem langsung mendukung berkas <strong>Microsoft Excel (.xlsx)</strong> tanpa perlu diubah, maupun berkas <strong>CSV (.csv)</strong> dari Google Sheets / WPS Office.
        </p>

        <form action="/admin/anggota/import" method="POST" enctype="multipart/form-data">
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #064E3B;">Pilih Berkas Excel (.xlsx) atau CSV</label>
                <input type="file" name="file_excel" required accept=".xlsx, .xls, .csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, text/csv, text/plain" style="width: 100%; padding: 0.85rem; border: 2px dashed #CBD5E1; border-radius: 8px; outline: none; background: #F8FAFC; cursor: pointer;">
                <small style="color: #64748B; margin-top: 0.4rem; display: block;">Mendukung format: <strong>.xlsx</strong> (Excel 2007–2024 / Microsoft 365) dan <strong>.csv</strong>.</small>
            </div>

            <div style="margin-bottom: 1.5rem; background: #F8FAFC; border: 1px solid #E2E8F0; padding: 1rem 1.25rem; border-radius: 8px;">
                <label style="display: block; font-weight: 600; margin-bottom: 0.4rem; color: #1E293B;">Pemetaan Angkatan Otomatis</label>
                <select name="default_angkatan" style="width: 100%; padding: 0.75rem; border: 1px solid #CBD5E1; border-radius: 8px; outline: none; background: white; font-size: 0.95rem;">
                    <option value="">✨ Otomatis ikuti kolom 'Tahun Angkatan' di tiap baris Excel (Mendukung Campuran Berbagai Angkatan)</option>
                    <?php 
                    $currentYear = (int)date('Y');
                    for($y = $currentYear; $y >= 2008; $y--): ?>
                        <option value="<?= $y ?>">Tetapkan semua sebagai Angkatan <?= $y ?> (jika kolom di Excel kosong)</option>
                    <?php endfor; ?>
                </select>
                <small style="color: #64748B; margin-top: 0.4rem; display: block; line-height: 1.4;">
                    Jika file Excel Anda memuat anggota dari <strong>banyak angkatan sekaligus</strong> (misal 2020, 2021, 2022 campur), biarkan pilihan pertama. Sistem otomatis mengelompokkan tiap anggota ke angkatannya masing-masing.
                </small>
            </div>

            <div style="display: flex; gap: 1rem; align-items: center;">
                <button type="submit" class="btn-primary" style="padding: 0.85rem 2rem; font-size: 0.95rem; cursor: pointer; border: none; background: #2563EB; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                    Proses & Simpan Data Anggota
                </button>
                <a href="/admin/anggota" style="color: #64748B; text-decoration: none; font-size: 0.95rem;">Batal</a>
            </div>
        </form>
    </div>

</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

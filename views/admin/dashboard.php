<?php $title = "Dashboard Admin | FKMT-G"; ?>
<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 class="page-title" style="margin-bottom: 0.25rem;">Dashboard Administrator</h1>
        <p style="color: #64748B; font-size: 0.95rem;">Selamat datang kembali, <strong><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></strong>! Berikut ringkasan sistem web FKMT-G.</p>
    </div>
    <div style="background: white; padding: 0.6rem 1.25rem; border-radius: 10px; border: 1px solid #E2E8F0; font-size: 0.88rem; color: #475569; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="16" y1="2" x2="16" y2="6"></line>
            <line x1="8" y1="2" x2="8" y2="6"></line>
            <line x1="3" y1="10" x2="21" y2="10"></line>
        </svg>
        <span><?= date('l, d F Y') ?></span>
    </div>
</div>

<!-- 5 Stat Metrics Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
    <!-- Stat Berita -->
    <a href="/admin/berita" style="text-decoration: none; color: inherit;">
        <div class="card" style="display: flex; align-items: center; gap: 1.25rem; border-left: 4px solid #059669; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(5, 150, 105, 0.1); display: flex; align-items: center; justify-content: center; color: #059669;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2"></path>
                </svg>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: #64748B; font-weight: 500;">Total Berita</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: #064E3B; line-height: 1.1;"><?= $totalBerita ?? 0 ?></div>
            </div>
        </div>
    </a>

    <!-- Stat Pengurus -->
    <a href="/admin/pengurus" style="text-decoration: none; color: inherit;">
        <div class="card" style="display: flex; align-items: center; gap: 1.25rem; border-left: 4px solid #0D9488; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(13, 148, 136, 0.1); display: flex; align-items: center; justify-content: center; color: #0D9488;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: #64748B; font-weight: 500;">Pengurus Aktif</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: #064E3B; line-height: 1.1;"><?= $totalPengurus ?? 0 ?></div>
            </div>
        </div>
    </a>

    <!-- Stat Anggota -->
    <a href="/admin/anggota" style="text-decoration: none; color: inherit;">
        <div class="card" style="display: flex; align-items: center; gap: 1.25rem; border-left: 4px solid #2563EB; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(37, 99, 235, 0.1); display: flex; align-items: center; justify-content: center; color: #2563EB;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: #64748B; font-weight: 500;">Total Anggota</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: #064E3B; line-height: 1.1;"><?= $totalAnggota ?? 0 ?></div>
            </div>
        </div>
    </a>

    <!-- Stat Galeri -->
    <a href="/admin/galeri" style="text-decoration: none; color: inherit;">
        <div class="card" style="display: flex; align-items: center; gap: 1.25rem; border-left: 4px solid #8B5CF6; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(139, 92, 246, 0.1); display: flex; align-items: center; justify-content: center; color: #8B5CF6;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: #64748B; font-weight: 500;">Foto Galeri</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: #064E3B; line-height: 1.1;"><?= $totalGaleri ?? 0 ?></div>
            </div>
        </div>
    </a>

    <!-- Stat Slider -->
    <a href="/admin/slider" style="text-decoration: none; color: inherit;">
        <div class="card" style="display: flex; align-items: center; gap: 1.25rem; border-left: 4px solid #F59E0B; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(245, 158, 11, 0.1); display: flex; align-items: center; justify-content: center; color: #F59E0B;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: #64748B; font-weight: 500;">Slider Banner</div>
                <div style="font-size: 1.8rem; font-weight: 800; color: #064E3B; line-height: 1.1;"><?= $totalSlider ?? 0 ?></div>
            </div>
        </div>
    </a>
</div>

<!-- Aksi Cepat / Quick Actions -->
<div class="card" style="margin-bottom: 2rem;">
    <h2 style="font-size: 1.1rem; color: #064E3B; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2">
            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
        </svg>
        Aksi Cepat Administrator
    </h2>
    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
        <a href="/admin/berita/tambah" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.88rem; padding: 0.65rem 1.15rem;">
            <span>+</span> Tulis Berita Baru
        </a>
        <a href="/admin/anggota/tambah" class="btn-primary" style="background-color: #0D9488; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.88rem; padding: 0.65rem 1.15rem;">
            <span>+</span> Tambah Anggota
        </a>
        <a href="/admin/pengurus/tambah" class="btn-primary" style="background-color: #2563EB; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.88rem; padding: 0.65rem 1.15rem;">
            <span>+</span> Tambah Pengurus
        </a>
        <a href="/admin/galeri/tambah" class="btn-primary" style="background-color: #8B5CF6; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.88rem; padding: 0.65rem 1.15rem;">
            <span>+</span> Unggah Galeri
        </a>
        <a href="/admin/anggota/export" class="btn-primary" style="background-color: #059669; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.88rem; padding: 0.65rem 1.15rem;">
            <span>↓</span> Unduh Rekap Anggota (CSV)
        </a>
        <a href="/admin/password" class="btn-primary" style="background-color: #475569; display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.88rem; padding: 0.65rem 1.15rem;">
            <span>🔒</span> Ganti Password
        </a>
    </div>
</div>

<!-- Two-Column Recent Data Overview -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-bottom: 2rem;">
    <!-- Berita Terbaru -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.75rem;">
            <h2 style="font-size: 1.1rem; color: #064E3B; font-weight: 700; margin: 0;">Berita Terbaru</h2>
            <a href="/admin/berita" style="font-size: 0.85rem; color: #059669; font-weight: 600; text-decoration: none;">Lihat Semua &rarr;</a>
        </div>
        <?php if(!empty($recentBerita)): ?>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <?php foreach($recentBerita as $rb): ?>
                <div style="padding: 0.75rem; border-radius: 8px; background: #F8FAFC; border: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                    <div style="min-width: 0; flex: 1;">
                        <a href="/berita/detail/<?= htmlspecialchars($rb['slug']) ?>" target="_blank" style="font-weight: 600; color: #1E293B; text-decoration: none; font-size: 0.9rem; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?= htmlspecialchars($rb['judul']) ?>
                        </a>
                        <div style="font-size: 0.78rem; color: #64748B; margin-top: 0.2rem; display: flex; gap: 0.5rem; align-items: center;">
                            <span style="background: rgba(5,150,105,0.1); color: #059669; padding: 0.1rem 0.4rem; border-radius: 4px; font-weight: 600;"><?= htmlspecialchars($rb['kategori']) ?></span>
                            <span><?= date('d M Y', strtotime($rb['created_at'])) ?></span>
                        </div>
                    </div>
                    <a href="/admin/berita/edit/<?= $rb['id'] ?>" style="font-size: 0.8rem; color: #0D9488; text-decoration: none; font-weight: 600; white-space: nowrap; padding: 0.3rem 0.6rem; border: 1px solid #CBD5E1; border-radius: 6px; background: white;">Edit</a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color: #64748B; font-size: 0.9rem; text-align: center; padding: 2rem 0;">Belum ada berita yang diterbitkan.</p>
        <?php endif; ?>
    </div>

    <!-- Pengurus Terdaftar Terbaru -->
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; border-bottom: 1px solid #E2E8F0; padding-bottom: 0.75rem;">
            <h2 style="font-size: 1.1rem; color: #064E3B; font-weight: 700; margin: 0;">Pengurus Organisasi</h2>
            <a href="/admin/pengurus" style="font-size: 0.85rem; color: #059669; font-weight: 600; text-decoration: none;">Kelola &rarr;</a>
        </div>
        <?php if(!empty($recentPengurus)): ?>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <?php foreach($recentPengurus as $rp): ?>
                <div style="padding: 0.75rem; border-radius: 8px; background: #F8FAFC; border: 1px solid #F1F5F9; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                    <div>
                        <div style="font-weight: 600; color: #1E293B; font-size: 0.9rem;">
                            <?= htmlspecialchars($rp['nama']) ?>
                        </div>
                        <div style="font-size: 0.78rem; color: #64748B; margin-top: 0.2rem;">
                            <span style="font-weight: 600; color: #059669;"><?= htmlspecialchars($rp['jabatan']) ?></span>
                            <?php if(!empty($rp['kategori'])): ?>
                                &bull; <?= htmlspecialchars($rp['kategori']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="/admin/pengurus/edit/<?= $rp['id'] ?>" style="font-size: 0.8rem; color: #0D9488; text-decoration: none; font-weight: 600; white-space: nowrap; padding: 0.3rem 0.6rem; border: 1px solid #CBD5E1; border-radius: 6px; background: white;">Edit</a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color: #64748B; font-size: 0.9rem; text-align: center; padding: 2rem 0;">Belum ada pengurus terdaftar.</p>
        <?php endif; ?>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_admin.php'; ?>

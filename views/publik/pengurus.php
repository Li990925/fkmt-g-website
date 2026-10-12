<?php $title = "Pengurus | Website FKMT-G"; ?>
<?php ob_start(); ?>

<div class="page-header">
    <div class="header-content">
        <h1>Struktur Kepengurusan</h1>
        <p>Mengenal struktur organisasi FKMT-G: Pengurus Inti, Ketua Bidang, dan Anggota Bidang.</p>
    </div>
</div>

<div class="container pengurus-container">
    <!-- Filter Kategori & Data Grouping -->
    <?php
        $inti = array_filter($semuaPengurus, function($p) { return $p['kategori'] === 'inti'; });
        $ketuaBidang = array_filter($semuaPengurus, function($p) { return $p['kategori'] === 'harian'; });
        $anggotaBidang = array_filter($semuaPengurus, function($p) { return $p['kategori'] === 'bidang'; });
    ?>

    <?php if(empty($semuaPengurus)): ?>
        <div style="text-align: center; padding: 4rem 1rem; color: #64748B;">
            <p style="font-size: 1.1rem; margin: 0;">Data struktur kepengurusan sedang dalam proses peremajaan.</p>
        </div>
    <?php endif; ?>

    <!-- Tingkat 1: Pengurus Inti (Ketua, Sekretaris, Bendahara) -->
    <?php if(!empty($inti)): ?>
    <section class="hierarchy-level level-inti">
        <div class="level-header">
            <span class="level-badge badge-puncak">Tingkat I</span>
            <h2>Pengurus Inti</h2>
            <p>Ketua, Sekretaris, dan Bendahara yang memimpin arah gerak organisasi, ketertiban administrasi, dan tata kelola keuangan FKMT-G</p>
        </div>

        <div class="cards-puncak">
            <?php foreach($inti as $p): ?>
            <?php
                // Tentukan warna badge berdasarkan jabatan
                $roleClass = 'role-badge-gold';
                $jabatanLower = strtolower($p['jabatan']);
                if (strpos($jabatanLower, 'sekretaris') !== false) {
                    $roleClass = 'role-badge-teal';
                } elseif (strpos($jabatanLower, 'bendahara') !== false) {
                    $roleClass = 'role-badge-amber';
                }
            ?>
            <div class="card-leader">
                <div class="card-leader-banner"></div>
                <div class="card-leader-body">
                    <div class="avatar-wrapper avatar-lg">
                        <?php if(!empty($p['foto'])): ?>
                            <img src="/assets/images/pengurus/<?= htmlspecialchars($p['foto']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>" class="avatar-img">
                        <?php else: ?>
                            <div class="avatar-fallback gradient-emerald">
                                <span><?= strtoupper(mb_substr($p['nama'], 0, 1)) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="leader-details">
                        <span class="role-badge <?= $roleClass ?>"><?= htmlspecialchars($p['jabatan']) ?></span>
                        <h3 class="leader-name"><?= htmlspecialchars($p['nama']) ?></h3>
                        <?php if(!empty($p['deskripsi'])): ?>
                            <p class="leader-desc">&ldquo;<?= htmlspecialchars($p['deskripsi']) ?>&rdquo;</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Hierarchy Connector -->
    <?php if(!empty($ketuaBidang) || !empty($anggotaBidang)): ?>
    <div class="hierarchy-connector">
        <div class="connector-line"></div>
        <div class="connector-dot"></div>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Tingkat 2: Ketua Bidang -->
    <?php if(!empty($ketuaBidang)): ?>
    <section class="hierarchy-level level-harian">
        <div class="level-header">
            <span class="level-badge badge-bph">Tingkat II</span>
            <h2>Ketua Bidang</h2>
            <p>Pimpinan dan koordinator yang bertanggung jawab mengarahkan serta menggerakkan program kerja tiap bidang</p>
        </div>

        <div class="grid-bph">
            <?php foreach($ketuaBidang as $p): ?>
            <div class="card-bph">
                <div class="card-top-stripe"></div>
                <div class="avatar-wrapper avatar-md">
                    <?php if(!empty($p['foto'])): ?>
                        <img src="/assets/images/pengurus/<?= htmlspecialchars($p['foto']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>" class="avatar-img">
                    <?php else: ?>
                        <div class="avatar-fallback gradient-teal">
                            <span><?= strtoupper(mb_substr($p['nama'], 0, 1)) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="bph-details">
                    <span class="role-badge role-badge-teal"><?= htmlspecialchars($p['jabatan']) ?></span>
                    <h3 class="bph-name"><?= htmlspecialchars($p['nama']) ?></h3>
                    <?php if(!empty($p['deskripsi'])): ?>
                        <p class="bph-desc"><?= htmlspecialchars($p['deskripsi']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Hierarchy Connector -->
    <?php if(!empty($anggotaBidang)): ?>
    <div class="hierarchy-connector">
        <div class="connector-line"></div>
        <div class="connector-dot"></div>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <!-- Tingkat 3: Anggota Bidang -->
    <?php if(!empty($anggotaBidang)): ?>
    <section class="hierarchy-level level-bidang">
        <div class="level-header">
            <span class="level-badge badge-bidang">Tingkat III</span>
            <h2>Anggota Bidang</h2>
            <p>Seluruh kader dan anggota aktif yang berdedikasi menjalankan roda kegiatan di masing-masing bidang kepengurusan</p>
        </div>

        <div class="grid-bidang">
            <?php foreach($anggotaBidang as $p): ?>
            <div class="card-bidang">
                <div class="avatar-wrapper avatar-sm">
                    <?php if(!empty($p['foto'])): ?>
                        <img src="/assets/images/pengurus/<?= htmlspecialchars($p['foto']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>" class="avatar-img">
                    <?php else: ?>
                        <div class="avatar-fallback gradient-emerald">
                            <span><?= strtoupper(mb_substr($p['nama'], 0, 1)) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="bidang-details">
                    <span class="role-badge role-badge-subtle"><?= htmlspecialchars($p['jabatan']) ?></span>
                    <h3 class="bidang-name"><?= htmlspecialchars($p['nama']) ?></h3>
                    <?php if(!empty($p['deskripsi'])): ?>
                        <p class="bidang-desc"><?= htmlspecialchars($p['deskripsi']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_publik.php'; ?>

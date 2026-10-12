<?php $title = "Pengurus | Website FKMT-G"; ?>
<?php ob_start(); ?>

<div class="page-header">
    <div class="header-content">
        <h1>Susunan Pengurus</h1>
        <p>Mengenal tokoh-tokoh yang berdedikasi dalam menjalankan roda organisasi FKMT-G kita.</p>
    </div>
</div>

<div class="container pengurus-container">
    <!-- Filter Kategori & Data Grouping -->
    <?php
        $inti = array_filter($semuaPengurus, function($p) { return $p['kategori'] === 'inti'; });
        $harian = array_filter($semuaPengurus, function($p) { return $p['kategori'] === 'harian'; });
        $bidang = array_filter($semuaPengurus, function($p) { return $p['kategori'] === 'bidang'; });
    ?>

    <!-- Tingkat 1: Pimpinan Utama / Ketua Umum -->
    <?php if(!empty($inti)): ?>
    <section class="hierarchy-level level-inti">
        <div class="level-header">
            <span class="level-badge badge-puncak">Tingkat I</span>
            <h2>Pimpinan Utama</h2>
            <p>Nahkoda yang memimpin arah gerak, visi, dan nilai-nilai luhur organisasi</p>
        </div>

        <div class="cards-puncak">
            <?php foreach($inti as $p): ?>
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
                        <span class="role-badge role-badge-gold"><?= htmlspecialchars($p['jabatan']) ?></span>
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
    <div class="hierarchy-connector">
        <div class="connector-line"></div>
        <div class="connector-dot"></div>
    </div>
    <?php endif; ?>

    <!-- Tingkat 2: Badan Pengurus Harian (BPH) -->
    <?php if(!empty($harian)): ?>
    <section class="hierarchy-level level-harian">
        <div class="level-header">
            <span class="level-badge badge-bph">Tingkat II</span>
            <h2>Badan Pengurus Harian (BPH)</h2>
            <p>Penggerak operasional, administrasi, dan koordinasi program kerja organisasi</p>
        </div>

        <div class="grid-bph">
            <?php foreach($harian as $p): ?>
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
    <div class="hierarchy-connector">
        <div class="connector-line"></div>
        <div class="connector-dot"></div>
    </div>
    <?php endif; ?>

    <!-- Tingkat 3: Koordinator Bidang -->
    <?php if(!empty($bidang)): ?>
    <section class="hierarchy-level level-bidang">
        <div class="level-header">
            <span class="level-badge badge-bidang">Tingkat III</span>
            <h2>Koordinator Bidang & Divisi</h2>
            <p>Pelaksana teknis kegiatan dan program pemberdayaan mahasiswa</p>
        </div>

        <div class="grid-bidang">
            <?php foreach($bidang as $p): ?>
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

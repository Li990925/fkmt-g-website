<?php $title = "Tentang Kami | Website FKMT-G"; ?>
<?php ob_start(); ?>

<!-- Page Header -->
<div class="page-header">
    <div class="header-content">
        <h1>Tentang FKMT-G</h1>
        <p>Mengenal lebih dekat sejarah, visi, misi, dan nilai-nilai yang kami perjuangkan.</p>
    </div>
</div>

<div class="container tentang-container">
    <!-- Sejarah Section -->
    <section class="tentang-section">
        <div class="tentang-text">
            <h2>Sejarah Berdirinya FKMT</h2>
            <p>Organisasi ini bernama <strong>Forum Komunikasi Mahasiswa Toili</strong> disingkat <strong>FKMT</strong>. FKMT mulai dirumuskan pada tanggal 9 Mei 2008 di Ruang N.1.1 Fakultas MIPA Universitas Negeri Gorontalo dan resmi terbentuk serta berdiri pada tanggal <strong>23 Mei 2008</strong>.</p>
            <p>FKMT merupakan organisasi yang berbentuk paguyuban, berasaskan Pancasila dan UUD 1945 serta bersifat mandiri dan independen.</p>
            <p>FKMT bertujuan untuk mewadahi, mengembangkan segala potensi kader dalam berpikir kritis, bertanggung jawab serta berwawasan luas dan kedaerahan, serta mengadakan kegiatan yang sesuai dengan azas, sifat dan tujuan.</p>
        </div>
        <div class="tentang-image">
            <div class="sejarah-card">
                <div class="sejarah-card-header">
                    <img src="/assets/images/logo.png" alt="Logo FKMT" class="sejarah-card-logo">
                    <div>
                        <h4 style="margin: 0; color: #064E3B; font-size: 1.15rem; font-weight: 700;">Tonggak Sejarah FKMT</h4>
                        <span style="font-size: 0.78rem; color: #059669; font-weight: 600;">Est. 23 Mei 2008 &bull; Gorontalo</span>
                    </div>
                </div>

                <div class="sejarah-timeline">
                    <div class="sejarah-item">
                        <span class="sejarah-item-icon">🏛️</span>
                        <div>
                            <div class="sejarah-item-label">Tempat Perumusan</div>
                            <div class="sejarah-item-val">Ruang N.1.1 FMIPA UNG</div>
                        </div>
                    </div>

                    <div class="sejarah-item">
                        <span class="sejarah-item-icon">📅</span>
                        <div>
                            <div class="sejarah-item-label">Waktu Peresmian</div>
                            <div class="sejarah-item-val">23 Mei 2008 (Dirumuskan 9 Mei)</div>
                        </div>
                    </div>

                    <div class="sejarah-item">
                        <span class="sejarah-item-icon">🤝</span>
                        <div>
                            <div class="sejarah-item-label">Bentuk & Sifat Organisasi</div>
                            <div class="sejarah-item-val">Paguyuban Mandiri & Independen</div>
                        </div>
                    </div>

                    <div class="sejarah-item">
                        <span class="sejarah-item-icon">🎯</span>
                        <div>
                            <div class="sejarah-item-label">Landasan Asas</div>
                            <div class="sejarah-item-val">Pancasila & UUD 1945</div>
                        </div>
                    </div>
                </div>

                <div class="sejarah-quote">
                    <p>"Wadah kebersamaan, berpikir kritis, bertanggung jawab, dan berwawasan kedaerahan."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Makna Lambang Section -->
    <section class="makna-section">
        <div class="makna-logo-col">
            <img src="/assets/images/logo.png" alt="Lambang Resmi FKMT" class="makna-logo-img">
            <h4>Lambang Resmi FKMT</h4>
            <p>Forum Komunikasi Mahasiswa Toili</p>
        </div>
        <div class="makna-content-col">
            <h2>Makna & Filosofi Lambang</h2>
            <div class="makna-grid">
                <div class="makna-card">
                    <h5>Segilima & Warna Hijau</h5>
                    <p>Melambangkan keteguhan nilai luhur Pancasila serta kesuburan dan kemakmuran tanah Toili.</p>
                </div>
                <div class="makna-card">
                    <h5>Buku, Pena & Toga</h5>
                    <p>Semangat menuntut ilmu, tradisi intelektual, dan kesuksesan akademik mahasiswa di tanah rantau.</p>
                </div>
                <div class="makna-card">
                    <h5>Dua Tangan Menopang</h5>
                    <p>Semangat kekeluargaan, saling merangkul, gotong royong, dan kepedulian sosial antar anggota.</p>
                </div>
                <div class="makna-card">
                    <h5>Kuning Emas & Bintang</h5>
                    <p>Kejayaan, optimisme masa depan generasi muda, dan cita-cita luhur memajukan daerah.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Visi & Misi Section -->
    <section class="visi-misi">
        <div class="vm-card">
            <div class="icon-circle">🎯</div>
            <h3>Visi</h3>
            <p>Menjadi organisasi yang mandiri, sejahtera, dan membawa manfaat nyata bagi seluruh anggota dan lingkungan sekitarnya, berlandaskan persaudaraan yang erat.</p>
        </div>
        <div class="vm-card">
            <div class="icon-circle">🚀</div>
            <h3>Misi</h3>
            <ul>
                <li>Mempererat tali silaturahmi antar anggota melalui kegiatan rutin.</li>
                <li>Mewujudkan kepedulian sosial terhadap anggota yang membutuhkan.</li>
                <li>Menyelenggarakan program edukasi dan pemberdayaan ekonomi.</li>
                <li>Menjaga kelestarian lingkungan dan budaya lokal.</li>
            </ul>
        </div>
    </section>
</div>

<?php $content = ob_get_clean(); ?>
<?php require_once __DIR__ . '/../layouts/master_publik.php'; ?>

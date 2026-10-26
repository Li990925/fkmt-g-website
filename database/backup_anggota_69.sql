-- MariaDB dump 10.20-13.0.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: fkmtg_db
-- ------------------------------------------------------
-- Server version	13.0.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

--
-- Table structure for table `anggota`
--

DROP TABLE IF EXISTS `anggota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `anggota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `kampus` varchar(255) NOT NULL,
  `fakultas` varchar(255) DEFAULT NULL,
  `jurusan` varchar(255) DEFAULT NULL,
  `angkatan` int(11) DEFAULT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `golongan_darah` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anggota`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `anggota` WRITE;
/*!40000 ALTER TABLE `anggota` DISABLE KEYS */;
INSERT INTO `anggota` VALUES
(1,'MUH FATKUR KHOIR','TOILI','Universitas Negeri Gorontalo','TEKNIK','TEKNIK ELEKTRO',2023,'083844036262','fatkurkhoir25@gmail.com','2026-10-25 03:07:52',''),
(2,'Mita Eruliana','Piondo','Universitas Negeri Gorontalo','Ilmu Pendidikan','Pgsd',2023,'085241035458','mitaeruliana@gmail.com','2026-10-25 03:07:52','B'),
(3,'Dewi Arum Sukmaning Ayu','Piondo','Universitas Negeri Gorontalo','sastra dan budaya','Pend. Bahasa Inggris',2023,'082292659789','da381846@gmail.com','2026-10-25 03:07:52',''),
(4,'Yenis Agustin','Bukit Jaya','Universitas Negeri Gorontalo','MIPA','ITK ( Ilmu dan Teknologi Kebumian )',2023,'085756231750','yenisagustin77@gmail.com','2026-10-25 03:07:52',''),
(5,'rizki','unit 12','Universitas Negeri Gorontalo','ekonomi','ilmu ekonomi',2023,'085827844853','ki2456505@gmail.com','2026-10-25 03:07:52','-'),
(6,'Mita Haerani','Karya Makmur','Universitas Negeri Gorontalo','Ekonomi','Akuntansi',2023,'085825308517','mitahaerani9@gmail.com','2026-10-25 03:07:52','-'),
(7,'Agnes Novianti','Sidoharjo','Universitas Negeri Gorontalo','Sastra dan Budaya','Pend.Bahasa Dan Sastra Indonesia',2023,'085756907362','nvntyagns@gmail.com','2026-10-25 03:07:52','O'),
(8,'Eva Putri Magfirah','Minakarya','Universitas Negeri Gorontalo','Sastra Dan Budaya','Pend. Bahasa Dan Sastra Indonesia',2023,'0815-2380-4182','magfirahputri208@gmail.com','2026-10-25 03:07:52','O'),
(9,'Dewi Fitriani','Batui Selatan','Universitas Negeri Gorontalo','Ilmu Pendidikan','S1 PG-PAUD',2023,'085756613778','dewifitriani262@gmail.com','2026-10-25 03:07:52','O'),
(10,'MIA NUR ARA','TOLISU','Universitas Negeri Gorontalo','ILMU PENDIDIKAN','PG-PAUD',2023,'+62 853-4284-4915','mianurara291@gmail.com','2026-10-25 03:07:52',''),
(11,'Stevi Khairunisa','UNIT 12 TIRTA JAYA','Universitas Negeri Gorontalo','Ekonomi','Manajemen',2023,'082299707638','stevikhairunisa@gmail.com','2026-10-25 03:07:52','O'),
(12,'Agyl Aprilianti','SentralSari u7','Universitas Negeri Gorontalo','Pertanian','Agribisnis',2023,'085340929574','apriliantiagyl05@gmail.com','2026-10-25 03:07:52',''),
(13,'Marlona','Ombolu sulteng','Universitas Negeri Gorontalo','Sastra Dan Budaya','Pendidikan Bahasa Dan Sastra Indonesia',2023,'081523722616','marlonamattoangin@gmail.com','2026-10-25 03:07:52','A'),
(14,'M.Yusril A.S','Tolisu','Universitas Negeri Gorontalo','Pertanian','S1-Ilmu Dan Teknologi Pangan',2023,'085298501532','Muh.yusril10des@gmail.com','2026-10-25 03:07:52','B'),
(15,'Naufal Fahrudin','Minahaki,Singkoyo','Universitas Negeri Gorontalo','Program Vokasi','Teknologi Rekayasa Perangkat Lunak',2023,'082214232970, 085825','yahahahayyuukk00@gmail.com','2026-10-25 03:07:52',''),
(16,'indah safitri','tohitisari topo 8','Universitas Negeri Gorontalo','ekonomi','manajemen',2023,'085757468354','indahsafitri7702@gmail.com','2026-10-25 03:07:52',''),
(17,'Aditya sulaeman','Singkoyo','Universitas Negeri Gorontalo','pertanian','peternakan',2023,'081543280235','adityasulaeman63@gmail.com','2026-10-25 03:07:52','O'),
(18,'Amanda firdasia','desa moilong','Universitas negeri Gorontalo','olahraga dan kesehatan','Farmasi',2023,'','','2026-10-25 03:07:52',''),
(19,'HERWAN ASEP UTOMO','TOILI BARAT','Universitas Negeri Gorontalo','TEKNIK','TEKNIK SIPIL',2023,'082315976540','herwanmuhammad225@gmail.com','2026-10-25 03:07:52','-'),
(20,'Putri','Desa Bukit Jaya (unt 24)','Universitas Negeri Gorontalo','Teknik','Seni Rupa & Desain',2023,'081288984439','mputtri935@gmail.com','2026-10-25 03:07:52','AB'),
(21,'Aji Muhamad landung','U1 KARANGANYAR','Universitas Negeri Gorontalo','Teknik','Teknik Informatika',2023,'089530211478','ajigudek034@gmail.com','2026-10-25 03:07:52','-'),
(22,'Hendrik Rahmadan','toili U12','Universitas Negeri Gorontalo','Teknik','Teknik Elektro',2023,'085298794086','hendrikramadhan1110@gmail.com','2026-10-25 03:07:52',''),
(23,'MOH. FIRKAN HIDAYAT','piondo','Universitas Negeri Gorontalo','Teknik','Teknik Elektro',2022,'085340328187','mohfirkanhidayat@gmail.com','2026-10-25 03:07:52','-'),
(24,'KAMAL FIRDAUS','Bukit jaya','Universitas negeri Gorontalo','Fakultas olahraga dan kesehatan','Penjaskesrek',2022,'082260969418','kamalfirdaus110317@gmail.com','2026-10-25 03:07:52','O'),
(25,'M. YUSUF','Mulyoharjo','Universitas Negeri Gorontalo','TEKNIK','ELEKTRO',2022,'081342981251','muhamadyusuf762004@gmail.com','2026-10-25 03:07:52','-'),
(26,'SIGIT TARYANTO','Piondo','Universitas Negeri Gorontalo','Teknik','Teknik Elektro',2022,'082213095523','sigittaryanto@gmail.com','2026-10-25 03:07:52','-'),
(27,'ARIS KURNIAWAN','Minakarya','Universitas Negeri Gorontalo','Ekonomi','Manajemen',2022,'085657142706','*ariskurniawan040802@gmail.com','2026-10-25 03:07:52','B'),
(28,'TIKA NIRMALA','Sukamaju SPB','Universitas Negeri Gorontalo','Pertanian','Agroteknologi',2022,'085827844607','tikanirmala85@gmail.com','2026-10-25 03:07:52','-'),
(29,'ELISTRI HAYATI','Tanasumpu','Universitas Negeri Gorontalo','Pertanian','Ilmu dan Teknologi Pangan',2022,'085397461591','elistrihayati@06gmail.com','2026-10-25 03:07:52','-'),
(30,'PIANA SAPUTRI','Mulyoharjo','Universitas Negeri Gorontalo','Ekonomi','Manajemen',2022,'085825308721','pianasaputri183@gmail.com','2026-10-25 03:07:52','B'),
(31,'IKA SAFITRI','Suwakarsa','Universitas Negeri Gorontalo','Teknik','Informatika',2022,'082291806836','ika95120@gmail.com','2026-10-25 03:07:52','-'),
(32,'ARDIANSYAH','Sentral Sari','Universitas Negeri Gorontalo','Fakultas Teknik','Teknik Elektro',2022,'085211304309','ardiansyah04309@gmail.com','2026-10-25 03:07:52','B'),
(33,'KURNIAWAN','Piondo','Universitas Negeri Gorontalo','Kelautan dan Teknologi Peirkanan','Budidaya Perairan',2022,'085249925825','kurniawan.denggel104@gmail.com','2026-10-25 03:07:52','O'),
(34,'RIFKI SATRIAWAN','Mulyoharjo','Universitas Negeri Gorontalo','Pertanian','Peternakan',2022,'082190710158','Chendolvlog@gmail.com','2026-10-25 03:07:52','-'),
(35,'ALVIANA','Saluan','Universitas Negeri Gorontalo','Ilmu Sosial','Administrasi Publik',2022,'085656097164','alviana79916@gmail.com','2026-10-25 03:07:52','-'),
(36,'HIZRA QORISTIVA','Sidoharjo','Universitas Negeri Gorontalo','Ilmu Pendidikan','Pg Paud',2022,'085156920554','qoristivah@gmail.com','2026-10-25 03:07:52','-'),
(37,'MAYA LIYANTI','Rusa Kencana','Universitas Negeri Gorontalo','Ekonomi','Manajemen',2022,'08164334612','mayaliyanti125@gmail.com','2026-10-25 03:07:52','O'),
(38,'TRI APRI WIJAYA','Sidomakmur','Universitas negeri Gorontalo','Teknik','Informatika',2022,'085242648996','triapriwijaya@gmail.com','2026-10-25 03:07:52','O'),
(39,'LISA INDRIANI','Cendanapura','Universitas Negeri Gorontalo','MIPA','Matematika',2022,'081527961887','Lisaindriani794@gmail.com','2026-10-25 03:07:52','-'),
(40,'RIZAL IDAMANTO','Karya Jaya','Universitas Negeri Gorontalo','Ekonomi','Manajemen',2022,'082214501726','rizalidamanto@gmail.com','2026-10-25 03:07:52','A'),
(41,'GABRIEL STELLA SINAY','Bukit Jaya','Universitas Negeri Gorontalo','Program Vokasi','Teknologi Rekayasa Energi Terbarukan',2022,'081523721563','gebyprasetyo51@gmail.com','2026-10-25 03:07:52','-'),
(42,'PUTRI LESTARI','Minakarya','Universitas Negeri Gorontalo','Teknik','Teknik Informatika',2022,'085656990731','lestariputri3724@gmail.com','2026-10-25 03:07:52','B'),
(43,'RIKI HERMAWAN','Cendana','Universitas Negeri Gorontalo','MIPA','Teknik Geologi',2022,'085696550958','28rikihermawan@gmail.com','2026-10-25 03:07:52','AB'),
(44,'RENDI FEBRIANSYAH','Rusakencana','Universitas Negeri Gorontalo','Teknik','Teknik Industri',2022,'082258798708','rendyfebriansya900@gmail.com','2026-10-25 03:07:52','A'),
(45,'CINDY FEBRIANA','Cendanapura','Universitas Negeri Gorontalo','Sastra dan Budaya','Pend. Bahasa dan Sastra Indonesia',2022,'082291991631','cndyfbr011@gmail.com','2026-10-25 03:07:52','A'),
(46,'DIAH ARI SUSANTI','Minakarya','Universitas Negeri Gorontalo','Ekonomi','Manajemen',2022,'085825475880','dea280071@gmail.com','2026-10-25 03:07:52','O'),
(47,'INDAYANI TANDILILING','Jayakencana','Universitas Negeri Gorontalo','MIPA','Biologi Murni',2022,'082249027926','indaliling@gmail.com','2026-10-25 03:07:52','O'),
(48,'ZUL HAMID ANSYOR','TOLISU','Universitas Negeri Gorontalo','Program Vokasi','Teknologi Rekayasa Energi Terbarukan',2022,'082393236901','zulkha1924@gmail.com','2026-10-25 03:07:52','-'),
(49,'FATIMAH','sukamaju 1','Universitas Negeri Gorontalo','Ekonomi','Akuntansi',2022,'085823602815','ft57246@gmail.com','2026-10-25 03:07:52','-'),
(50,'AMELIA ALFIATY','Rusakencana','universitas negeri Gorontalo','ilmu pendidikan','pgpaud',2022,'08164340694','ameliaalfiaty8@gmail.com','2026-10-25 03:07:52','B'),
(51,'BAMBANG ISDIANTORO','Slametharjo','Universitas Negeri Gorontalo','Teknik','Informatika',2022,'082293610329','Bambangisdiantoro40@gmail.com','2026-10-25 03:07:52','B'),
(52,'LIA DEVI','Karya Jaya','Universitas Negeri Gorontalo','Ilmu Sosial','Ilmu Hukum dan Kemasyarakatan',2022,'082343124920','liadevisusanti19@gmail.com','2026-10-25 03:07:52','O:'),
(53,'Ahmad Rianto tawil','pandanwangi kecamatan Toili barat kabupaten Banggai','Universitas Negeri Gorontalo','ekonomi','akuntansi',2021,'085757453368','riantawil069@gmail.com','2026-10-25 03:07:52',''),
(54,'AANG ENDRIANTO','Minakarya','universitas Negeri Gorontalo','ekonomi','pendidikan ekonomi',2021,'082296124503','aangendriantofk67@gmail.com','2026-10-25 03:07:52','-'),
(55,'Debi Maryani','Minakarya','Universitas Negeri Gorontalo','Olahraga dan Kesehatan','Kesehatan Masyarakat',2021,'082293492761','debymaryani345@gmail.com','2026-10-25 03:07:52','O'),
(56,'Yulaika','Minakarya','Universitas Negeri Gorontalo','Ilmu pendidikan','PGPAUD',2021,'085796515288','yulaikaaugustus@gmail.com','2026-10-25 03:07:52',''),
(57,'Intan Rhomadona','Unit 24 (Bukit Jaya)','Universitas Negeri Gorontalo','Ekonomi','Manajemen',2021,'081523638959','intanrhomadona07@gmail.com','2026-10-25 03:07:52','-'),
(58,'lusya','gunung Kramat','Nahdlatul Ulama Gorontalo','kesehatan','psikologi',2021,'082260869924','lusya070903@gmail.com','2026-10-25 03:07:52','-'),
(59,'Ari Sabarno','Topo','Universitas Negeri Gorontalo','Ekonomi Dan bisnis','manajemen',2021,'085824261191','ariesabarno86@gmail.com','2026-10-25 03:07:52','A'),
(60,'moh rifaldi','desa sidoharjo','universitas negeri gorontalo','teknik','elektro',2021,'085823960892','moh.rifaldi072002@gmail.com','2026-10-25 03:07:52',''),
(61,'Lia Nur Anisa','Desa piondo','Universitas Negeri Gorontalo','FMIPA','Matematika',2021,'082259963953','lianuranisa12@gmail.com','2026-10-25 03:07:52','A'),
(62,'Samsul Hilal','Ds. Tanah Abang, kec. Toili , Kab. Banggai','Universitas Negri Gorontalo','Ekonomi','Manajemen',2021,'081527262094','samsulhilal@gmail.com','2026-10-25 03:07:52','A'),
(63,'Yuni Yusnita','Tohiti Sari','Universitas Negeri Gorontalo','Teknik','Teknik Industri',2021,'085823939432','yuniyusnita32@gmail.com','2026-10-25 03:07:52','O'),
(64,'rizki ani','rusa kencana','Universitas Negeri Gorontalo','kedokteran','kedokteran',2021,'085172376349','anitizky994@gmail.com','2026-10-25 03:07:52','AB'),
(65,'Dwi Amalia','Desa Minakarya','Universitas Negeri Gorontalo','FMIPA','Teknik Geologi',2021,'085696603049','dwiamalia010704@gmail.com','2026-10-25 03:07:52','B'),
(66,'MIFTAHUR RAZIQ','SIDOMAKMUR KECAMATAN MOILONG','Universitas Negeri Gorontalo','FAKULTAS TEKNIK','TEKNIK SIPIL',2021,'085784630549','mieftahurraziq@gmail.com','2026-10-25 03:07:52','O'),
(67,'Siti eka Amalia','Dongin,kec Toili barat','1','Olahraga dan kesehatan','Farmasi',2021,'085657141136','ekhaphisces60255@gmail.com','2026-10-25 03:07:52','A-'),
(68,'Anggi Sofiani','Mansahang','Universitas Negeri Gorontalo','Teknik','Teknik Sipil, prodi PVKB',2021,'081526044267','anggisofiani890@gmail.com','2026-10-25 03:07:53','A-'),
(69,'Feni Elliyin','Kelurahan Cendana, Kecamatan Toili','Universitas Negeri Gorontalo','FMIPA','Matematika',2021,'085757773233','feniellyn@gmail.com','2026-10-25 03:07:53','');
/*!40000 ALTER TABLE `anggota` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Dump completed on 2026-10-26 13:13:30

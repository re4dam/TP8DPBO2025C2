/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: db_perwalian
-- ------------------------------------------------------
-- Server version	11.7.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nama` (`nama`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
INSERT INTO `faculty` VALUES
(1,'Fakultas Pendidikan Matematika dan Ilmu Pengetahuan Alam','FPMIPA'),
(2,'Fakultas Pendidikan Ilmu Pengetahuan Sosial','FPIPS'),
(3,'Fakultas Pendidikan Bahasa dan Sastra','FPBS'),
(4,'Fakultas Pendidikan Teknologi dan Kejuruan','FPTK'),
(5,'Fakultas Pendidikan Olahraga dan Kesehatan','FPOK'),
(6,'Fakultas Pendidikan Seni dan Desain','FPSD'),
(7,'Fakultas Pendidikan Ekonomi dan Bisnis','FPEB');
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturer`
--

DROP TABLE IF EXISTS `lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `work_date` date DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `id_program_study` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nip` (`nip`),
  KEY `id_program_study` (`id_program_study`),
  CONSTRAINT `lecturer_ibfk_1` FOREIGN KEY (`id_program_study`) REFERENCES `program_study` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturer`
--

LOCK TABLES `lecturer` WRITE;
/*!40000 ALTER TABLE `lecturer` DISABLE KEYS */;
INSERT INTO `lecturer` VALUES
(1,'Prof. Dr. Ahmad Sanusi, M.Pd.','196003011987031001','081122334455','1987-03-01','1987-03-01',1),
(2,'Dr. Budi Santoso, M.Si.','197112121995032002','081233445566','1995-03-12','1995-03-12',1),
(3,'Dr. Citra Dewi, M.Kom.','198205152005012003','081344556677','2005-01-15','2005-01-15',5),
(4,'Dr. Dedi Supriadi, M.Hum.','197508101998031004','081455667788','1998-03-10','1998-03-10',6),
(5,'Dra. Euis Nurhayati, M.Pd.','196712311987032005','081566778899','1987-03-12','1987-03-12',7),
(6,'Prof. Dr. Fauzi Abdullah, M.A.','195911011985031006','081677889900','1985-03-01','1985-03-01',9),
(7,'Dr. Gita Paramita, M.Pd.','198010102005012007','081788990011','2005-01-10','2005-01-10',10),
(8,'Ir. Hadi Pranoto, M.T.','197303151996031008','081899001122','1996-03-15','1996-03-15',12),
(9,'Dr. Indra Kusuma, M.Pd.','198112052006012009','081900112233','2006-01-05','2006-01-05',13),
(10,'Drs. Joko Susilo, M.Kes.','196504151989031010','082011223344','1989-03-15','1989-03-15',15),
(11,'Dr. Kurniawati, M.Pd.','197809202003012011','082122334455','2003-01-20','2003-01-20',16),
(12,'Dra. Lestari Handayani, M.Sn.','197102141997032012','082233445566','1997-03-14','1997-03-14',17),
(13,'Dr. Maman Suherman, M.Pd.','196808151991031013','082344556677','1991-03-15','1991-03-15',18),
(14,'Prof. Dr. Nana Supriatna, M.M.','195712011984031014','082455667788','1984-03-01','1984-03-01',19),
(15,'Dr. Oki Wijaya, S.E., M.Si.','198306102008011015','082566778899','2008-01-10','2008-01-10',20);
/*!40000 ALTER TABLE `lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_study`
--

DROP TABLE IF EXISTS `program_study`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_study` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `id_faculty` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`),
  KEY `id_faculty` (`id_faculty`),
  CONSTRAINT `program_study_ibfk_1` FOREIGN KEY (`id_faculty`) REFERENCES `faculty` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_study`
--

LOCK TABLES `program_study` WRITE;
/*!40000 ALTER TABLE `program_study` DISABLE KEYS */;
INSERT INTO `program_study` VALUES
(1,'Pendidikan Matematika','PMAT',1),
(2,'Pendidikan Fisika','PFIS',1),
(3,'Pendidikan Kimia','PKIM',1),
(4,'Pendidikan Biologi','PBIO',1),
(5,'Ilmu Komputer','ILKOM',1),
(6,'Pendidikan Sejarah','PSEJ',2),
(7,'Pendidikan Geografi','PGEO',2),
(8,'Pendidikan Kewarganegaraan','PKWN',2),
(9,'Pendidikan Bahasa Inggris','PBI',3),
(10,'Pendidikan Bahasa Indonesia','PBSI',3),
(11,'Pendidikan Bahasa Arab','PBA',3),
(12,'Pendidikan Teknik Elektro','PTE',4),
(13,'Pendidikan Teknik Mesin','PTM',4),
(14,'Pendidikan Teknik Arsitektur','PTA',4),
(15,'Pendidikan Jasmani','PJKR',5),
(16,'Ilmu Keolahragaan','IKOR',5),
(17,'Pendidikan Seni Rupa','PSR',6),
(18,'Pendidikan Seni Musik','PSM',6),
(19,'Pendidikan Ekonomi','PEKO',7),
(20,'Manajemen','MNJ',7),
(21,'Akuntansi','AKT',7);
/*!40000 ALTER TABLE `program_study` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `nim` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `angkatan` varchar(20) DEFAULT NULL,
  `id_program_study` int(11) DEFAULT NULL,
  `id_lecturer` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nim` (`nim`),
  KEY `id_program_study` (`id_program_study`),
  KEY `id_lecturer` (`id_lecturer`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`id_program_study`) REFERENCES `program_study` (`id`),
  CONSTRAINT `student_ibfk_2` FOREIGN KEY (`id_lecturer`) REFERENCES `lecturer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES
(1,'Rina Amelia','2101234','rina.amelia@student.upi.edu','Female','081234567890','2002-05-15','Jl. Setiabudhi No. 229, Bandung','2021',1,1),
(2,'Budi Santoso','2102345','budi.santoso@student.upi.edu','Male','081345678901','2001-08-20','Jl. Dr. Setiabudhi No. 229, Bandung','2021',2,2),
(3,'Citra Dewi','2103456','citra.dewi@student.upi.edu','Female','081456789012','2003-02-10','Jl. Setiabudhi No. 229, Bandung','2021',5,3),
(4,'Dedi Kurniawan','2104567','dedi.kurniawan@student.upi.edu','Male','081567890123','2002-11-25','Jl. Dr. Setiabudhi No. 229, Bandung','2021',6,4),
(5,'Eka Putri','2105678','eka.putri@student.upi.edu','Female','081678901234','2001-07-30','Jl. Setiabudhi No. 229, Bandung','2021',7,5),
(6,'Fajar Ramadhan','2106789','fajar.ramadhan@student.upi.edu','Male','081789012345','2002-04-05','Jl. Dr. Setiabudhi No. 229, Bandung','2021',9,6),
(7,'Gina Sari','2107890','gina.sari@student.upi.edu','Female','081890123456','2003-01-15','Jl. Setiabudhi No. 229, Bandung','2021',10,7),
(8,'Hadi Prasetyo','2108901','hadi.prasetyo@student.upi.edu','Male','081901234567','2001-09-20','Jl. Dr. Setiabudhi No. 229, Bandung','2021',12,8),
(9,'Intan Permata','2109012','intan.permata@student.upi.edu','Female','082012345678','2002-06-10','Jl. Setiabudhi No. 229, Bandung','2021',13,9),
(10,'Joko Susanto','2110123','joko.susanto@student.upi.edu','Male','082123456789','2001-12-15','Jl. Dr. Setiabudhi No. 229, Bandung','2021',15,10),
(11,'Kartika Dewi','2111234','kartika.dewi@student.upi.edu','Female','082234567890','2003-03-25','Jl. Setiabudhi No. 229, Bandung','2021',16,11),
(12,'Lukman Hakim','2112345','lukman.hakim@student.upi.edu','Male','082345678901','2002-08-05','Jl. Dr. Setiabudhi No. 229, Bandung','2021',17,12),
(13,'Maya Sari','2113456','maya.sari@student.upi.edu','Female','082456789012','2001-10-30','Jl. Setiabudhi No. 229, Bandung','2021',18,13),
(14,'Nando Pratama','2114567','nando.pratama@student.upi.edu','Male','082567890123','2002-07-20','Jl. Dr. Setiabudhi No. 229, Bandung','2021',19,14),
(15,'Olivia Putri','2115678','olivia.putri@student.upi.edu','Female','082678901234','2003-04-10','Jl. Setiabudhi No. 229, Bandung','2021',20,15);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wali_session`
--

DROP TABLE IF EXISTS `wali_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wali_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_student` int(11) NOT NULL,
  `id_lecturer` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `topik` text DEFAULT NULL,
  `status` enum('scheduled','done','cancelled') DEFAULT 'scheduled',
  `catatan` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_student` (`id_student`),
  KEY `id_lecturer` (`id_lecturer`),
  CONSTRAINT `wali_session_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  CONSTRAINT `wali_session_ibfk_2` FOREIGN KEY (`id_lecturer`) REFERENCES `lecturer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wali_session`
--

LOCK TABLES `wali_session` WRITE;
/*!40000 ALTER TABLE `wali_session` DISABLE KEYS */;
INSERT INTO `wali_session` VALUES
(1,1,1,'2023-09-15','Pembahasan IPK Semester Ganjil 2022/2023','done','Mahasiswa perlu meningkatkan prestasi akademik'),
(2,1,1,'2023-10-20','Penyusunan KRS Semester Genap 2023/2024','done','Mahasiswa mengambil 20 SKS untuk semester depan'),
(3,2,2,'2023-09-18','Konsultasi masalah belajar','done','Mahasiswa mengalami kesulitan dalam mata kuliah Fisika Dasar'),
(4,3,3,'2023-10-05','Bimbingan skripsi','scheduled','Pembahasan bab 1 dan 2 skripsi'),
(5,4,4,'2023-09-22','Konseling masalah pribadi','done','Mahasiswa membutuhkan motivasi untuk melanjutkan studi'),
(6,5,5,'2023-10-10','Pembahasan rencana magang','scheduled','Mahasiswa akan magang di sekolah mitra'),
(7,6,6,'2023-09-25','Pembahasan nilai TOEFL','done','Mahasiswa perlu meningkatkan nilai TOEFL untuk persyaratan wisuda'),
(8,7,7,'2023-10-15','Bimbingan PKM','scheduled','Persiapan pengajuan proposal PKM'),
(9,8,8,'2023-09-28','Konsultasi peminatan','done','Mahasiswa memilih peminatan sistem kontrol'),
(10,9,9,'2023-10-18','Pembahasan KKN','scheduled','Persiapan pelaksanaan KKN di daerah terpencil'),
(11,10,10,'2023-09-30','Evaluasi prestasi olahraga','done','Mahasiswa berprestasi di kejuaraan tingkat nasional'),
(12,11,11,'2023-10-20','Bimbingan tugas akhir','scheduled','Pembahasan metodologi penelitian'),
(13,12,12,'2023-10-03','Konsultasi pameran seni','done','Mahasiswa akan mengadakan pameran seni rupa'),
(14,13,13,'2023-10-22','Pembahasan magang industri','scheduled','Mahasiswa akan magang di perusahaan multinasional'),
(15,14,14,'2023-10-05','Konseling karir','done','Mahasiswa berencana melanjutkan studi S2'),
(16,15,15,'2023-10-25','Bimbingan proposal tesis','scheduled','Penyusunan proposal tesis untuk S2');
/*!40000 ALTER TABLE `wali_session` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-05-04 12:29:45

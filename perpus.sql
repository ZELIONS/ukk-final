-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Mar 2024 pada 17.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int(12) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun_terbit` int(12) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `sinopsis` longtext DEFAULT NULL,
  `bahasa` varchar(255) DEFAULT NULL,
  `jumlah_halaman` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `gambar`, `sinopsis`, `bahasa`, `jumlah_halaman`) VALUES
(41, 'The Alchemist', 'Paulo Coelho', 'HarperOne', 1988, 'the_alchemist_65e5f006d4061.webp', 'Mengikuti kisah Santiago, seorang gembala muda Andalusia yang bermimpi menemukan harta karun yang tersembunyi di Piramida Mesir. Petualangannya membawanya pada perjalanan spiritual yang mendalam, di mana ia belajar mengenali takdirnya sendiri dan makna sejati dalam hidup.', 'Inggris', 549),
(42, 'To Kill a Mockingbird', 'Harper Lee', 'Harper Lee', 1960, 'to_kill_a_mockingbird_65e5f06a0991e.webp', 'Cerita ini berkisah tentang kehidupan seorang anak perempuan bernama Scout Finch di sebuah kota kecil di Alabama, AS, selama era Depresi Besar. Ia memperjuangkan keadilan dan melawan prasangka ketika ayahnya, seorang pengacara, membela seorang pria kulit hitam yang dituduh melakukan pemerkosaan.\r\n', 'Inggris', 989),
(43, '1984', 'George Orwell', 'Secker and Warburg', 1949, '1984_65e5f0d990573.jpg', 'Di dunia yang dikuasai oleh pemerintahan totaliter, Winston Smith menjadi terlibat dalam perlawanan terhadap kekuasaan yang menindas. Melalui kisahnya, Orwell menggambarkan konsekuensi mengerikan dari manipulasi informasi, pengawasan yang ketat, dan kehilangan kebebasan individu.', 'Inggris', 450),
(46, 'Pride and Prejudice', 'Jane Austen', 'T. Egerton, Whitehall', 1813, 'pride_and_prejudice_65e5f33b06aa5.jpg', ' Kisah cinta antara Elizabeth Bennet, seorang wanita cerdas dan independen, dan Mr. Darcy, seorang pria kaya dan sombong. Melalui intrik sosial, prasangka, dan cinta yang tumbuh, Austen menggambarkan kehidupan kaum bangsawan Inggris pada awal abad ke-19.', 'Francis', 876),
(47, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Charles Scribner\'s Sons', 1925, 'the_great_gatsby_65e5f3d5edc10.jpg', 'Di era Roaring Twenties, Jay Gatsby, seorang miliuner misterius, menjalani kehidupan glamor di Long Island. Cerita ini menggambarkan kekayaan, keinginan, dan keruntuhan moral dalam masyarakat Amerika pasca-Perang Dunia I.', 'Inggris', 1089),
(48, 'The Catcher in the Rye', 'J.D. Salinger', 'Little, Brown and Company', 1951, 'the_catcher_in_the_rye_65e5f481f0e15.jpg', 'Dalam cerita yang kontroversial ini, kita mengikuti perjalanan Holden Caulfield, seorang remaja yang berjuang untuk menemukan makna dalam kehidupannya. Melalui narasinya yang sinis, Holden mengeksplorasi tema-tema seperti alienasi, kehilangan, dan pencarian identitas.', 'Inggris', 987),
(49, 'The Hunger Games', ' Suzanne Collins', 'Scholastic Press', 2008, 'the_hunger_games_65e5f4d7b0b1e.jpeg', 'Dalam dunia distopia yang kejam, Capitol mengadakan acara tahunan bernama Hunger Games di mana anak-anak dipaksa untuk bertarung sampai mati sebagai hiburan untuk penduduknya. Ketika adiknya dipilih sebagai peserta, Katniss Everdeen terpaksa berjuang untuk bertahan hidup dalam permainan mematikan ini.', 'Inggris', 886),
(50, 'The Da Vinci Code', 'Dan Brown', ' Doubleday', 2003, 'the_da_vinci_code_65e5f57ed3d2d.jpg', 'Profesor simbologi Harvard, Robert Langdon, terjebak dalam serangkaian misteri yang melibatkan organisasi rahasia, simbol-simbol kuno, dan teka-teki sejarah tersembunyi. Dengan bantuan Sophie Neveu, mereka berusaha memecahkan kode-kode yang mengungkap rahasia besar yang telah disembunyikan selama berabad-abad.', 'Inggris', 543),
(51, 'The Road', 'Cormac McCarthy', 'Alfred A. Knopf', 2006, 'the_road_65e5f5dc1ddc1.jpg', 'Dalam dunia pasca-apokaliptik yang sunyi dan gersang, seorang ayah dan anaknya melakukan perjalanan melintasi pemandangan yang terpenuhi oleh kehancuran dan kejahatan. Mereka berusaha bertahan hidup sambil mempertahankan kebaikan dan kemanusiaan dalam keadaan yang putus asa.', 'Rusia', 864),
(52, 'The Hitchhiker\'s Guide to the Galaxy', 'Douglas Adams', 'Pan Books', 1979, 'the_hitchhiker\'s_guide_to_the_galaxy_65e5f68c0837e.jpg', 'Arthur Dent, seorang manusia biasa yang secara tidak sengaja terlibat dalam perjalanan luar biasa ke luar angkasa setelah Bumi dihancurkan untuk memberi jalan bagi jalan tol antargalaksi. Ditemani oleh alien yang eksentrik, Ford Prefect, Arthur menjelajahi alam semesta dengan buku petunjuk yang aneh, \"The Hitchhiker\'s Guide to the Galaxy\".', 'Spanyol', 560),
(53, 'The Diary of a Young Girl', ' Anne Frank', 'Contact Publishing', 1947, 'the_diary_of_a_young_girl_65e5f77d00d1c.jpg', ' Anne Frank, seorang gadis Yahudi Belanda, menyimpan harian selama ia dan keluarganya bersembunyi dari penjajah Nazi di Amsterdam selama Perang Dunia II. Harian ini memberikan wawasan yang intim tentang pengalaman hidup dalam penyamaran yang terus-menerus dan kekhawatiran yang menghantui mereka.', 'Belanda', 1000),
(54, 'The Kite Runner', 'Khaled Hosseini', 'Khaled Hosseini', 2003, 'the_kite_runner_65e5f7d3ac991.jpg', 'Mengikuti kisah Amir, seorang pemuda dari Afghanistan, yang terjalin dengan peristiwa-peristiwa dramatis di negaranya sejak tahun 1970-an hingga saat ini. Melalui hubungannya dengan teman masa kecilnya, Hassan, dan perjalanan panjangnya untuk menebus dosa masa lalunya, Hosseini mengeksplorasi tema-tema seperti persahabatan, pengkhianatan, dan keadilan.', 'Jepang', 121),
(55, 'One Piece', ' Eiichiro Oda', 'Shueisha', 1997, 'one_piece_65e5f82697c3c.jpg', 'Monkey D. Luffy dan kru bajak laut Topi Jerami berlayar melintasi lautan Grand Line dalam pencarian harta karun legendaris bernama One Piece. Mereka menghadapi berbagai petualangan, bertemu dengan karakter-karakter unik, dan terlibat dalam pertempuran epik dengan musuh-musuh yang kuat.', 'Jepang', 1020),
(56, 'Norwegian Wood', 'Haruki Murakami', ' Kodansha', 1987, 'norwegian_wood_65e5f8933c7b7.jpg', 'Ketika Toru Watanabe mendengarkan lagu \"Norwegian Wood\" di pesawat terbang, ia diingatkan pada masa lalunya, khususnya hubungannya dengan Naoko dan Midori. Novel ini menggambarkan percintaan, kehilangan, dan pencarian makna dalam kehidupan di Jepang tahun 1960-an.', 'Norway', 545),
(57, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', 'Norstedts Förlag', 2005, 'the_girl_with_the_dragon_tattoo_65e5f8d24f6c3.jpg', ' Jurnalis Mikael Blomkvist dan hacker Lisbeth Salander berusaha memecahkan misteri pembunuhan yang terjadi dalam keluarga Vanger yang kaya raya. Melalui penyelidikan yang intens, mereka mengungkap rahasia kelam yang tersembunyi di balik wajah terpandang dari lingkaran elit Swedia.', 'Francis', 655);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(12) NOT NULL,
  `nama_kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(30, 'Drama'),
(26, 'Fantasi'),
(22, 'Fiksi'),
(24, 'Klasik'),
(20, 'Manga'),
(29, 'Misteri'),
(19, 'Novel'),
(27, 'Petualangan'),
(25, 'Politik'),
(28, 'Romansa'),
(21, 'Sejarah'),
(23, 'Spiritual');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_buku_relasi`
--

CREATE TABLE `kategori_buku_relasi` (
  `id` int(12) NOT NULL,
  `buku_id` int(12) DEFAULT NULL,
  `kategori_id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_buku_relasi`
--

INSERT INTO `kategori_buku_relasi` (`id`, `buku_id`, `kategori_id`) VALUES
(26, 41, 22),
(27, 42, 24),
(28, 43, 25),
(31, 46, 28),
(32, 47, 22),
(33, 48, 24),
(34, 49, 27),
(35, 50, 29),
(36, 51, 25),
(37, 52, 23),
(38, 53, 19),
(39, 54, NULL),
(40, 55, 20),
(41, 56, 19),
(42, 57, 29);

-- --------------------------------------------------------

--
-- Struktur dari tabel `koleksi`
--

CREATE TABLE `koleksi` (
  `id` int(12) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `buku_id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `masukan`
--

CREATE TABLE `masukan` (
  `id` int(12) NOT NULL,
  `masukan` longtext DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `user_id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `masukan`
--

INSERT INTO `masukan` (`id`, `masukan`, `tanggal`, `user_id`) VALUES
(1, 'maaf yah', '2024-02-22', 15),
(2, 'aku cinta engel', '2024-02-22', 16),
(3, 'aku cinta engel', '2022-02-24', 16),
(5, 'hebat', '2024-02-22', 16),
(6, 'bang ardi gacor', '2024-02-26', 15),
(7, 'gweh nadia', '2024-02-29', 15);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(12) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `buku_id` int(12) DEFAULT NULL,
  `tanggal_peminjaman` date DEFAULT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `status_peminjaman` enum('sudah dikembalikan','belum dikembalikan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ulasan_buku`
--

CREATE TABLE `ulasan_buku` (
  `id` int(12) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `buku_id` int(12) DEFAULT NULL,
  `ulasan` longtext DEFAULT NULL,
  `rating` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','petugas','peminjam') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama_lengkap`, `username`, `email`, `alamat`, `password`, `role`) VALUES
(14, 'admin', 'admin', 'admin@mail.com', 'admin', '$2y$10$gCpwcKWX/x12RUYRkWexHOxu8/ClxxS1tWZR.8cr4ChOwHd/Nx/W.', 'admin'),
(15, 'peminjam', 'peminjam', 'peminjam@mail.com', 'peminjam', '$2y$10$bu2nqsqxhHb9sxC/7RUppu8aCcEMKyQh0/ffFSJLt2IJYUmymj6pS', 'peminjam'),
(16, 'josua', 'josua', 'josua@mail.com', 'josua', '$2y$10$33V25nF85OppRGijG2LIMuPpeNLX0pgZM9pem2GyczgQGipkILkmK', 'peminjam'),
(17, 'petugas', 'petugas', 'petugas@mail.com', 'petugas', '$2y$10$0Wxv2DWaOHIT6u93EzyJ6eizDuSXY.1/uhjhl/.JZUqloCsKorm7O', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `judul` (`judul`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indeks untuk tabel `kategori_buku_relasi`
--
ALTER TABLE `kategori_buku_relasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buku_id` (`buku_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `koleksi`
--
ALTER TABLE `koleksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indeks untuk tabel `masukan`
--
ALTER TABLE `masukan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indeks untuk tabel `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `kategori_buku_relasi`
--
ALTER TABLE `kategori_buku_relasi`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `koleksi`
--
ALTER TABLE `koleksi`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `masukan`
--
ALTER TABLE `masukan`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kategori_buku_relasi`
--
ALTER TABLE `kategori_buku_relasi`
  ADD CONSTRAINT `kategori_buku_relasi_ibfk_1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`),
  ADD CONSTRAINT `kategori_buku_relasi_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Ketidakleluasaan untuk tabel `koleksi`
--
ALTER TABLE `koleksi`
  ADD CONSTRAINT `koleksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `koleksi_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`);

--
-- Ketidakleluasaan untuk tabel `masukan`
--
ALTER TABLE `masukan`
  ADD CONSTRAINT `masukan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`);

--
-- Ketidakleluasaan untuk tabel `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD CONSTRAINT `ulasan_buku_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `ulasan_buku_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

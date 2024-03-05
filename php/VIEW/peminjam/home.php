<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/controller/Peminjam.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'peminjam') {
    header("Location:../../index.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$peminjam = new Peminjam();
$data_kategori = $peminjam->TampilKategori();

$rekomendasi = $peminjam->TampilBukuRekomendasi($limit = 10);
$populer = $peminjam->TampilBukuPopuler($limit = 5);
$group_book = $peminjam->GroupBookByKategori();
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['_search']) && $_GET['_search']) {
    $query = $_GET['input_search'];
    $cari_buku = $peminjam->SearchBook($query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_masukan'])) {
    $masukan = $_POST['masukan'];
    $tanggal = date("Y-m-d");
    $peminjam->Masukan($user_id, $masukan, $tanggal);
    // Setelah pengiriman masukan selesai, lakukan redirect kembali ke halaman ini
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['_kategori'])) {
    $kategori_nama = $_GET['kategori'];
    $buku_kategori = $peminjam->GetAllBukuByKategori($kategori_nama);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="../navbar.css" />
    <link rel="stylesheet" href="../../ASSETS/CSS/peminjam/style.css" />
    <link rel="stylesheet" href="../../ASSETS/CSS/peminjam/footer.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'>
    <link rel="stylesheet" href="./style.css">

    <script src="../navbar.js" defer></script>
    <style>
        .active {
            color: rgb(18, 2, 2);
        }
    </style>
</head>

<body>
    <nav class="nav">
        <i class="uil uil-bars navOpenBtn"></i>
        <a href="#" class="logo">ZELI-book</a>

        <ul class="nav-links">
            <i class="uil uil-times navCloseBtn"></i>
            <li><a href="home.php" class="active" style="color: grey;">Home</a></li>
            <form method="get" action="" name="kategori" id="kategoriForm">
                <select class="select" name="kategori" onchange="submitForm()">
                    <option disabled selected>Pilih Kategori</option>
                    <?php
                    foreach ($data_kategori as $kategori) {
                        echo "<option>" . $kategori['nama_kategori'] . "</option>";
                    }
                    ?>
                </select>
                <input type="hidden" name="_kategori" value="kategori">
            </form>
            <li><a href="pinjaman.php">Pinjaman</a></li>
            <li><a href="koleksi.php">Koleksi</a></li>
            <li><a href="#masukan" class="smooth-scroll">Masukan</a></li>
            <li><a href="../../index.php">Logout</a></li>
        </ul>

        <i class="uil uil-search search-icon" id="searchIcon"></i>
        <div class="search-box">
            <i class="uil uil-search search-icon"></i>
            <form style="height:100%" method="get" action="" name="search" onsubmit="return submitForm()">
                <input name="input_search" id="searchInput" type="text" placeholder="Judul/Penulis/kategori..." />
                <input type="hidden" name="_search" value="search">
            </form>


        </div>
    </nav>
    <?php if (isset($query) || !empty($query)): ?>
        <div class="rekomendasi-container">
            <div class="rekomendasi-top-container">
                <div class="rekomendasi-judul-container">
                    <?php if (isset($query)): ?>
                        <p>Hasil Pencarian untuk:
                            <?php echo $query; ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($query) && !empty($cari_buku)): ?>
                <div class="rekomendasi-bottom-container">
                    <?php foreach ($cari_buku as $buku): ?>
                        <a class="rekomendasi-card" href="detail-buku.php?id=<?php echo $buku['id']; ?>">
                            <div class="card-gambar"
                                style="background-image: url('../../assets/gambar/<?php echo $buku['gambar']; ?>');">
                                <p class="rating">
                                    <?php echo $buku['rating']; ?>/5
                                </p>
                            </div>
                            <div class="buku-text">
                                <p class="penulis">
                                    <?php echo $buku['penulis']; ?>
                                </p>
                                <p>
                                    <?php echo $buku['judul']; ?>
                                </p>
                                <p class="tahun">
                                    <?php echo $buku['tahun_terbit']; ?>
                                </p>
                                <?php if (isset($buku['kategori_nama'])): ?>
                                    <p class="genre">
                                        <?php echo $buku['kategori_nama']; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Tidak ada buku yang ditemukan.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="rekomendasi-container" style="display: none;">
        </div>
    <?php endif; ?>








    <?php if (isset($kategori_nama) || !empty($buku_kategori)): ?>
        <div class="rekomendasi-container">
            <div class="rekomendasi-top-container">
                <div class="rekomendasi-judul-container">
                    <?php if (isset($kategori_nama)): ?>
                        <p>Hasil Pencarian untuk:
                            <?php echo $kategori_nama; ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($buku_kategori)): ?>
                <div class="rekomendasi-bottom-container">
                    <?php foreach ($buku_kategori as $buku): ?>
                        <a class="rekomendasi-card" href="detail-buku.php?id=<?php echo $buku['id']; ?>">
                            <div class="card-gambar"
                                style="background-image: url('../../assets/gambar/<?php echo $buku['gambar']; ?>');">
                                <p class="rating">
                                    <?php echo $buku['rating']; ?>/5
                                </p>
                            </div>
                            <div class="buku-text">
                                <p class="penulis">
                                    <?php echo $buku['penulis']; ?>
                                </p>
                                <p>
                                    <?php echo $buku['judul']; ?>
                                </p>
                                <p class="tahun">
                                    <?php echo $buku['tahun_terbit']; ?>
                                </p>
                                <?php if (isset($buku['kategori_nama'])): ?>
                                    <p class="genre">
                                        <?php echo $buku['kategori_nama']; ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Tidak ada buku yang ditemukan.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="rekomendasi-container" style="display: none;">
        </div>
    <?php endif; ?>






    <hr>

    <!--Rekomendasi-->
    <div class="rekomendasi-container">
        <div class="rekomendasi-top-container">
            <div class="rekomendasi-judul-container">
                <p>Rekomendasi untukmu</p>
            </div>
        </div>
        <div class="rekomendasi-bottom-container">
            <?php
            foreach ($rekomendasi as $buku) {
                ?>
                <a class="rekomendasi-card" href="detail-buku.php?id=<?php echo $buku['id']; ?>">
                    <div class="card-gambar"
                        style="background-image: url('../../assets/gambar/<?php echo $buku['gambar']; ?>');">
                        <p class="rating">
                            <?php echo $buku['rating'] !== null ? $buku['rating'] . '/5' : 'Rating not available'; ?>
                        </p>
                    </div>
                    <div class="buku-text">
                        <p class="penulis">
                            <?php echo $buku['penulis']; ?>
                        </p>
                        <p>
                            <?php echo $buku['judul']; ?>
                        </p>
                        <p class="tahun">
                            <?php echo $buku['tahun_terbit']; ?>
                        </p>
                        <p class="genre">
                            <?php echo $buku['nama_kategori']; ?>
                        </p>
                    </div>
                </a>
                <?php
            }
            ?>


        </div>

    </div>



    <hr>
    <!--Buku Populer-->
    <div class="rekomendasi-container">
        <div class="rekomendasi-top-container">
            <div class="rekomendasi-judul-container">
                <p>Buku Populer</p>
            </div>
        </div>
        <div class="rekomendasi-bottom-container">

            <?php
            foreach ($populer as $buku) {
                ?>
                <a class="rekomendasi-card" href="detail-buku.php?id=<?php echo $buku['id']; ?>">
                    <div class="card-gambar"
                        style="background-image: url('../../assets/gambar/<?php echo $buku['gambar']; ?>');">
                        <p class="rating">
                            <?php echo $buku['rating'] !== null ? $buku['rating'] . '/5' : 'Rating not available'; ?>
                        </p>
                    </div>
                    <div class="buku-text">
                        <p class="penulis">
                            <?php echo $buku['penulis']; ?>
                        </p>
                        <p>
                            <?php echo $buku['judul']; ?>
                        </p>
                        <p class="tahun">
                            <?php echo $buku['tahun_terbit']; ?>
                        </p>
                        <p class="genre">
                            <?php echo $buku['nama_kategori']; ?>
                        </p>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>

    </div>


    <hr>


    <!--Berdasarkan Genre-->
    <div class="rekomendasi-container">

        <?php
        $group_book = $peminjam->GroupBookByKategori();

        $kategori_sebelumnya = null;

        foreach ($group_book as $buku) {
            if ($buku['nama_kategori'] !== $kategori_sebelumnya) {
                if ($kategori_sebelumnya !== null) {
                    echo '</div>';
                }
                echo '<div class="rekomendasi-top-container">';
                echo '<div class="rekomendasi-judul-container">';
                echo '<p>' . $buku['nama_kategori'] . '</p>';
                echo '</div>';
                echo '</div>';
                echo '<div class="rekomendasi-bottom-container">';
                $kategori_sebelumnya = $buku['nama_kategori'];
            }

            echo '<a class="rekomendasi-card" href="detail-buku.php?id=' . $buku['id_buku'] . '">';
            echo '<div class="card-gambar" style="background-image: url(\'../../assets/gambar/' . $buku['gambar'] . '\');">';
            echo '<p class="rating">' . round($buku['nilai_rating']) . '/5</p>';
            echo '</div>';
            echo '<div class="buku-text">';
            echo '<p class="penulis">' . $buku['penulis'] . '</p>';
            echo '<p>' . $buku['judul'] . '</p>';
            echo '<p class="tahun">' . $buku['tahun_terbit'] . '</p>';
            echo '<p class="genre">' . $buku['nama_kategori'] . '</p>';
            echo '</div>';
            echo '</a>';
        }

        echo '</div>';
        echo '</div>';
        ?>




    </div>
    <hr>

    <div class="container" id="masukan">
        <div class="comment-box gradient-bg">
            <h2 class="comment-title">Kirim Masukan ke ZELI-book</h2>
            <form action="" method="post" name="masukan">
                <div class="form-group">
                    <label for="comment">Masukan:</label>
                    <textarea required id="comment" name="masukan" placeholder="ketik Komentar Anda Disini"></textarea>
                </div>
                <input type="hidden" name="_masukan" value="upload">
                <button type="submit"  class="btn-submit">kirim</button>
            </form>
        </div>
    </div>

    <footer>
        <div class="content">
            <div class="top">
                <div class="logo-details">
                    <i class="fab fa-slack"></i>
                    <span class="logo_name">ZELI-book</span>
                </div>
                <div class="media-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="bottom-details">
            <div class="bottom_text">
                <span class="copyright_text">Copyright © 2024 <a href="#">ZELI-book </a>All rights reserved</span>
                <span class="policy_terms">
                    <a href="#">Privacy policy</a>
                    <a href="#">Terms & condition</a>
                </span>
            </div>
        </div>
    </footer>

    <script>
        function submitForm() {
            document.forms["search"].submit();
            return false;
        }

        document.getElementById("searchInput").addEventListener("keypress", function (event) {
            if (event.keyCode === 13) {
                submitForm();
            }
        });

        function submitForm() {
            document.getElementById("kategoriForm").submit();
        }
        document.addEventListener("DOMContentLoaded", function () {
            var smoothScrollLinks = document.querySelectorAll('.smooth-scroll');

            smoothScrollLinks.forEach(function (link) {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    var targetId = this.getAttribute('href');
                    var targetElement = document.querySelector(targetId);

                    // Menambahkan animasi smooth scroll
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });
        });
    </script>

</body>

</html>
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

$buku = $peminjam->TampilPinjaman($user_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="../navbar.css" />
    <link rel="stylesheet" href="../../ASSETS/CSS/peminjam/pinjaman.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
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
            <li><a href="home.php">Home</a></li>
            <form method="get" action="home.php" name="kategori" id="kategoriForm">
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
            <li><a href="pinjaman.php" class="active" style="color: grey;">Pinjaman</a></li>
            <li><a href="koleksi.php">Koleksi</a></li>
            <li><a href="../../index.php">Logout</a></li>
        </ul>

        <i class="uil uil-search search-icon" id="searchIcon"></i>
        <div class="search-box">
            <i class="uil uil-search search-icon"></i>
            <form style="height:100%" method="get" action="home.php" name="search" onsubmit="return submitForm()">
                <input name="input_search" id="searchInput" type="text" placeholder="Judul/Penulis/kategori..." />
                <input type="hidden" name="_search" value="search">
            </form>
        </div>
    </nav>

    <div class="rekomendasi-container">
        <div class="rekomendasi-bottom-container">
            <?php
            foreach ($buku as $data) {
            ?>
                <div class="rekomendasi-card">
                    <div class="card-gambar" style="background-image: url('<?php echo "../../assets/gambar/" . $data['gambar']; ?>');">
                        <p class="judul"><?php echo $data['judul']; ?></p>
                    </div>
                    <div class="buku-text">
                        <p>Tanggal dipinjam: <?php echo $data['tanggal_peminjaman']; ?></p>
                        <p>Batas Waktu: <?php echo $data['tanggal_pengembalian']; ?></p>
                    </div>
                    <hr>
                    <div class="button-container">
                        <p><?php echo $data['status_peminjaman']; ?></p>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
</body>
<script>
    function submitForm() {
        document.forms["search"].submit();
        return false;
    }

    document.getElementById("searchInput").addEventListener("keypress", function(event) {
        if (event.keyCode === 13) {
            submitForm();
        }
    });

    function submitForm() {
        document.getElementById("kategoriForm").submit();
    }
</script>

</html>
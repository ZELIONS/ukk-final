<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/controller/Admin.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    header("Location:../../index.php");
    exit();
}

$admin = new Admin();
$tampil_buku = $admin->TampilBuku();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../ASSETS/css/admin/lihat-ulasan.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .active {
            background-color: red;
        }
    </style>
</head>

<body>
    <div class="sidebar close">
        <div class="logo-details">
            <i class='bx bx-book-open'></i>
            <span class="logo_name">Zeli-Book</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="home.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="home.php">Dashboard</a></li>
                </ul>
            </li>
            <li>
                <a href="pendataan-barang.php">
                    <i class='bx bx-data'></i>
                    <span class="link_name">pendataan</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="pendataan-barang.php">pendataan</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a>
                        <i class='bx bx-upload'></i>
                        <span class="link_name">Tambah</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name">Tambah</a></li>
                    <li><a href="tambah-buku.php">Buku</a></li>
                    <li><a href="tambah-kategori.php">Kategori</a></li>
                    <li><a href="daftarkan-petugas.php">Akun Petugas</a></li>
                </ul>
            </li>
            <li>
                <a href="daftar-pinjaman.php">
                    <i class='bx bx-book-reader'></i>
                    <span class="link_name">Pinjaman</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="daftar-pinjaman.php">Pinjaman</a></li>
                </ul>
            </li>
            <li>
                <a href="masukan-pengguna.php">
                    <i class='bx bx-envelope'></i>
                    <span class="link_name">Masukan</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="masukan-pengguna.php">Masukan</a></li>
                </ul>
            </li>
            <li>
                <a href="laporan.php">
                    <i class='bx bx-bar-chart'></i>
                    <span class="link_name">Laporan</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="laporan.php">Laporan</a></li>
                    <li><a class="link_name" href="export.php">Export Laporan</a></li>
                </ul>
            </li>

            <li>
                <a href="../../index.php">
                    <i class='bx bx-log-out'></i>
                    <span class="link_name">Logout</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="../../index.php">Logout</a></li>
                </ul>
            </li>

        </ul>
    </div>
   <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu' style="color: white;"></i>
            <p class="role">Admin</p>
        </div>
    </section>



    <div class="container">

        <?php foreach ($tampil_buku as $buku) : ?>

            <div class="tabel">
                <div class="gambar" style="background-image: url('../../ASSETS/GAMBAR/<?php echo $buku['gambar']; ?>');">
                </div>
                <div class="text-container">
                    <div class="judul">
                        <p><?php echo $buku['judul']; ?> </p>
                    </div>
                    <div class="link">
                        <a style="color: white;" href="ulasan.php?id=<?php echo $buku['id']; ?>">Lihat</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>


    </div>

    <script>
        let arrow = document.querySelectorAll(".arrow");
        for (var i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;
                arrowParent.classList.toggle("showMenu");
            });
        }
        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    </script>
</body>

</html>
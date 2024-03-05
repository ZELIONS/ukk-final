<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/controller/Admin.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'petugas') {
    header("Location:../../index.php");
    exit();
}

$admin = new Admin();
$buku_pinjaman = $admin->TampilPinjaman();
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {

    $pinjaman_id = $_GET['id'];
    $admin->UpdateStatusPinjaman($pinjaman_id);
    header("Location: " . $_SERVER['PHP_SELF']);
}


if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../ASSETS/css/admin/message.css">
    <link rel="stylesheet" href="../../ASSETS/css/admin/daftar-pinjaman.css">
    <!-- Boxiocns CDN Link -->
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
                    <li><a class="link_name" href="#">Tambah</a></li>
                    <li><a href="tambah-buku.php">Buku</a></li>
                    <li><a href="tambah-kategori.php">Kategori</a></li>
                </ul>
            </li>
            <li class="active">
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


    <?php
    if (!empty($message)) {
        if ($message == "Berhasil") {
            echo "<div class='message-container berhasil'>";
            echo "<p>" . $message . "</p>";
            echo "</div>";
        } else {
            echo "<div class='message-container gagal'>";
            echo "<p>" . $message . "</p>";
            echo "</div>";
        }
    }
    ?>


    <div class="container">

        <?php foreach ($buku_pinjaman as $buku): ?>

            <!--Card-->
            <div class="card-container">
                <div class="card-container-atas">
                    <div class="gambar"
                        style="background-image: url('../../assets/gambar/<?php echo $buku['gambar']; ?>');">
                    </div>
                </div>
                <div class="card-container-tengah">
                    <p style="font-size: 22px; font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif; margin-left: 50px;">
                        <?php echo $buku['judul']; ?>
                    </p>
                    <p>
                        <?php echo $buku['username_peminjam']; ?>
                    </p>
                    <p>Tanggal Pinjam:
                        <?php echo $buku['tanggal_peminjaman']; ?>
                    </p>
                    <p>Batas Waktu:
                        <?php echo $buku['tanggal_pengembalian']; ?>
                    </p>
                </div>

                <div class="card-container-bawah">
                    <button class="button"><a href="?id=<?php echo $buku['id']; ?>" style="text-decoration:none">Sudah
                            Dikembalikan</a></button>
                </div>
            </div>
        <?php endforeach; ?>



        <!--
        <div class="card-container">
            <div class="card-container-atas">
                <div class="gambar">
                </div>
            </div>
            <div class="card-container-tengah">
                <p>Kisah Cinta Josua</p>
                <p>Peminjam: Fauzan</p>
                <p>Tanggal Pinjam:17-10-2023</p>
                <p>Batas Waktu: 20-10-2023</p>
            </div>

            <div class="card-container-bawah">
                <button class="button">Sudah Dikembalikan</button>
            </div>
        </div>
        -->

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


        // Menggunakan JavaScript untuk menghilangkan pesan setelah 5 detik
        setTimeout(function () {
            var messageContainers = document.querySelectorAll('.message-container');
            messageContainers.forEach(function (container) {
                container.style.opacity = '0';
                container.style.transition = 'opacity 1s ease';
                setTimeout(function () {
                    container.style.display = 'none';
                }, 1000); // Menghilangkan elemen dari tampilan setelah transisi selesai
            });
        }, 5000); // 5000 milidetik = 5 detik
    </script>
</body>

</html>
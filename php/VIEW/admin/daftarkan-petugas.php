<?php

require_once 'C:/xampp/htdocs/ukk_zelion/php/controller/Daftar.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location:../../index.php");
    exit();
} elseif ($_SESSION['role'] !== 'admin') {
    header("Location:../../index.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_formName']) && $_POST['_formName'] == "daftar") {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $role = "petugas";
    $daftar = new Daftar();
    $daftar->Daftar($nama, $username, $email, $alamat, $password, $role);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../ASSETS/css/admin/daftarkan-petugas.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .active {
            background-color: red;
        }

        .message-container {
            /* Tambahkan gaya CSS untuk animasi */
            transition: opacity 0.5s ease-in-out;
        }

        .message-container.hidden {
            /* Atur opacity menjadi 0 saat pesan disembunyikan */
            opacity: 0;
        }

        .success {
            background-color: green;
            /* Warna latar belakang hijau untuk berhasil */
        }

        .error {
            background-color: red;
            /* Warna latar belakang merah untuk kesalahan */
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
            <li class="active">
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
                    <li class="active"><a href="daftarkan-petugas.php">Akun Petugas</a></li>
                </ul>
            </li>
            <li>
                <a href="daftar-pinjaman.php">
                    <i class='bx bx-book-reader'></i>
                    <span class="link_name">Pinjaman</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Pinjaman</a></li>
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


    <div
        class="message-container <?php echo isset($_SESSION['registration_done']) ? 'success' : (isset($_SESSION['message']) ? 'error' : ''); ?>">
        <p>
            <?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?>
        </p>
    </div>
    <?php
    // Setelah pesan ditampilkan, kosongkan $_SESSION['message']
    unset($_SESSION['message']);
    ?>




    <div class="container">


        <form class="form" method="POST" action="" name="daftar">
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Nama Lengkap" class="nama" required>
            <label>Username</label>
            <input type="text" name="username" placeholder="Username" class="username" required>
            <label>Email</label>
            <input type="email" name="email" placeholder="Email" class="email" required>
            <label>Alamat</label>
            <input type="text" name="alamat" placeholder="Alamat" class="alamat" required>
            <label>Kata Sandi</label>
            <input type="password" name="password" placeholder="Kata Sandi" class="password" required>
            <input type="hidden" name="_formName" value="daftar">
            <input type="submit" value="Daftarkan" class="submit">
        </form>


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


        // Atur timeout untuk menghilangkan pesan setelah 6 detik
        setTimeout(function () {
            var messageContainer = document.querySelector('.message-container');
            if (messageContainer) {
                // Tambahkan kelas "hidden" untuk memicu animasi
                messageContainer.classList.add('hidden');
                // Setelah animasi selesai, hapus pesan dari DOM
                messageContainer.addEventListener('transitionend', function () {
                    messageContainer.remove();
                });
            }
        }, 6000); // 6 detik
    </script>
</body>

</html>
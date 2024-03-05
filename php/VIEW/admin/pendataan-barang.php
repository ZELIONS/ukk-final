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
$tampil_kategori = $admin->TampilKategori();
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];

    unset($_SESSION['message']);
}
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {

    $buku_id = $_GET['id'];
    $admin->HapusBuku($buku_id);
    header("Location: " . $_SERVER['PHP_SELF']);
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../ASSETS/css/admin/pendataan.css">
    <!-- Boxiocns CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan</title>
    <style>
        .active {
            background-color: red;
        }

        .berhasil {
            background-color: green;
        }

        .gagal {
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
            <li class="active">
                <a href="#">
                    <i class='bx bx-data'></i>
                    <span class="link_name">pendataan</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">pendataan</a></li>
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
    <br>


    <?php
    if (!empty($message)) {
        if ($message == "Berhasil") {
            echo "<div style='background-color:#9cccff;;' class='message-container berhasil'> ";
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

    

        <table border="1" width="100%" style="border-radius:10px;text-align:center">
            <thead style="background-color:black;color:white">
                <tr>
                    <td>ID</td>
                    <td>NAMA</td>
                    <td>TOTAL BUKU</td>
                    <td>AKSI</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tampil_kategori as $data_kategori) : ?>
                    <tr>
                        <td><?php echo $data_kategori['id']; ?></td>
                        <td> <?php echo $data_kategori['nama_kategori']; ?>
                        </td>
                        <td> <?php echo $data_kategori['jumlah_buku']; ?>
                        </td>
                        <td> <button class="buku-edit"><a style="text-decoration: none; color: white;" href="edit-kategori.php?id=<?php echo $data_kategori['id']; ?>">Edit</a></button>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>


       



    <div class="rekomendasi-bottom-container">


        <?php
        foreach ($tampil_buku as $buku) {
        ?>
            <div class="rekomendasi-card">
                <div class="card-gambar" style="background-image: url('../../assets/gambar/<?php echo $buku['gambar']; ?>');">
                    <p class="rating">
                        <?php echo $buku['rating'] !== null ? $buku['rating'] . '/5' : 'Rating not available'; ?>
                    </p>
                </div>
                <div class="buku-text">
                    <p style="font-size: 22px; font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;">
                        <?php echo $buku['judul']; ?>
                    </p>
                    <p class="penulis">Penulis :
                        <?php echo $buku['penulis']; ?>
                    </p>
                    <p class="tahun">Tahun :
                        <?php echo $buku['tahun_terbit']; ?>
                    </p>
                    <p class="genre"> Genre :
                        <?php echo $buku['nama_kategori']; ?>
                    </p>
                    <p class="genre" style="color:red; font-weight:bold"> Stok :
                        <?php echo $buku['stok']; ?>
                    </p>
                </div>
                <div class="button-container">
                    <button class="hapus"><a href="?id=<?php echo $buku['id']; ?>" style="text-decoration: none; color:white;">Hapus</a></button>
                    <button class="lihat"><a href="edit-buku.php?id=<?php echo $buku['id']; ?>" style="text-decoration: none; color:white;">Edit</a></button>
                </div>
            </div>
        <?php
        }
        ?>
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
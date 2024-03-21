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
$data_kategori = $admin->TampilKategori();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_upload'])) {
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $sinopsis = $_POST['sinopsis'];
    $nama_kategori = $_POST['kategori'];
    $bahasa = $_POST['bahasa'];
    $jumlah_halaman = $_POST['halaman'];

    $stok=$_POST['stok'];

    $ext = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
    $gambar_tmp = $_FILES["gambar"]["tmp_name"];
    $admin->TambahBuku($nama_kategori, $gambar_tmp, $ext, $judul, $penulis, $penerbit, $tahun, $sinopsis, $bahasa, $jumlah_halaman,$stok);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../ASSETS/css/admin/tambah-buku.css">
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
                    <li class="active"><a href="tambah-buku.php">Buku</a></li>
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

    <div class="message-container" style="<?php echo isset($_SESSION['message']) && strpos($_SESSION['message'], 'gagal') !== false ? 'background-color: red;' : (isset($_SESSION['message']) && strpos($_SESSION['message'], 'berhasil') !== false ? 'background-color: green;' : ''); ?>">
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p>" . $_SESSION['message'] . "</p>";
            unset($_SESSION['message']);
        }
        ?>
    </div>



    <div class="container">


        <form class="form" method="POST" enctype="multipart/form-data" action="" name="upload">
            <label>Judul</label>
            <input maxlength="100" type="text" name="judul" placeholder="Judul" class="judul" required>
            <label>Tahun Terbit</label>
            <input min="1" max="2024" type="number" name="tahun" placeholder="Tahun Terbit" class="tahun" required>
            <label>Penulis</label>
            <input maxlength="100" type="text" name="penulis" placeholder="Penulis" class="penulis" required>
            <label>Penerbit</label>
            <input maxlength="100" type="text" name="penerbit" placeholder="Penerbit" class="penerbit" required>
            <label>Bahasa</label>
            <input maxlength="100" type="text" name="bahasa" placeholder="Bahasa" class="bahasa" required>
            <label>Jumlah Halaman</label>
            <input min="1" max="10000" type="number" name="halaman" placeholder="Jumlah Halaman" class="halaman" required>
            <label>Stok</label>
            <input min="1" max="10000" type="number" name="stok" placeholder="stok" class="halaman" required>
            <label>Sinopsis</label>
            <textarea placeholder="Masukkan Sinopsis" name="sinopsis" class="sinopsis" maxlength="1000"></textarea>
            <label>Kategori</label>
            <select name="kategori" required style=" border: 1px solid rgb(88, 51, 210);">
                <option selected disabled>Pilih Kategori</option>
                <?php
                foreach ($data_kategori as $kategori) {
                    echo "<option>" . $kategori['nama_kategori'] . "</option>";
                }
                ?>
            </select>

            <label>Gambar</label>
            <input type="file" required class="input-gambar" style="background-color:#fff" name="gambar">
            <input type="hidden" name="_upload" value="upload">
            <input type="submit" value="Submit" class="submit ">
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
    </script>
</body>

</html>
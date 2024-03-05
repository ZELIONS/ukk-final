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
$id_buku = $_GET['id'];
$admin = new Admin();
$data_kategori = $admin->TampilKategori();
$buku_edit = $admin->TampilBukuEdit($id_buku);
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];

    unset($_SESSION['message']);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_FILES['gambar-baru']) && $_FILES['gambar-baru']['error'] == 0) {
        // Jika gambar baru di-upload
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $penerbit = $_POST['penerbit'];
        $tahun = $_POST['tahun'];
        $sinopsis = $_POST['sinopsis'];
        $nama_kategori = $_POST['kategori'];
        $bahasa = $_POST['bahasa'];
        $jumlah_halaman = $_POST['halaman'];
        
        // Informasi tentang file yang di-upload
        $gambar_tmp = $_FILES["gambar-baru"]["tmp_name"];
        $ext = pathinfo($_FILES["gambar-baru"]["name"], PATHINFO_EXTENSION);

        // Lakukan pengeditan buku dengan gambar baru
        $admin->EditBuku($ext, $gambar_tmp, $id_buku, $judul, $penulis, $penerbit, $tahun, $sinopsis, $nama_kategori, $bahasa, $jumlah_halaman, null);
    } else {
        // Jika tidak ada gambar baru yang di-upload
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $penerbit = $_POST['penerbit'];
        $tahun = $_POST['tahun'];
        $sinopsis = $_POST['sinopsis'];
        $nama_kategori = $_POST['kategori'];
        $bahasa = $_POST['bahasa'];
        $jumlah_halaman = $_POST['halaman'];
        $gambar = $_POST['gambar'];

        // Lakukan pengeditan buku tanpa mengubah gambar
        $admin->EditBuku(null, null, $id_buku, $judul, $penulis, $penerbit, $tahun, $sinopsis, $nama_kategori, $bahasa, $jumlah_halaman, $gambar);
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id_buku);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../ASSETS/css/admin/tambah-buku.css">
    <link rel="stylesheet" href="../../ASSETS/css/admin/message.css">
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
            echo "<div style ='color:white;' class='message-container berhasil'>";
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


        <form class="form" method="POST" enctype="multipart/form-data" action="" name="upload">
            <label>Judul</label>
            <input value="<?php foreach ($buku_edit as $buku) {
                                echo $buku['judul'];
                            } ?>" maxlength="100" type="text" name="judul" placeholder="Judul" class="judul" required>
            <label>Tahun Terbit</label>
            <input value="<?php foreach ($buku_edit as $buku) {
                                echo $buku['tahun_terbit'];
                            } ?>" min="1" max="2024" type="number" name="tahun" placeholder="Tahun Terbit" class="tahun" required>
            <label>Penulis</label>
            <input value="<?php foreach ($buku_edit as $buku) {
                                echo $buku['penulis'];
                            } ?>" maxlength="100" type="text" name="penulis" placeholder="Penulis" class="penulis" required>
            <label>Penerbit</label>
            <input value="<?php foreach ($buku_edit as $buku) {
                                echo $buku['penerbit'];
                            } ?>" maxlength="100" type="text" name="penerbit" placeholder="Penerbit" class="penerbit" required>
            <label>Bahasa</label>
            <input value="<?php foreach ($buku_edit as $buku) {
                                echo $buku['bahasa'];
                            } ?>" maxlength="100" type="text" name="bahasa" placeholder="Bahasa" class="bahasa" required>
            <label>Jumlah Halaman</label>
            <input value="<?php foreach ($buku_edit as $buku) {
                                echo $buku['jumlah_halaman'];
                            } ?>" min="1" max="10000" type="number" name="halaman" placeholder="Jumlah Halaman" class="halaman" required>
            <label>Sinopsis</label>
            <textarea placeholder="Masukkan Sinopsis" name="sinopsis" class="sinopsis" maxlength="1000"><?php foreach ($buku_edit as $buku) {
                                                                                                            echo $buku['sinopsis'];
                                                                                                        } ?></textarea>
            <label>Kategori</label>
            <select name="kategori" required>
                <option selected disabled><?php foreach ($buku_edit as $buku) {
                                                echo $buku['nama_kategori'];
                                            } ?></option>
                <?php
                foreach ($data_kategori as $kategori) {
                    echo "<option>" . $kategori['nama_kategori'] . "</option>";
                }
                ?>
            </select>
            <input type="hidden" name="gambar" value="<?php foreach ($buku_edit as $buku) {
                                                            echo $buku['gambar'];
                                                        } ?>">
            <label>Gambar Saat Ini:</label><br>
            <img style="width:100px; height:130px" src="../../assets/GAMBAR/<?php foreach ($buku_edit as $buku) {
                                                                                echo $buku['gambar'];
                                                                            } ?>"><br>
            <label>Gambar Baru (Kosongkan Jika Tidak Ingin Diganti)</label><br>
            <input type="file" name="gambar-baru">

            <input type="submit" value="submit" class="submit">
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


        // Menggunakan JavaScript untuk menghilangkan pesan setelah 5 detik
        setTimeout(function() {
            var messageContainers = document.querySelectorAll('.message-container');
            messageContainers.forEach(function(container) {
                container.style.opacity = '0';
                container.style.transition = 'opacity 1s ease';
                setTimeout(function() {
                    container.style.display = 'none';
                }, 1000); // Menghilangkan elemen dari tampilan setelah transisi selesai
            });
        }, 5000); // 5000 milidetik = 5 detik
    </script>
</body>

</html>
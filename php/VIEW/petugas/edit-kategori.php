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
$kategori = $admin->TampilKategori();
$kategori_id = $_GET['id'];
$kategori_nama = $admin->TampilNamaKategoriWhereId($kategori_id);

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];

    unset($_SESSION['message']);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_upload'])) {
    $nama_kategori = $_POST['nama-kategori'];
    $admin->EditKategori($kategori_id, $nama_kategori);
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $kategori_id);
    exit();
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../ASSETS/css/admin/tambah-kategori.css">
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
                    <li><a href="tambah-buku.php">Buku</a></li>
                    <li><a href="tambah-kategori.php" class="active">Kategori</a></li>
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
            echo "<div style ='color:white;'class='message-container berhasil'>";
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


        <form class="form" method="POST" action="" name="upload">
            <label>Nama Kategori</label>
            <input type="text" name="nama-kategori" placeholder="Nama Kategori" class="nama" value="<?php foreach ($kategori_nama as $buku) {
                                                                                                        echo $buku['nama_kategori'];
                                                                                                    } ?>" required>
            <input type="submit" value="Perbarui" class="submit">
            <input type="hidden" name="_upload" value="upload">
        </form>


    </div>


    <div class="container">


        <div class="top-container">
            <div class="top-container-head">
                <div class="id">
                    <p>Id</p>
                </div>

                <div class="nama-buku">
                    <p>Nama Kategori</p>
                </div>

                <div class="total-buku">
                    <p>Total Buku</p>
                </div>

            </div>
            <hr>
            <?php foreach ($kategori as $data_kategori) : ?>
                <div class="top-container-body">
                    <div class="id">
                        <p><?php echo $data_kategori['id']; ?></p>
                    </div>
                    <div class="nama-buku">
                        <p><?php echo $data_kategori['nama_kategori']; ?></p>
                    </div>

                    <div class="total-buku">
                        <p><?php echo $data_kategori['jumlah_buku']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
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
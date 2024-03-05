<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/controller/Peminjam.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'peminjam') {
    header("Location:../../index.php");
    exit();
}


$buku_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$peminjam = new Peminjam();
$buku_info = $peminjam->TampilBuku($buku_id);
$data_kategori = $peminjam->TampilKategori();

$ulasan = $peminjam->TampilUlasan($user_id, $buku_id);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ulasan']) && isset($_POST['star'])) {
    $ulasan_text = $_POST['ulasan'];
    $star_rating = $_POST['star'];

    $peminjam->TambahUlasan($user_id, $buku_id, $ulasan_text, $star_rating);
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $buku_id);
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_pinjam'])) {
    $tanggal_pengembalian = $_POST['batas_waktu'];
    $tanggal_peminjaman = date("Y-m-d");
    $status = "belum dikembalikan";
    $peminjam->Pinjam($buku_id, $user_id, $tanggal_peminjaman, $tanggal_pengembalian, $status);
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $buku_id);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['buku_id'])) {
    $id_buku = $_GET['buku_id'];
    $peminjam->TambahKoleksi($user_id, $id_buku);

    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id_buku);
    exit();
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
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
    <link rel="stylesheet" href="../../ASSETS/css/admin/message.css">
    <link rel="stylesheet" href="../../ASSETS/CSS/peminjam/footer.css" />
    <link rel="stylesheet" href="../../ASSETS/CSS/peminjam/detail-buku.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
    <script src="../navbar.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
            <li><a href="home.php">Home</a></li>
            <li><a href="pinjaman.php">Pinjaman</a></li>
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

    <div class="detail-container">
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

        <div class="konfirmasi-container" id="myDiv">
            <div class="form-konfirmasi-container">
                <p class="konfirmasi-pinjaman">Konfirmasi Peminjaman</p>
                <?php foreach ($buku_info as $buku) : ?>
                    <p>Judul: <?php echo $buku['judul']; ?></p>
                    <p>Penulis: <?php echo $buku['penulis']; ?></p>
                    <p>Penerbit: <?php echo $buku['penerbit']; ?></p>
                    <p>Jumlah Halaman: <?php echo $buku['jumlah_halaman']; ?></p>
                    <p>Tahun Terbit: <?php echo $buku['tahun_terbit']; ?></p>
                    <p>Bahasa: <?php echo $buku['bahasa']; ?></p>
                <?php endforeach; ?>

                <p id="tanggalDipinjam">Tanggal Dipinjam: <?php echo date("Y-m-d"); ?></p>
                <p style="font-size: 20px;">Pinjam Sampai Tanggal:</p>

                <form class="form" action="" method="post" name="pinjam">
                    <input name="batas_waktu" type="date" class="date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" max="<?php echo date('Y-m-d', strtotime('+7 day')); ?>">
                    <input type="submit" value="Pinjam" class="pinjam">
                    <input type="hidden" name="_pinjam" value="pinjam">
                </form>

                <button class="pinjam" id="hideButton">Batal</button>
            </div>
        </div>
        <?php foreach ($buku_info as $buku) : ?>
            <div class="container-kiri">
                <div class="gambar-container">
                    <div class="gambar" style="background-image: url('../../assets/gambar/<?php echo $buku['gambar']; ?>');">
                    </div>
                    <button class="pinjam-button"><a>Pinjam</a></button>
                    <button class="koleksi-button"><a href="detail-buku.php?buku_id=<?php echo $buku_id; ?>">Tambah Koleksi</a></button>
                </div>

            </div>



            <div class="container-kanan">
                <div class="kanan-atas">
                    <p class="penulis"><?php echo $buku['penulis']; ?></p>
                    <p class="judul"><?php echo $buku['judul']; ?></p>
                </div>
                <div class="kanan-tengah">
                    <p class="title" style=" color:#00196b; font-size: 25px;">Deskripsi buku</p>
                    <p class="isi-deskripsi"><?php echo $buku['sinopsis']; ?></p>
                </div>
                <div class="kanan-bawah">
                    <div class="kanan-bawah-kiri">
                        <p class="detail">Detail Buku</p>
                        <p class="title">Jumlah Halaman</p>
                        <p class="Jumlah"><?php echo $buku['jumlah_halaman']; ?></p>
                        <p class="title">Tanggal-Terbit</p>
                        <p class="tanggal"><?php echo $buku['tahun_terbit']; ?></p>
                        <p class="title">rating</p>
                        <p class="Penerbit"><?php echo $buku['rating']; ?></p>
                    </div>
                    <div class="kanan-bawah-kanan">
                        <br><br>
                        <p class="title">Bahasa</p>
                        <p><?php echo $buku['bahasa']; ?></p>
                        <p class="title">Penerbit</p>
                        <p class="Penerbit"><?php echo $buku['penerbit']; ?></p>

                        <p class="title">Stok</p>
                        <p class="Penerbit"><?php echo $buku['stok']; ?></p>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>


        <div class="ulasan-container">
            <div class="ulasan-sub-container">
                <div class="ulasan">
                    <form action="" method="post" name="ulasan">
                        <div class="star-container">
                            <input class="star star-5" id="star-5-2" type="radio" name="star" value="5" />
                            <label class="star star-5" for="star-5-2"></label>
                            <input class="star star-4" id="star-4-2" type="radio" name="star" value="4" />
                            <label class="star star-4" for="star-4-2"></label>
                            <input class="star star-3" id="star-3-2" type="radio" name="star" value="3" />
                            <label class="star star-3" for="star-3-2"></label>
                            <input class="star star-2" id="star-2-2" type="radio" name="star" value="2" />
                            <label class="star star-2" for="star-2-2"></label>
                            <input class="star star-1" id="star-1-2" type="radio" name="star" value="1" required />
                            <label class="star star-1" for="star-1-2"></label>
                        </div>
                        <textarea class="ulasan-input" name="ulasan" placeholder="Berikan Ulasan Anda.." required></textarea>
                        <input type="hidden" name="_ulasan" value="upload">
                        <input type="submit" value="submit" class="ulasan-button">
                    </form>

                </div>
            </div>


            <div class="user-ulasan-container">
                <div class="user-ulasan">
                    <?php foreach ($ulasan as $data) : ?>
                        <div class="isi-ulasan-container">
                            <p class="username"><?php echo ucwords($data['username']); ?></p>
                            <p class="isi-ulasan"> <?php echo $data['ulasan']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Fungsi untuk menyembunyikan div saat tombol "Batal" diklik
        document.getElementById("hideButton").addEventListener("click", function() {
            document.getElementById("myDiv").style.display = "none";
        });
        document.querySelector(".pinjam-button").addEventListener("click", function() {
            document.getElementById("myDiv").style.display = "flex";
        });

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
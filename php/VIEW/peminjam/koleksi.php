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
$buku = $peminjam->TampilKoleksi($user_id);
$data_kategori = $peminjam->TampilKategori();
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['buku_id'])) {

  $buku_id = $_GET['buku_id'];
  $peminjam->HapusKoleksiUser($buku_id, $user_id);
  header("Location: " . $_SERVER['PHP_SELF']);
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
  <link rel="stylesheet" href="../../ASSETS/CSS/peminjam/koleksi.css" />
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
      <li><a href="pinjaman.php">Pinjaman</a></li>
      <li><a href="koleksi.php" class="active" style="color: grey;">Koleksi</a></li>
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

    <div class="rekomendasi-bottom-container">
      <?php
      foreach ($buku as $book) {
        ?>
        <div class="rekomendasi-card">
          <div class="card-gambar"
            style="background-image: url('<?php echo "../../assets/gambar/" . $book['gambar']; ?>');">
            <p class="rating">
              <?php echo $book['rata_rating']; ?>/5
            </p>
          </div>
          <div class="buku-text">
            <a class="penulis">
              <?php echo $book['penulis']; ?>
            </a>
            <p>
              <?php echo $book['judul']; ?>
            </p>
            <p class="tahun">
              <?php echo $book['tahun_terbit']; ?>
            </p>
            <p class="genre">
              <?php echo $book['nama_kategori']; ?>
            </p>
          </div>
          <div class="button-container">
            <button class="hapus"><a href="?buku_id=<?php echo $book['id']; ?>">Hapus</a></button>
            <button class="lihat"><a href="detail-buku.php?id=<?php echo $book['id']; ?>">Lihat</a></button>
          </div>
        </div>
        <?php
      }
      ?>



    </div>
  </div>
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
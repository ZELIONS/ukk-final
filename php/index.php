<?php
session_start();
require_once 'C:/xampp/htdocs/ukk_zelion/php/controller/Masuk.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/controller/Daftar.php';

// Hapus session jika ada
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']); // Menghapus variabel session 'user_id'
}
if (isset($_SESSION['registration_done'])) {
    unset($_SESSION['registration_done']); // Menghapus variabel session 'registration_done'
}

// Cek apakah form login sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_formName']) && $_POST['_formName'] == "masuk") {
    // Tangkap data dari form
    $username_email = $_POST['username_email'];
    $password = $_POST['password'];

    // Buat objek Masuk
    $masuk = new Masuk();

    // Panggil metode Masuk untuk proses login
    $masuk->Masuk($username_email, $password);
}

// Cek apakah form daftar sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['_formName']) && $_POST['_formName'] == "daftar") {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $role = "peminjam";

    // Buat objek Daftar
    $daftar = new Daftar();

    // Panggil metode Daftar untuk proses pendaftaran
    $daftar->Daftar($nama, $username, $email, $alamat, $password, $role);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <link rel="stylesheet" href="index.css">

</head>

<body>
    <div class="wrapper">
        <div class="title-text">
            <div class="title login">Selamat datang di ZELI-Book, Silahakan Login</div>
            <div class="title signup">Signup Form</div>
        </div>
        <div class="form-container">
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>
            <div class="form-inner">


                <form action="" class="login" method="post" name="masuk">
                    <div class="field">
                        <input type="text" placeholder="Email or Username" name="username_email" required>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Password" name="password" required>
                    </div>
                    <div style="text-align:center; padding-top:10px"><a style="text-decoration: none;" href="lupa_sandi.html">lupa password</a></div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="hidden" name="_formName" value="masuk"> <!-- Menambahkan input hidden _formName -->
                        <input type="submit" value="Login">
                    </div>
                    <div class="signup-link">Not a member? <a href="#">Signup now</a></div>
                </form>



                <form action="" method="post" class="signup" name="daftar">
                    <div class="field">
                        <input type="text" placeholder="Nama" name="nama" required>
                    </div>
                    <div class="field">
                        <input type="text" placeholder="Username" name="username" required>
                    </div>
                    <div class="field">
                        <input type="email" placeholder="Email" name="email" required>
                    </div>
                    <div class="field">
                        <input type="text" placeholder="Alamat" name="alamat" required>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Password" name="password" required>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="hidden" name="_formName" value="daftar"> <!-- Menambahkan input hidden _formName -->
                        <input type="submit" value="Signup">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>
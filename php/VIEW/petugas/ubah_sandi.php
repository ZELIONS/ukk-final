<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/controller/Daftar.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location:../../index.php");
  exit();
} elseif ($_SESSION['role'] !== 'petugas') {
  header("Location:../../index.php");
  exit();
}

$admin = new Daftar();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $password = $_POST['password'];
  $username_email = $_POST['username_email'];
  $email = $_POST['username_email'];
  $admin->UbahPassword($username_email, $email, $password);
}

$message = isset($_SESSION['message']) ? $_SESSION['message'] : ''; 
unset($_SESSION['message']); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #121212;
      /* Warna latar belakang dark mode */
      color: #ffffff;
      /* Warna teks putih */
    }

    .form-wrapper {
      background: #212121;
      /* Warna latar belakang form */
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    }

    .form-title {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-control {
      background-color: #333333;
      /* Warna latar belakang input */
      color: #ffffff;
      /* Warna teks input putih */
      border-color: #666666;
      /* Warna border input */
    }

    .form-control:focus {
      background-color: #555555;
      /* Warna latar belakang input saat fokus */
      border-color: #aaaaaa;
      /* Warna border input saat fokus */
      color: #ffffff;
      /* Warna teks input saat fokus */
    }

    .btn-primary {
      background-color: #007bff;
      /* Warna tombol submit */
      border-color: #007bff;
      /* Warna border tombol submit */
    }

    .btn-primary:hover {
      background-color: #0056b3;
      /* Warna tombol submit saat dihover */
      border-color: #0056b3;
      /* Warna border tombol submit saat dihover */
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
      color: #ffffff;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="form-wrapper">
          <h2 class="form-title">Ubah Kata Sandi</h2>
          <?php if (!empty($message)) : ?>
            <div class="alert <?php echo strpos($message, 'berhasil') !== false ? 'alert-success' : 'alert-danger'; ?>" role="alert">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>
          <form method="post" action="">
            <div class="form-group">
              <label for="username">Username/Email:</label>
              <input name="username_email" type="text" class="form-control" id="username" placeholder="Masukkan Username Atau Katasandi" required>
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input name="password" type="password" class="form-control" id="password" placeholder="Masukkan Katasandi Baru" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Perbarui</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (Optional) -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/user.php';
class Daftar
{
    public function __construct()
    {
    }
    //////////////done//////////////
    public function Daftar($nama, $username, $email, $alamat, $password, $role)
    {
        $user = new User(null, $username, $email, $nama, $alamat, $role, $password);
        $cek_email = $user->isEmailExists();
        $cek_username = $user->isUsernameExists();
        if ($cek_email === true or $cek_username === true) {
            $_SESSION['message'] = "Email/Username Sudah Terdaftar, Coba Yang Lain";
        } else {
            $daftarkan = $user->Daftar();
            if ($daftarkan === true) {
                $_SESSION['registration_done'] = true;
                $_SESSION['message'] = "Berhasil";
            } else {
                $_SESSION['message'] = "Terjadi Kesalahan";
            }
        }
    }

    public function UbahPassword($username, $email,  $password)
    {
        $user = new User(null, $username, $email, null, null, null, $password);
        $user->UbahPassword();
        if ($user == true) {
            $_SESSION['message'] = "berhasil";
        } else {
            $_SESSION['message'] = "gagal";
        }
    }
}

$daftar = new Daftar();

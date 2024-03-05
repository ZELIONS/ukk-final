<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/user.php';

class Masuk
{
    public function __construct()
    {
    }
    /////////////done/////////////
    public function Masuk($username_email, $password)
    {
        $user = new User(null, $username_email, $username_email, null, null, null, $password);
        $userID = $user->VerifikasiPassword();
        if ($userID !== false) {
            session_start();
            $_SESSION['user_id'] = $userID;
            $user_id = new User($userID, null, null, null, null, null, null);
            $username = $user_id->TampilUser();
            $_SESSION['username'] = $username;
            $role = $user->getRole();
            if ($role === 'admin') {
                $_SESSION['role'] = $role;
                header("Location: view/admin/home.php");
                exit();
            } elseif ($role === 'petugas') {
                $_SESSION['role'] = $role;
                header("Location: view/petugas/home.php");
                exit();
            } else {
                $_SESSION['role'] = $role;
                header("Location: view/peminjam/home.php");
                exit();
            }
        } else {
            echo "Login gagal. Silakan coba lagi.";
        }
    }
}

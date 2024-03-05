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
$buku = $admin->BukuPalingBanyakDipinjam();
$user = $admin->UserPalingBanyakMeminjam();
$kategori = $admin->KategoriPalingBanyakDipinjam();
$peminjaman = $admin->LaporanPeminjaman();
$daftar_buku = $admin->DaftarBuku();
$daftar_kategori = $admin->DaftarKategori();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../ASSETS/CSS/admin/laporan.css">
    <title>Laporan</title>
</head>

<body>
    <div class="container">

        <h1>Laporan E-Library Hub</h1>
        <div class="print-container">
            <button class="no-print" onclick="window.print()">Cetak Laporan</button>
        </div>
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Buku Paling Banyak Dipinjam</th>
                        <th>Pengguna Paling Banyak Meminjam</th>
                        <th>Kategori Paling Banyak Dipinjam</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        echo "<td>" . ucwords($buku['judul_buku']) . " ({$buku['total_peminjaman']} kali)</td>";
                        echo "<td>" . ucwords($user['username']) . " ({$user['total_peminjaman']} kali)</td>";
                        echo "<td>" . ucwords($kategori['nama_kategori']) . " ({$kategori['total_peminjaman']} kali)</td>";
                        ?>
                    </tr>
                </tbody>
            </table>




            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Dipinjam</th>
                        <th>Judul Buku</th>
                        <th>Peminjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php

                        $nomor = 1;

                        foreach ($peminjaman as $row) {
                            echo "<tr>";
                            echo "<td>{$nomor}</td>";
                            echo "<td>{$row['tanggal_peminjaman']}</td>";
                            echo "<td>{$row['judul_buku']}</td>";
                            echo "<td>{$row['username_peminjam']}</td>";
                            echo "<td>{$row['status_peminjaman']}</td>";
                            echo "</tr>";
                            $nomor++;
                        }
                        ?>

                    </tr>
                </tbody>
            </table>


            <h2>Daftar Buku</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID.</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Total Dipinjam</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        foreach ($daftar_buku as $buku) {
                            echo "<tr>";
                            echo "<td>{$buku['id_buku']}</td>";
                            echo "<td>{$buku['judul']}</td>";
                            echo "<td>{$buku['penulis']}</td>";
                            echo "<td>{$buku['kategori']}</td>";
                            echo "<td>{$buku['total_dipinjam']}</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>

            <h2>Daftar Kategori</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID.</th>
                        <th>Nama</th>
                        <th>Jumlah Buku</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        foreach ($daftar_kategori as $kategori) {
                            echo "<tr>";
                            echo "<td>{$kategori['id_kategori']}</td>";
                            echo "<td>{$kategori['nama_kategori']}</td>";
                            echo "<td>{$kategori['jumlah_buku']}</td>";
                            echo "</tr>";
                        }
                        ?>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
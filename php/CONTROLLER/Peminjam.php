<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/user.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/buku.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/kategori_buku.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/kategori_buku_relasi.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/ulasan_buku.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/koleksi.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/peminjaman.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/masukan.php';
class Peminjam
{
    public function __construct()
    {
    }
    public function Pinjam($buku_id, $user_id, $tanggal_peminjaman, $tanggal_pengembalian, $status)
    {

        $tanggal_peminjaman_obj = new DateTime($tanggal_peminjaman);
        $tanggal_pengembalian_obj = new DateTime($tanggal_pengembalian);
        if ($tanggal_pengembalian_obj <= $tanggal_peminjaman_obj) {
            $_SESSION['message'] = "Gagal";
            return;
        }
        $stok = new Buku($buku_id, null, null, null, null, null, null, null, null, null);
        $stok_buku = $stok->HitungStok();
        if ($stok_buku <= 1) {
            $_SESSION['message'] = "Gagal";
        } else {
            $pinjam = new Peminjaman(null, $user_id, $buku_id, $tanggal_peminjaman, $tanggal_pengembalian, $status);
            $pinjam_buku = $pinjam->TambahPeminjaman();
            if ($pinjam_buku == true) {
                // Buat objek Buku dengan ID buku yang diberikan
                $stok = new Buku($buku_id, null, null, null, null, null, null, null, null, null);
                $buku_pinjam = 1;
                $stok_buku = $stok->HitungStok();
                $stok_sisa = $stok_buku - $buku_pinjam;
                if ($stok_sisa) {
                    $update_stok = new Buku($buku_id, null, null, null, null, null, null, null, null, $stok_sisa);
                    $update_stok->UpdateStok();
                    $_SESSION['message'] = "Berhasil";
                } else {
                    $_SESSION['message'] = "Gagal";
                }
            } else {
                $_SESSION['message'] = "Gagal";
            }
        }
    }
    public function TambahKoleksi($user_id, $buku_id)
    {
        $koleksi = new Koleksi(null, $user_id, $buku_id);
        $tambah_koleksi = $koleksi->TambahKoleksi();
        if ($tambah_koleksi == true) {
            $_SESSION['message'] = "Berhasil";
        } else {
            $_SESSION['message'] = "Gagal";
        }
    }

    public function HapusKoleksiUser($buku_id, $user_id)
    {
        $koleksi = new Koleksi(null, $user_id, $buku_id);
        $result = $koleksi->HapusKoleksi();
        if ($result == true) {
            $_SESSION['message'] = "Berhasil";
        } else {
            $_SESSION['message'] = "Gagal";
        }
        return $result;
    }


    public function TampilKoleksi($user_id)
    {
        $koleksi = new Buku(null, null, null, null, null, null, null, null, null, null);
        return  $koleksi->getBookInKoleksi($user_id);
    }
    public function TampilBukuRekomendasi($limit)
    {
        $buku = new Buku(null, null, null, null, null, null, null, null, null, null);
        return $buku->BukuRekomendasi($limit);
    }
    public function TampilBukuPopuler($limit)
    {
        $buku = new Buku(null, null, null, null, null, null, null, null, null, null);
        return $buku->BukuPopuler($limit);
    }

    public function GroupBookByKategori()
    {
        $buku = new Buku(null, null, null, null, null, null, null, null, null, null);
        return $buku->BukuGroupByKategori();
    }
    public function TampilPinjaman($user_id)
    {
        $peminjaman = new Buku(null, null, null, null, null, null, null, null, null, null);
        return $peminjaman->getBookInPeminjaman($user_id);
    }

    public function TampilKategori()
    {
        $kategori = new KategoriBuku(null, null);
        return $kategori->TampilkanKategori();
    }

    public function TampilBuku($id)
    {
        $buku = new Buku($id, null, null, null, null, null, null, null, null, null);
        return $buku->getAllBookWhereId();
    }

    public function GetAllBukuByKategori($nama_kategori)
    {
        $kategori = new KategoriBuku(null, $nama_kategori);
        $kategori_id = $kategori->TampilIdKategori();

        if ($kategori_id !== null) {
            $buku = new Buku(null, null, null, null, null, null, null, null, null, null);
            return $buku->getAllBukuByKategori($kategori_id);
        } else {
            return null;
        }
    }


    public function SearchBook($SearchQuery)
    {
        $buku = new Buku(null, null, null, null, null, null, null, null, null, null);
        return $buku->searchBooks($SearchQuery);
    }


    public function Masukan($user_id, $masukan, $tanggal)
    {
        $masukan = new Masukan(null, $user_id, $masukan, $tanggal);
        $tambah_masukan = $masukan->BeriMasukan();
        if ($tambah_masukan == true) {
        }
    }
    
    public function TambahUlasan($user_id, $buku_id, $ulasan_text, $rating)
    {
        $cek_pinjam = new Peminjaman(null, $user_id, $buku_id, null, null, null);
        $jumlah = $cek_pinjam->CekUserPinjam();
        if ($jumlah < 1) {
            $_SESSION['message'] = "Gagal";
        } else {
            $ulasan = new UlasanBuku(null, $user_id, $buku_id, $ulasan_text, $rating);
            $tambah_ulasan = $ulasan->TambahUlasan();
            if ($tambah_ulasan == true) {
                $_SESSION['message'] = "Berhasil";
            } else {
                $_SESSION['message'] = "Gagal";
            }
        }
    }


    public function TampilUlasan($user_id, $buku_id)
    {
        $ulasan = new UlasanBuku(null, $user_id, $buku_id, null, null);
        return $ulasan->TampilUlasan();
    }
}

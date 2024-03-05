<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/user.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/buku.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/kategori_buku.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/kategori_buku_relasi.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/ulasan_buku.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/koleksi.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/peminjaman.php';
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/masukan.php';


class Admin
{
    public function __construct()
    {
    }
    /////////////done///////////////////
    public function TambahBuku($nama_kategori, $gambar_tmp, $ext, $judul, $penulis, $penerbit, $tahun, $sinopsis, $bahasa, $jumlah_halaman, $stok)
    {
        $nama_gambar = strtolower(str_replace(' ', '_', $judul));
        $kode_unik = uniqid();
        $gambar_nama = $nama_gambar . '_' . $kode_unik . '.' . $ext;
        $gambar_destinasi = "C:/xampp/htdocs/ukk_zelion/assets/gambar/" . $gambar_nama;

        $buku = new Buku(null, $judul, $penulis, $penerbit, $sinopsis, $tahun, $gambar_nama, $bahasa, $jumlah_halaman, $stok);

        try {
            // Eksekusi query untuk menambahkan buku
            $upload = $buku->TambahBuku();
            if ($upload == true) {
                move_uploaded_file($gambar_tmp, $gambar_destinasi);

                $kategori_id = new KategoriBuku(null, $nama_kategori);
                $idkategori = $kategori_id->TampilIdKategori();
                $idbuku = $buku->TampilId();

                if ($idbuku == true) {
                    $kategori_relasi = new KategoriBukuRelasi(null, $idbuku, $idkategori);
                    $kategori_relasi->simpanRelasi();
                    if ($kategori_relasi == true) {
                        $_SESSION['message'] = "Berhasil";
                    } else {
                        $_SESSION['message'] = "Gagal";
                    }
                } else {
                    $_SESSION['message'] = "Gagal";
                }
            } else {
                $_SESSION['message'] = "Gagal";
            }
        } catch (mysqli_sql_exception $e) {
            // Tangkap pesan error dan simpan ke dalam session message
            $_SESSION['message'] = "Gagal menambahkan buku: " . $e->getMessage();
        }
    }

    public function TampilBuku()
    {
        $buku = new Buku(null, null, null, null, null, null, null, null, null, null);
        return $buku->TampilBuku();
    }
    public function TampilBukuWhereId($buku_id)
    {
        $buku = new Buku($buku_id, null, null, null, null, null, null, null, null, null);
        return $buku->getAllBookWhereId();
    }

    public function TampilUlasan($buku_id)
    {
        $ulasan = new UlasanBuku(null, null, $buku_id, null, null);
        return $ulasan->TampilUlasan();
    }

    public function TampilKategori()
    {
        $kategori = new KategoriBuku(null, null);
        return  $kategori->TampilkanKategori();
    }

    public function HapusBuku($buku_id)
    {
        $pinjaman = new Peminjaman(null, null, $buku_id, null, null, null);
        $hapus_pinjaman = $pinjaman->AdminHapusPinjaman();


        if ($hapus_pinjaman == true) {
            $koleksi = new Koleksi(null, null, $buku_id);
            $hapus_koleksi = $koleksi->AdminHapusKoleksi();

            if ($hapus_koleksi == true) {
                $ulasan = new UlasanBuku(null, null, $buku_id, null, null);
                $hapus_ulasan = $ulasan->AdminHapusUlasan();
                if ($hapus_ulasan == true) {
                    $relasi = new KategoriBukuRelasi(null, $buku_id, null);
                    $hapus_relasi = $relasi->HapusRelasi();
                    if ($hapus_relasi == true) {
                        $buku = new Buku($buku_id, null, null, null, null, null, null, null, null, null);
                        $hapus_buku = $buku->HapusBuku();
                        if ($hapus_buku == true) {
                            $_SESSION['message'] = "Berhasil";
                        } else {
                            $_SESSION['message'] = "Gagal";
                        }
                    } else {
                        $_SESSION['message'] = "Gagal";
                    }
                } else {
                    $_SESSION['message'] = "Gagal";
                }
            } else {
                $_SESSION['message'] = "Gagal";
            }
        } else {
            $_SESSION['message'] = "Gagal";
        }
    }

    public function EditBuku($ext, $gambar_tmp, $buku_id, $judul, $penulis, $penerbit, $tahun, $sinopsis, $nama_kategori, $bahasa, $jumlah_halaman, $gambar, $stok)
    {
        $nama_gambar = strtolower(str_replace(' ', '_', $judul));
        $kode_unik = uniqid();
        $nama_unik = $nama_gambar . '_' . $kode_unik . '.' . $ext;
        $gambar_destinasi = "C:/xampp/htdocs/ukk_zelion/assets/gambar/" . $nama_unik;
        if ($ext !== null) {
            $buku = new Buku($buku_id, $judul, $penulis, $penerbit, $sinopsis, $tahun, $nama_unik, $bahasa, $jumlah_halaman, $stok);
            $edit_buku = $buku->EditBuku();
            if ($edit_buku) {
                move_uploaded_file($gambar_tmp, $gambar_destinasi);
                $kategori = new KategoriBuku(null, $nama_kategori);
                $kategori_id = $kategori->TampilIdKategori();
                if ($kategori_id !== null) {
                    $edit_relasi = new KategoriBukuRelasi(null, $buku_id, $kategori_id);
                    $relasi_baru = $edit_relasi->EditRelasi();
                    if ($relasi_baru) {
                    } else {
                    }
                } else {
                    $_SESSION['message'] = 'Berhasil';
                }
            } else {
                $_SESSION['message'] = 'Gagal';
            }
        } else {
            $buku = new Buku($buku_id, $judul, $penulis, $penerbit, $sinopsis, $tahun, $gambar, $bahasa, $jumlah_halaman, $stok);
            $edit_buku = $buku->EditBuku();
            if ($edit_buku) {
                $kategori = new KategoriBuku(null, $nama_kategori);
                $kategori_id = $kategori->TampilIdKategori();
                if ($kategori_id !== null) {
                    $edit_relasi = new KategoriBukuRelasi(null, $buku_id, $kategori_id);
                    $relasi_baru = $edit_relasi->EditRelasi();
                    if ($relasi_baru) {
                    } else {
                    }
                } else {
                    $_SESSION['message'] = 'Berhasil';
                }
            } else {
                $_SESSION['message'] = 'Gagal';
            }
        }
    }



    public function TambahKategori($nama_kategori)
    {
        $kategori = new KategoriBuku(null, $nama_kategori);
        $tambah_ketegori = $kategori->TambahKategori();

        if ($tambah_ketegori == true) {
            $_SESSION['message'] = "Berhasil";
        } else {
            $_SESSION['message'] = 'Gagal';
        }
    }


    public function JumlahPengguna()
    {
        $pengguna = new User(null, null, null, null, null, null, null);
        return $pengguna->HitungJumlahPengguna();
    }
    public function JumlahBuku()
    {
        $buku = new Buku(null, null, null, null, null, null, null, null, null, null);
        return $buku->HitungJumlahBuku();
    }
    public function JumlahKategori()
    {
        $kategori = new KategoriBuku(null, null);
        return $kategori->HitungJumlahKategori();
    }
    public function JumlahPeminjaman()
    {
        $peminjaman = new Peminjaman(null, null, null, null, null, null);
        return $peminjaman->HitungJumlahPeminjaman();
    }
    public function JumlahUlasan()
    {
        $ulasan = new UlasanBuku(null, null, null, null, null);
        return $ulasan->HitungJumlahUlasan();
    }

    public function TampilPengguna()
    {
        $pengguna = new User(null, null, null, null, null, null, null);
        return $pengguna->TampilSemuaDataUser();
    }
    public function TampilMasukan()
    {
        $masukan = new Masukan(null, null, null, null);
        return $masukan->TampilMasukan();
    }
    public function TampilPinjaman()
    {
        $pinjaman = new buku(null, null, null, null, null, null, null, null, null, null);
        return $pinjaman->AdminTampilPinjaman();
    }

    public function UpdateStatusPinjaman($id_pinjaman)
    {
        $pinjaman = new Peminjaman($id_pinjaman, null, null, null, null, null);
        $updateStatus = $pinjaman->AdminUpdateStatus();

        if ($updateStatus == true) {
            $peminjaman = new Peminjaman($id_pinjaman, null, null, null, null, null);
            //id buku
            $buku_id = $peminjaman->GetIdBuku();

            //perbarui stok
                $stok = new Buku($buku_id, null, null, null, null, null, null, null, null, null);
                $buku_pinjam = 1;
                $stok_buku = $stok->HitungStok();
            if ($stok_buku == true) { // perubahan 1: periksa apakah stok berhasil dihitung
                $stok_sisa = $stok_buku + $buku_pinjam;
                $update_stok = new Buku($buku_id, null, null, null, null, null, null, null, null, $stok_sisa);
                $updateResult = $update_stok->UpdateStok(); // perubahan 2: simpan hasil pembaruan stok

                if ($updateResult) { // perubahan 3: periksa apakah stok berhasil diperbarui
                    $_SESSION['message'] = "Berhasil memperbarui stok.";
                } else {
                    $_SESSION['message'] = "Gagal memperbarui stok.";
                }
            } else {
                $_SESSION['message'] = "Gagal menghitung stok."; // perubahan 4: sesuaikan pesan jika menghitung stok gagal
            }
        } else {
            $_SESSION['message'] = "Gagal memperbarui status pinjaman.";
        }

        return $updateStatus;
    }

    public function TampilNamaKategoriWhereId($id_kategori)
    {
        $kategori = new KategoriBuku($id_kategori, null);
        return $kategori->TampilNamaKategoriWhereId();
    }
    public function EditKategori($id_kategori, $nama_baru)
    {
        $kategori = new KategoriBuku($id_kategori, $nama_baru);
        $kategori->EditKategori();
        if ($kategori == true) {
            $_SESSION['message'] = "Berhasil";
        } else {
            $_SESSION['message'] = "Gagal";
        }
    }

    public function TampilBukuEdit($buku_id)
    {
        $buku = new buku($buku_id, null, null, null, null, null, null, null, null, null);
        return $buku->AdminTampilBuku();
    }

    public function BukuPalingBanyakDipinjam()
    {
        $buku = new buku(null, null, null, null, null, null, null, null, null, null);
        return $buku->BukuPalingBanyakDipinjam();
    }
    public function DaftarBuku()
    {
        $buku = new buku(null, null, null, null, null, null, null, null, null, null);
        return $buku->DaftarBukuLaporan();
    }
    public function DaftarKategori()
    {
        $kategori = new KategoriBuku(null, null);
        return $kategori->DaftarKategoriLaporan();
    }
    public function UserPalingBanyakMeminjam()
    {
        $user = new User(null, null, null, null, null, null, null);
        return $user->UserPalingBanyakMeminjam();
    }
    public function KategoriPalingBanyakDipinjam()
    {
        $kategori = new KategoriBuku(null, null);
        return $kategori->KategoriPalingBanyakDipinjam();
    }
    public function LaporanPeminjaman()
    {
        $peminjaman = new peminjaman(null, null, null, null, null, null);
        return $peminjaman->LaporanPeminjaman();
    }
}

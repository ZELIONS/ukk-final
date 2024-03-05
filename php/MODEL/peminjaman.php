<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/config.php';

class Peminjaman
{
    private $id;
    private $user_id;
    private $buku_id;
    private $tanggal_peminjaman;
    private $tanggal_pengembalian;
    private $status_peminjaman;
    private $conn;

    // Constructor
    public function __construct($id, $user_id, $buku_id, $tanggal_peminjaman, $tanggal_pengembalian, $status_peminjaman)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->buku_id = $buku_id;
        $this->tanggal_peminjaman = $tanggal_peminjaman;
        $this->tanggal_pengembalian = $tanggal_pengembalian;
        $this->status_peminjaman = $status_peminjaman;
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    function CekUserPinjam()
    {
        $jumlah_ulasan = null;
        $sql = "SELECT COUNT(*) FROM peminjaman WHERE user_id=? AND buku_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $this->user_id, $this->buku_id);
        $stmt->execute();
        $stmt->bind_result($jumlah_ulasan);
        $stmt->fetch();
        $stmt->close();
        return $jumlah_ulasan;
    }
    function GetIdBuku()
    {
        $sql = "SELECT buku_id FROM peminjaman WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result['buku_id'];
    }
    public function HitungJumlahPeminjaman()
    {
        $jumlah_peminjaman = null;
        $sql = "SELECT COUNT(*) FROM peminjaman";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($jumlah_peminjaman);
        $stmt->fetch();
        $stmt->close();
        return $jumlah_peminjaman;
    }
    public function TambahPeminjaman()
    {
        $sql_check = "SELECT * FROM peminjaman WHERE user_id=? AND buku_id=? AND status_peminjaman='belum dikembalikan'";
        $stmt_check = $this->conn->prepare($sql_check);
        $stmt_check->bind_param("ii", $this->user_id, $this->buku_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $stmt_check->close();

        if ($result_check->num_rows > 0) {
            return false;
        } else {
            $sql_insert = "INSERT INTO peminjaman (user_id, buku_id, tanggal_peminjaman, tanggal_pengembalian, status_peminjaman) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert = $this->conn->prepare($sql_insert);
            $stmt_insert->bind_param("iisss", $this->user_id, $this->buku_id, $this->tanggal_peminjaman, $this->tanggal_pengembalian, $this->status_peminjaman);
            $result_insert = $stmt_insert->execute();
            $stmt_insert->close();

            return $result_insert;
        }
    }
    public function updateStatusPeminjaman()
    {
        $sql = "UPDATE peminjaman SET status_peminjaman = ? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $this->status_peminjaman, $this->id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }



    public function GetPeminjamanByUserId()
    {
        $sql = "SELECT * FROM peminjaman WHERE user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function AdminHapusPinjaman()
    {
        $sql = "DELETE FROM peminjaman WHERE buku_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->buku_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    function AdminUpdateStatus()
    {
        $sql = "UPDATE peminjaman
        SET status_peminjaman = 'sudah dikembalikan'
        WHERE id =?;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    function LaporanPeminjaman()
    {
        $sql = "SELECT p.tanggal_peminjaman, b.judul AS judul_buku, u.username AS username_peminjam, p.status_peminjaman
        FROM peminjaman p
        JOIN buku b ON p.buku_id = b.id
        JOIN user u ON p.user_id = u.id;";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
}

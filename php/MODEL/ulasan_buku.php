<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/config.php';

class UlasanBuku
{
    private $id;
    private $user_id;
    private $buku_id;
    private $ulasan;
    private $rating;
    private $conn;

    // Constructor
    public function __construct($id, $user_id, $buku_id, $ulasan, $rating)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->buku_id = $buku_id;
        $this->ulasan = $ulasan;
        $this->rating = $rating;

        // Mendapatkan koneksi
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function HitungJumlahUlasan()
    {
        $jumlah_ulasan = null;
        $sql = "SELECT COUNT(*) FROM ulasan_buku";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($jumlah_ulasan);
        $stmt->fetch();
        $stmt->close();
        return $jumlah_ulasan;
    }

    public function TambahUlasan()
    {
        $sql = "INSERT INTO ulasan_buku (user_id, buku_id, ulasan, rating) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisi", $this->user_id, $this->buku_id, $this->ulasan, $this->rating);
        $result = $stmt->execute();

        return $result;
    }
    public function TampilUlasan()
    {
        $sql = "SELECT ulasan_buku.ulasan, ulasan_buku.rating, user.username
        FROM ulasan_buku
        JOIN user ON ulasan_buku.user_id = user.id
        WHERE ulasan_buku.buku_id = ?; ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->buku_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }


    public function AdminHapusUlasan()
    {
        $sql = "DELETE FROM ulasan_buku WHERE buku_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->buku_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}

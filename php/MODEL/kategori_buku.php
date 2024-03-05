<?php

require_once 'C:/xampp/htdocs/ukk_zelion/php/model/config.php';

class KategoriBuku
{
    private $id;
    private $nama_kategori;
    private $conn;

    public function __construct($id, $nama_kategori)
    {
        $this->id = $id;
        $this->nama_kategori = $nama_kategori;
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function HitungJumlahKategori()
    {
        $jumlah_kategori = null;
        $sql = "SELECT COUNT(*) FROM kategori";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($jumlah_kategori);
        $stmt->fetch();
        $stmt->close();
        return $jumlah_kategori;
    }
    public function TambahKategori()
    {
        $sql = "SELECT * FROM kategori WHERE nama_kategori=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->nama_kategori);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows == 0) {
            $sql = "INSERT INTO kategori (nama_kategori) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $this->nama_kategori);
            $result = $stmt->execute();
            $stmt->close();
            return $result;
        } else {
            return false;
        }
    }

    public function TampilkanKategori()
    {
        $sql = "SELECT kategori.id, kategori.nama_kategori, COUNT(kategori_buku_relasi.buku_id) AS jumlah_buku
        FROM kategori
        LEFT JOIN kategori_buku_relasi ON kategori.id = kategori_buku_relasi.kategori_id
        GROUP BY kategori.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function TampilIdKategori()
    {
        $sql = "SELECT id FROM kategori WHERE nama_kategori=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->nama_kategori);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result !== null) {
            return $result['id'];
        } else {
            return null;
        }
    }

    function TampilNamaKategoriWhereId()
    {
        $sql = "SELECT kategori.nama_kategori FROM kategori WHERE id=?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
    function EditKategori()
    {
        $sql = "UPDATE kategori
        SET nama_kategori=?
        WHERE id =?;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $this->nama_kategori, $this->id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    function KategoriPalingBanyakDipinjam()
    {
        $sql = "SELECT k.nama_kategori AS nama_kategori, COUNT(p.id) AS total_peminjaman
                FROM kategori k
                JOIN kategori_buku_relasi kb ON k.id = kb.kategori_id
                JOIN buku b ON kb.buku_id = b.id
                JOIN peminjaman p ON b.id = p.buku_id
                GROUP BY k.id
                ORDER BY total_peminjaman DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }
    function DaftarKategoriLaporan()
    {
        $sql = "SELECT 
        k.id AS id_kategori,
        k.nama_kategori,
        COUNT(kb.buku_id) AS jumlah_buku
    FROM 
        kategori k
    LEFT JOIN 
        kategori_buku_relasi kb ON k.id = kb.kategori_id
    GROUP BY 
        k.id
    ORDER BY 
        k.id ASC;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

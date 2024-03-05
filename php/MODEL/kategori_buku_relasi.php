<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/config.php';
class KategoriBukuRelasi
{
    private $id;
    private $buku_id;
    private $kategori_id;
    private $conn;
    public function __construct($id, $buku_id, $kategori_id)
    {
        $this->id = $id;
        $this->buku_id = $buku_id;
        $this->kategori_id = $kategori_id;
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function simpanRelasi()
    {

        $sql = "INSERT INTO kategori_buku_relasi (buku_id, kategori_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $this->buku_id, $this->kategori_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function EditRelasi()
    {
        $sql = "UPDATE kategori_buku_relasi SET kategori_id=? WHERE buku_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $this->kategori_id, $this->buku_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function HapusRelasi()
    {
        $sql = "DELETE FROM kategori_buku_relasi WHERE buku_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->buku_id);
        $result = $stmt->execute();
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
?>
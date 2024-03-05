<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/config.php';
class Koleksi
{
    private $id;
    private $user_id;
    private $buku_id;

    private $conn;

    // Constructor
    public function __construct($id, $user_id, $buku_id)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->buku_id = $buku_id;
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    public function TambahKoleksi()
    {
        $sql_check = "SELECT * FROM koleksi WHERE user_id=? AND buku_id=?";
        $stmt_check = $this->conn->prepare($sql_check);
        $stmt_check->bind_param("ii", $this->user_id, $this->buku_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $stmt_check->close();

        if ($result_check->num_rows > 0) {
            return false;
        } else {
            $sql_insert = "INSERT INTO koleksi (user_id, buku_id) VALUES (?, ?)";
            $stmt_insert = $this->conn->prepare($sql_insert);
            $stmt_insert->bind_param("ii", $this->user_id, $this->buku_id);
            $result_insert = $stmt_insert->execute();
            $stmt_insert->close();
            return $result_insert;
        }
    }

    public function HapusKoleksi()
    {
        $sql = "DELETE FROM koleksi WHERE buku_id=? AND user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $this->buku_id, $this->user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function TampilKoleksi()
    {
        $sql = "SELECT * FROM koleksi WHERE user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public function TampilIdKoleksi()
    {
        $sql = "SELECT id FROM koleksi WHERE user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }
    public function TampilkanKoleksiBuku()
    {
        $sql = "SELECT buku.* 
                FROM buku
                INNER JOIN koleksi ON buku.id = koleksi.buku_id
                WHERE koleksi.user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC);
    }



    function AdminHapusKoleksi()
    {
        $sql = "DELETE FROM koleksi WHERE buku_id=?";
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

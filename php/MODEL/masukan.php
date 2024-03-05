<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/config.php';
class Masukan
{
    private $id;
    private $user_id;
    private $masukan;
    private $tanggal;
    private $conn;

    // Constructor
    public function __construct($id, $user_id, $masukan, $tanggal)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->masukan = $masukan;
        $this->tanggal = $tanggal;
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function BeriMasukan()
    {
        $sql = "INSERT INTO masukan (user_id, tanggal, masukan) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $this->user_id, $this->tanggal, $this->masukan,);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function TampilMasukan()
    {
        $sql = "SELECT masukan.*, user.username
                FROM masukan
                JOIN user ON masukan.user_id = user.id
                ORDER BY masukan.tanggal DESC"; 
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
}

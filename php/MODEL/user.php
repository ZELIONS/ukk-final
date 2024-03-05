<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/config.php';
class User
{
    private $id;
    private $username;
    private $email;
    private $nama_lengkap;
    private $alamat;
    private $conn;
    private $role;
    private $password;

    // Constructor
    public function __construct($id, $username, $email, $nama_lengkap, $alamat, $role, $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->nama_lengkap = $nama_lengkap;
        $this->alamat = $alamat;
        $this->password = $password;
        $this->role = $role;
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function UbahPassword()
    {
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET password =? WHERE username =? OR email =?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $hashed_password,  $this->username, $this->email);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function HitungJumlahPengguna()
    {
        $sql = "SELECT COUNT(*) FROM user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($jumlah_pengguna);
        $stmt->fetch();
        $stmt->close();
        return $jumlah_pengguna;
    }

    public function TampilUser()
    {
        $sql = "SELECT username FROM user WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();
        return $username;
    }

    public function TampilSemuaDataUser()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
    public function Daftar()
    {
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (nama_lengkap, username, email, alamat, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", $this->nama_lengkap, $this->username, $this->email, $this->alamat, $hashed_password, $this->role);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }


    public function isEmailExists()
    {
        $sql = "SELECT COUNT(*) FROM user WHERE email=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }

    public function isUsernameExists()
    {
        $sql = "SELECT COUNT(*) FROM user WHERE username=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        return $count > 0;
    }


    public function VerifikasiPassword()
    {
        $sql = "SELECT id, password FROM user WHERE email=? OR username=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $this->email, $this->username);
        $stmt->execute();
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        $stmt->close();
        if ($id !== null && password_verify($this->password, $hashed_password)) {
            return $id;
        }
        return false;
    }

    public function getRole()
    {
        $sql = "SELECT role FROM user WHERE email=? OR username=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $this->email, $this->username);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();
        return $role;
    }

    function UserPalingBanyakMeminjam()
    {
        $sql = "SELECT u.username AS username, COUNT(p.id) AS total_peminjaman
        FROM user u
        JOIN peminjaman p ON u.id = p.user_id
        GROUP BY u.id
        ORDER BY total_peminjaman DESC
        LIMIT 1;";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }
}

<?php
require_once 'C:/xampp/htdocs/ukk_zelion/php/model/config.php';
class Buku
{
    private $id;
    private $judul;
    private $penulis;
    private $penerbit;
    private $sinopsis;
    private $tahun_terbit;
    private $gambar;
    private $bahasa;
    private $jumlah_halaman;
    private $stok;
    private $conn;

    // Constructor
    public function __construct($id, $judul, $penulis, $penerbit, $sinopsis, $tahun_terbit, $gambar, $bahasa, $jumlah_halaman, $stok)
    {
        $this->id = $id;
        $this->judul = $judul;
        $this->penulis = $penulis;
        $this->penerbit = $penerbit;
        $this->sinopsis = $sinopsis;
        $this->tahun_terbit = $tahun_terbit;
        $this->gambar = $gambar;
        $this->bahasa = $bahasa;
        $this->jumlah_halaman = $jumlah_halaman;
        $this->stok = $stok;
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    function HitungJumlahBuku()
    {
        $jumlah_buku = null;
        $sql = "SELECT COUNT(*) FROM buku";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($jumlah_buku);
        $stmt->fetch();
        $stmt->close();
        return $jumlah_buku;
    }
    function HitungStok()
    {
        $sql = "SELECT stok FROM buku WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id); 
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc(); 
        $stmt->close();
        return $result['stok']; 
    }
    function UpdateStok()
    {
        $sql = "UPDATE buku SET stok=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $this->stok, $this->id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
    function BukuRekomendasi($limit)
    {
        $sql = "SELECT 
                    buku.*, 
                    Kategori.nama_kategori, 
                    ROUND(AVG(COALESCE(ulasan_buku.rating, 0)), 1) AS rating
                FROM 
                    buku
                INNER JOIN 
                    kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
                INNER JOIN 
                    Kategori ON kategori_buku_relasi.kategori_id = Kategori.id
                LEFT JOIN 
                    ulasan_buku ON buku.id = ulasan_buku.buku_id
                GROUP BY 
                    buku.id
                ORDER BY 
                    RAND()
                LIMIT ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }


    function BukuPopuler($limit = 5)
    {
        $sql = "SELECT 
                    buku.*, 
                    Kategori.nama_kategori, 
                    ROUND(AVG(COALESCE(ulasan_buku.rating, 0)), 1) AS rating
                FROM 
                    buku
                INNER JOIN 
                    kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
                INNER JOIN 
                    Kategori ON kategori_buku_relasi.kategori_id = Kategori.id
                LEFT JOIN 
                    ulasan_buku ON buku.id = ulasan_buku.buku_id
                GROUP BY 
                    buku.id
                ORDER BY 
                    AVG(COALESCE(ulasan_buku.rating, 0)) DESC
                LIMIT 
                    ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    function BukuGroupByKategori()
    {
        $sql = "SELECT 
                    buku.id AS id_buku,
                    buku.judul,
                    buku.penulis,
                    buku.penerbit,
                    buku.sinopsis,
                    buku.jumlah_halaman,
                    buku.bahasa,
                    buku.tahun_terbit,
                    MAX(buku.gambar) AS gambar, -- Menggunakan fungsi agregasi MAX() untuk mengambil gambar buku
                    kategori.nama_kategori,
                    ROUND(AVG(COALESCE(ulasan_buku.rating, 0)), 1) AS nilai_rating
                FROM 
                    buku
                JOIN 
                    kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
                JOIN 
                    Kategori ON kategori_buku_relasi.kategori_id = Kategori.id
                LEFT JOIN 
                    ulasan_buku ON buku.id = ulasan_buku.buku_id
                GROUP BY 
                    kategori.nama_kategori, buku.id
                ORDER BY 
                    kategori.nama_kategori";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    function getAllBukuByKategori($kategori_id)
    {
        $sql = "SELECT 
                buku.*, 
                IFNULL(ulasan.rating, 0) AS rating,
                SUBSTRING_INDEX(GROUP_CONCAT(DISTINCT kategori.nama_kategori ORDER BY kategori.nama_kategori ASC), ',', 1) AS kategori_nama
            FROM 
                buku
            LEFT JOIN 
                kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
            LEFT JOIN 
                kategori ON kategori.id = kategori_buku_relasi.kategori_id
            LEFT JOIN 
                ulasan_buku ulasan ON buku.id = ulasan.buku_id
            WHERE 
                kategori.id = ?
            GROUP BY 
                buku.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $kategori_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
    function searchBooks($searchQuery)
    {
        $searchQuery = "%$searchQuery%";
        $sql = "SELECT buku.*, 
                ROUND(AVG(ulasan.rating), 1) AS rating, 
                SUBSTRING_INDEX(GROUP_CONCAT(DISTINCT kategori.nama_kategori ORDER BY kategori.nama_kategori ASC), ',', 1) AS kategori_nama
                FROM 
                    buku
                LEFT JOIN 
                    kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
                LEFT JOIN 
                    kategori ON kategori.id = kategori_buku_relasi.kategori_id
                LEFT JOIN 
                ulasan_buku ulasan ON buku.id = ulasan.buku_id
                WHERE buku.judul LIKE ? 
                    OR buku.penulis LIKE ?
                    OR buku.penerbit LIKE ?
                    OR buku.tahun_terbit LIKE ?
                    OR kategori.nama_kategori LIKE ?
                    
                GROUP BY buku.id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssis", $searchQuery, $searchQuery, $searchQuery, $searchQuery, $searchQuery);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }
    function TampilBuku()
    {
        $sql = "SELECT 
        b.id AS id,
        b.judul,
        b.penulis,
        b.penerbit,
        b.sinopsis,
        b.jumlah_halaman,
        b.bahasa,
        b.tahun_terbit,
        b.gambar,
        b.stok,
        kb.nama_kategori AS nama_kategori,
        ROUND(AVG(ub.rating), 1) AS rating
    FROM 
        buku AS b
    JOIN 
        kategori_buku_relasi AS kbr ON b.id = kbr.buku_id
    JOIN 
        kategori AS kb ON kbr.kategori_id = kb.id
    LEFT JOIN 
        ulasan_buku AS ub ON b.id = ub.buku_id
    GROUP BY 
        b.id, b.judul, b.penulis, b.penerbit, b.sinopsis, b.jumlah_halaman, b.bahasa, b.tahun_terbit, kb.nama_kategori;";


        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }



    function getAllBookWhereId()
    {
        $sql = "SELECT buku.*, IFNULL(ulasan.rating, 0) AS rating, GROUP_CONCAT(kategori.nama_kategori SEPARATOR ', ') AS kategori_nama
                FROM buku
                LEFT JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
                LEFT JOIN kategori ON kategori.id = kategori_buku_relasi.kategori_id
                LEFT JOIN ulasan_buku ulasan ON buku.id = ulasan.buku_id
                WHERE buku.id = ?
                GROUP BY buku.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    function getBookInKoleksi($user_id)
    {
        $sql = "SELECT 
                    buku.*, 
                    kategori.nama_kategori, 
                    ROUND(AVG(ulasan_buku.rating), 1) AS rata_rating
                FROM 
                    buku 
                INNER JOIN 
                    kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
                INNER JOIN 
                    kategori ON kategori_buku_relasi.kategori_id = kategori.id 
                LEFT JOIN 
                    ulasan_buku ON buku.id = ulasan_buku.buku_id 
                INNER JOIN 
                    koleksi ON buku.id = koleksi.buku_id 
                WHERE 
                    koleksi.user_id = ?
                GROUP BY 
                    buku.id;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }



    function getBookInPeminjaman($user_id)
    {
        $sql = "SELECT buku.*, 
        kategori.nama_kategori, 
        peminjaman.tanggal_peminjaman, 
        peminjaman.tanggal_pengembalian, 
        peminjaman.status_peminjaman 
    FROM 
        buku 
    INNER JOIN 
        kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id 
    INNER JOIN 
        kategori ON kategori_buku_relasi.kategori_id = kategori.id 
    INNER JOIN 
        peminjaman ON buku.id = peminjaman.buku_id WHERE peminjaman.user_id = ?;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }



    function TambahBuku()
    {
        $sql = "INSERT INTO buku (judul, penulis, penerbit, sinopsis, tahun_terbit,gambar, bahasa, jumlah_halaman,stok) VALUES (?, ?, ?, ?, ?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssissii", $this->judul, $this->penulis, $this->penerbit, $this->sinopsis, $this->tahun_terbit, $this->gambar, $this->bahasa, $this->jumlah_halaman, $this->stok);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }



    function EditBuku()
    {
        $sql = "UPDATE buku SET judul=?, penulis=?, penerbit=?, sinopsis=?, tahun_terbit=?, bahasa=?, jumlah_halaman=?, gambar=?, stok=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssisssii", $this->judul, $this->penulis, $this->penerbit, $this->sinopsis, $this->tahun_terbit, $this->bahasa, $this->jumlah_halaman, $this->gambar, $this->stok, $this->id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    function HapusBuku()
    {
        $sql = "DELETE FROM buku WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    function TampilId()
    {
        $sql = "SELECT id FROM buku WHERE judul=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $this->judul);
        $stmt->execute();
        $result = $stmt->get_result();
        $id = null;
        if ($row = $result->fetch_assoc()) {
            $id = $row['id'];
        }
        $stmt->close();
        return $id;
    }


    function AdminTampilPinjaman()
    {
        $sql = "SELECT buku.judul,buku.gambar,buku.stok, user.username AS username_peminjam,  peminjaman.tanggal_peminjaman, peminjaman.tanggal_pengembalian, peminjaman.id
        FROM peminjaman
        INNER JOIN buku ON peminjaman.buku_id = buku.id
        INNER JOIN user ON peminjaman.user_id = user.id
        WHERE peminjaman.status_peminjaman = 'belum dikembalikan'; ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
    function AdminTampilBuku()
    {
        $sql = "SELECT buku.*, kategori.nama_kategori
                FROM buku
                LEFT JOIN kategori_buku_relasi ON buku.id = kategori_buku_relasi.buku_id
                LEFT JOIN kategori ON kategori_buku_relasi.kategori_id = kategori.id
                WHERE buku.id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }
    function BukuPalingBanyakDipinjam()
    {
        $sql = "SELECT buku.judul AS judul_buku, COUNT(peminjaman.id) AS total_peminjaman
                FROM buku
                JOIN peminjaman ON buku.id = peminjaman.buku_id
                GROUP BY buku.id
                ORDER BY total_peminjaman DESC
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }
    function DaftarBukuLaporan()
    {
        $sql = "SELECT 
        b.id AS id_buku,
        b.judul,
        b.penulis,
        k.nama_kategori AS kategori,
        COUNT(p.id) AS total_dipinjam
    FROM 
        buku b
    JOIN 
        kategori_buku_relasi kb ON b.id = kb.buku_id
    JOIN 
        kategori k ON kb.kategori_id = k.id
    LEFT JOIN 
        peminjaman p ON b.id = p.buku_id
    GROUP BY 
        b.id
    ORDER BY 
        b.id ASC;";

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
$bukuModel = new Buku(null, null, null, null, null, null, null, null, null, null);

/*
$user_id = 1;
$books = $bukuModel->getBookInPeminjaman($user_id);

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Sinopsis</th><th>Tahun Terbit</th><th>Kategori</th><th>Status</th><th>Tgl peminjaman</th><th>Tgl pengembalilan</th></tr>";
foreach ($books as $book) {
    echo "<tr>";
    echo "<td>" . $book['id'] . "</td>";
    echo "<td>" . $book['judul'] . "</td>";
    echo "<td>" . $book['penulis'] . "</td>";
    echo "<td>" . $book['penerbit'] . "</td>";
    echo "<td>" . $book['sinopsis'] . "</td>";
    echo "<td>" . $book['tahun_terbit'] . "</td>";
    echo "<td>" . $book['nama_kategori'] . "</td>";
    echo "<td>" . $book['status_peminjaman'] . "</td>";
    echo "<td>" . $book['tanggal_peminjaman'] . "</td>";
    echo "<td>" . $book['tanggal_pengembalian'] . "</td>";
    echo "</tr>";
}
echo "</table>";

$buku = $bukuModel->getAllBook();

echo "<table class='table table-striped'>";
echo "<thead>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>Judul</th>";
echo "<th>Penulis</th>";
echo "<th>Penerbit</th>";
echo "<th>Sinopsis</th>";
echo "<th>Tahun Terbit</th>";
echo "<th>Kategori</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

foreach ($buku as $row) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['judul'] . "</td>";
    echo "<td>" . $row['penulis'] . "</td>";
    echo "<td>" . $row['penerbit'] . "</td>";
    echo "<td>" . $row['sinopsis'] . "</td>";
    echo "<td>" . $row['tahun_terbit'] . "</td>";
    echo "<td>" . $row['nama_kategori'] . "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
*/
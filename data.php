<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<table border="1">

<tr>
    <th>NO.</th>
    <th>Judul</th>
    <th>PENULIS</th>
    <th>PENERBIT</th>
</tr>
<?php
$conn = mysqli_connect("localhost", "root", "", "perpus");

$buku = mysqli_query($conn, "SELECT * FROM buku");
$data_buku = mysqli_fetch_array($buku);

$no = 1;
while ($data_buku = mysqli_fetch_array($buku)) {
    echo '
    <tr>
        <td>' . $no . '</td>
        <td>' . $data_buku['judul'] . '</td>
        <td>' . $data_buku['penulis'] . '</td>
        <td>' . $data_buku['penerbit'] . '</td>
        <td>' . $data_buku['tahun_terbit'] . '</td>
        <td>' . $data_buku['sinopsis'] . '</td>
        <td>' . $data_buku['stok'] . '</td>
        <td>' . $data_buku['jumlah_halaman'] . '</td>
        <td>' . $data_buku['penerbit'] . '</td>
        <td>' . $data_buku['bahasa'] . '</td>


    </tr>
    ';
    $no++;
}
?>
</table>

</body>
</html>

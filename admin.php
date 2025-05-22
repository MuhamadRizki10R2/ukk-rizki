<?php

session_start();
include("connected.php");

if (isset($_POST['tambah'])) {
    $id_buku = $_POST['id_buku'];
    $no_buku = $_POST['no_buku'];
    $judul_buku = $_POST['judul_buku'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $jumlah_halaman = $_POST['jumlah_halaman'];
    $harga = $_POST['harga'];
    $gambar_buku = $_POST['gambar_buku'];


    $sql = "INSERT INTO buku(id_buku, no_buku,
    judul_buku, tahun_terbit, penulis, penerbit, jumlah_halaman, harga, gambar_buku) VALUES('$id_buku', '$no_buku', '$judul_buku', '$tahun_terbit', '$penulis', '$penerbit', '$jumlah_halaman', '$harga', '$gambar_buku')";
    mysqli_query($connect, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    link rel="stylesheet" href="admin.css">
</head>

<body>
    <div class="container">
        <h2>Editing Kerjaan si Admin</h2>
        <form action="admin.php" method="post">
            <div class="grup-container">
                <input type="text" name="id_buku" placeholder="Masukkan Kode Buku" required><br>
            </div>
            <div class="grup-container">
                <input type="number" name="no_buku" placeholder="Masukkan No Buku" required><br>
            </div>
            <div class="grup-container">
                <input type="text" name="judul_buku" placeholder="Masukkan Judul Buku" required><br>
            </div>
            <div class="grup-container">
                <input type="date" name="tahun_terbit" placeholder="Masukkan Tahun Terbit" required><br>
            </div>
            <div class="grup-container">
                <input type="text" name="penulis" placeholder="Masukkan Penulis" required><br>
            </div>
            <div class="grup-container">
                <input type="text" name="penerbit" placeholder="Masukkan Penerbit"><br>
            </div>
            <div class="grup-container">
                <input type="number" name="jumlah_halaman" placeholder="Masukkan Jumlah Halaman" required><br>
            </div>
            <div class="grup-container">
                <input type="number" name="harga" placeholder="Masukkan Harga" required><br>
            </div>
            <div class="grup-container">
                <input type="text" name="gambar_buku" placeholder="Masukkan Gambar Buku" required><br>
            </div>
            <div class="grup-container">
                <input type="number" name="stok_tersedia" placeholder="Masukkan Stok"><br>
            </div>
            <div class="btn">
                <input type="submit" name="tambah" value="Tambah" class="btn-tambah">
            </div>
        </form>
        <div class="table-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>ID BUKU</th>
                        <th>NO BUKU</th>
                        <th>JUDUL BUKU</th>
                        <th>TAHUN TERBIT</th>
                        <th>PENULIS</th>
                        <th>PENERBIT</th>
                        <th>JUMLAH HALAMAN</th>
                        <th>HARGA</th>
                        <th>STOK TERSEDIA</th>
                        <th>GAMBAR</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <?php
                $sql = mysqli_query($connect, "SELECT * FROM buku");
                while ($data = mysqli_fetch_array($sql)) {
                ?>
                    <tbody>
                        <tr>
                            <td><?= $data['id_buku'] ?></td>
                            <td><?= $data['no_buku'] ?></td>
                            <td><?= $data['judul_buku'] ?></td>
                            <td><?= $data['tahun_terbit'] ?></td>
                            <td><?= $data['penulis'] ?></td>
                            <td><?= $data['penerbit'] ?></td>
                            <td><?= $data['jumlah_halaman'] ?></td>
                            <td><?= $data['harga'] ?></td>
                            <td><?= $data['stok_tersedia'] ?></td>
                            <td>
                                <img src="<?= $data['gambar_buku'] ?>" alt="cover" width="80px">
                            </td>
                            <td>
                                <a href="edit.php?no_buku=<?php echo $data['no_buku']; ?>">EDIT</a>
                                <a href="hapus.php?no_buku=<?php echo $data['no_buku']; ?>">HAPUS</a>
                            </td>
                        </tr>
                    </tbody>
                <?php
                }
                ?>
            </table>
        </div>
</body>

</html>
</body>

</html>
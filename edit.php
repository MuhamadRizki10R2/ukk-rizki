<?php

session_start();
include("connected.php");

// Handle POST request
if (isset($_POST['edit'])) {
    // Ambil dan sanitasi data POST
    $no_lama = mysqli_real_escape_string($connect, $_POST['no_lama']);
    $id_buku = mysqli_real_escape_string($connect, $_POST['id_buku']);
    $no_buku = mysqli_real_escape_string($connect, $_POST['no_buku']);
    $judul_buku = mysqli_real_escape_string($connect, $_POST['judul_buku']);
    $tahun_terbit = mysqli_real_escape_string($connect, $_POST['tahun_terbit']);
    $penulis = mysqli_real_escape_string($connect, $_POST['penulis']);
    $penerbit = mysqli_real_escape_string($connect, $_POST['penerbit']);
    $jumlah_halaman = mysqli_real_escape_string($connect, $_POST['jumlah_halaman']);
    $harga = mysqli_real_escape_string($connect, $_POST['harga']);
    $gambar_buku = mysqli_real_escape_string($connect, $_POST['gambar_buku']);
    $stok_tersedia = mysqli_real_escape_string($connect, $_POST['stok_tersedia']);

    // Validasi data
    if (empty($tahun_terbit) || !strtotime($tahun_terbit)) {
        die("Format tanggal tidak valid");
    }

    // Update data
    $query = "UPDATE buku SET 
        id_buku = '$id_buku',
        no_buku = '$no_buku',
        judul_buku = '$judul_buku',
        tahun_terbit = '$tahun_terbit',
        penulis = '$penulis',
        penerbit = '$penerbit',
        jumlah_halaman = '$jumlah_halaman',
        harga = '$harga',
        gambar_buku = '$gambar_buku',
        stok_tersedia = '$stok_tersedia' 
        WHERE no_buku = '$no_lama'";

    if(mysqli_query($connect, $query)) {
        header("Location: admin.php");
        exit();

    } else {
        die("Gagal update: " . mysqli_error($connect));
    }
}

// Handle GET request
if (!isset($_GET['no_buku'])) {
    die("Akses harus melalui link edit yang valid");
}

$id = mysqli_real_escape_string($connect, $_GET['no_buku']);
$result = mysqli_query($connect, "SELECT * FROM buku WHERE no_buku = '$id'");

if (!$result || mysqli_num_rows($result) == 0) {
    die("Data buku tidak ditemukan");
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
</head>
<body>
    <h2>Edit Data Buku</h2>
    <form method="POST">
        <input type="hidden" name="no_lama" value="<?= htmlspecialchars($data['no_buku']) ?>">
        
        Kode Buku: <br>
        <input type="text" name="id_buku" value="<?= htmlspecialchars($data['id_buku']) ?>" required><br>
        
        Nomor Buku: <br>
        <input type="number" name="no_buku" value="<?= htmlspecialchars($data['no_buku']) ?>" required><br>
        
        Judul Buku: <br>
        <input type="text" name="judul_buku" value="<?= htmlspecialchars($data['judul_buku']) ?>" required><br>
        
        Tahun Terbit: <br>
        <input type="date" name="tahun_terbit" value="<?= htmlspecialchars($data['tahun_terbit']) ?>" required><br>
        
        Penulis: <br>
        <input type="text" name="penulis" value="<?= htmlspecialchars($data['penulis']) ?>" required><br>
        
        Penerbit: <br>
        <input type="text" name="penerbit" value="<?= htmlspecialchars($data['penerbit']) ?>" required><br>
        
        Jumlah Halaman: <br>
        <input type="number" name="jumlah_halaman" value="<?= htmlspecialchars($data['jumlah_halaman']) ?>" required><br>
        
        Harga: <br>
        <input type="number" name="harga" value="<?= htmlspecialchars($data['harga']) ?>" required><br>
        
        Gambar Buku: <br>
        <input type="text" name="gambar_buku" value="<?= htmlspecialchars($data['gambar_buku']) ?>" required><br>

        Stok Tersedia
        <input type="number" name="stok_tersedia" value="<?= htmlspecialchars($data['stok_tersedia'])?>" required><br>
        
        <input type="submit" name="edit" value="Simpan Perubahan">
    </form>
</body>
</html>


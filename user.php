<?php

session_start();
include("connected.php");

// Handle notifikasi
if (isset($_SESSION['pesan'])) {
    echo "<script>alert('" . $_SESSION['pesan'] . "')</script>";
    unset($_SESSION['pesan']);
}

// Proses Pinjam
if (isset($_GET['pinjam'])) {
    $no_buku = $_GET['pinjam'];

    try {
        $connect->begin_transaction();

        // CEK STOK (Prepared Statement)
        $stmt = $connect->prepare("SELECT stok_tersedia FROM buku WHERE no_buku=? FOR UPDATE");
        $stmt->bind_param("s", $no_buku);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if (!$data) {
            throw new Exception("Buku tidak ditemukan");
        }

        if ($data['stok_tersedia'] > 0) {
            //update stok
            $update_stmt = $connect->prepare("UPDATE buku SET stok_tersedia = stok_tersedia - 1 WHERE no_buku=?");
            $update_stmt->bind_param("s", $no_buku);
            $update_stmt->execute();

            if ($update_stmt->affected_rows) {
                $_SESSION['pinjam'][$_SESSION['user_id']][$no_buku] = true;
                $_SESSION['pesan'] = "Buku berhasil dipinjam!";
                $connect->commit();
            } else {
                throw new Exception("Gagal update stok");
            }
        }
    } catch (Exception $e) {
        $connect->rollback();
        $_SESSION['pesan'] = "Error: " . $e->getMessage();
    }
    header("Location: user.php");
    exit();
}

// PROSES KEMBALIKAN
if (isset($_GET['kembalikan'])) {
    $no_buku = mysqli_real_escape_string($connect, $_GET['kembalikan']);

    if (isset($_SESSION['pinjam'][$_SESSION['user_id']][$no_buku]) && $_SESSION['pinjam'][$_SESSION['user_id']][$no_buku]) {
        try {
            $connect->begin_transaction();

            $stmt = $connect->prepare("UPDATE buku SET stok_tersedia = stok_tersedia + 1 WHERE no_buku=?");
            $stmt->bind_param("s", $no_buku);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['pinjam'][$no_buku] = false;
                $_SESSION['pesan'] = "Buku berhasil dikembalikan!";
                $connect->commit();
            } else {
                throw new Exception("Gagal update stok");
            }

        } catch (Exception $e) {
            $connect->rollback();
            $_SESSION['pesan'] = "Error: " . $e->getMessage();
        }
    } else {
        $_SESSION['pesan'] = "Anda belum meminjam buku ini atau sudah dikembalikan!";
    }

    header("Location: user.php");
    exit();
}

if (isset($_POST['kembali'])) {
    header("login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>

<body>
    <table border="1">
        <tr>
            <th>ID BUKU</th>
            <th>NO BUKU</th>
            <th>JUDUL BUKU</th>
            <th>TAHUN TERBIT</th>
            <th>PENULIS</th>
            <th>PENERBIT</th>
            <th>JUMLAH HALAMAN</th>
            <th>HARGA</th>
            <th>GAMBAR</th>
            <td>STOK TERSEDIA</td>
            <td>ACTION</td>
        </tr>
        <?php
        $sql = mysqli_query($connect, "SELECT * FROM buku");
        while ($data = mysqli_fetch_array($sql)) {
            ?>
            <tr>
                <td><?= $data['id_buku'] ?></td>
                <td><?= $data['no_buku'] ?></td>
                <td><?= $data['judul_buku'] ?></td>
                <td><?= $data['tahun_terbit'] ?></td>
                <td><?= $data['penulis'] ?></td>
                <td><?= $data['penerbit'] ?></td>
                <td><?= $data['jumlah_halaman'] ?></td>
                <td><?= $data['harga'] ?></td>
                <td>
                    <img src="<?= $data['gambar_buku'] ?>" alt="cover" width="80px" name="pinjam">
                </td>
                <td>
                    <?php
                    if ($data['stok_tersedia'] > 0) {
                        echo $data['stok_tersedia'];
                    } else {
                        echo "<span style='color:red'>Stok Habis</span>";
                    }
                    ?>
                </td>
                <td>
                    <a href="user.php?pinjam=<?= $data['no_buku'] ?>">Pinjam</a>
                    <a href="user.php?kembalikan=<?= $data['no_buku'] ?>">Kembalikan</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <div class="btn">
        <form action="login.php" method="post">
            <input type="submit" name="kembali" value="Kembali">
        </form>
    </div>
</body>

</html>
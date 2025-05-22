<?php

session_start();
include("connected.php");

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $passwords = $_POST['passwords'];
    $role = $_POST['roles'];

    mysqli_query($connect, "INSERT INTO users(username, passwords, roles) VALUES('$username', '$passwords', '$role')");
} else if (isset($_POST['kembali'])) {
    header("Location:login.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUPER ADMIN</title>
</head>

<body>
    <div class="form-content">
        <h2>Super Admin si Paling punya Kuasa</h2>
        <form action="superadmin.php" method="post">
            <div class="grup-content">
                <input type="text" name="username" placeholder="Masukkan Username"><br>
            </div>
            <div class="grup-content">
                <input type="password" name="passwords" placeholder="Masukkan Password"><br>
            </div>
            <div class="grup-content">
                <select name="roles">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="superadmin">Super Admin</option>
                </select>
            </div>
            <div class="button-container">
                <input type="submit" name="tambah" value="Tambah" class="tambah-button">
        </form>
        <form action="login.php" method="post">
            <input type="submit" name="kembali" value="Kembali" class="kembali-button">
        </form>
    </div>
    </div>

</body>

</html>
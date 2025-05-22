<?php

session_start();
include('connected.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $passwords = $_POST['passwords'];

    $sql = "SELECT * FROM users WHERE username = '$username' AND passwords = '$passwords'";
    $result = mysqli_query($connect, $sql);

    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);

        if ($data['roles'] == 'user') {
            header("Location: user.php");
        } else if ($data['roles'] == 'admin') {
            header("Location: admin.php");
        }
        else {
            header("Location:superadmin.php");
        }
    } else {
        echo 'Login Gagal';
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <h2>Login aja dulu masalah berhasil Belakangan</h2>
        <form action="login.php" method="post">
            <div class="grup-input">
                <input type="text" name="username" placeholder="Masukkan Username"><br>
            </div>
            <div class="grup-input">
                <input type="password" name="passwords" placeholder="Masukkan Password"><br>
            </div>
            <div class="grup-input">
                <input type="submit" name="login" value="Login" class="">
            </div>
        </form>
    </div>
</body>
</html>
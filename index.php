<?php
session_start();
include("connected.php");

// Ambil semua data dari tabel users
$query = "SELECT * FROM users";
$result = mysqli_query($connect, $query);

if (isset($_POST['back'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Users</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional: custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #333;
            color: white;
        }
        h2 {
            text-align: center;
        }
        .back-button {
            display: block;
            margin: 20px auto;
            text-align: center;
        }
        .back-button a {
            text-decoration: none;
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h2>Data Pengguna</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . htmlspecialchars($row['passwords']) . "</td>";
                echo "<td>" . htmlspecialchars($row['roles']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
            <form action="login.php" method="post">
                <input type="submit" name="back" value="Kembali">
            </form>

</body>
</html>
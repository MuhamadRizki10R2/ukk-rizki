<?php

session_start();
include("connected.php");

if (isset($_GET['no_buku'])) {
    $id = $_GET['no_buku'];

    mysqli_query($connect, "DELETE FROM buku WHERE no_buku='$id'");
}

header("Location: admin.php");

?>
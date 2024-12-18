<?php
    require '../koneksi.php';
    $id = $_GET['id'];

    $query ="DELETE FROM user WHERE id='$id'";
    $data = mysqli_query($koneksi, $query);
    header("location:lihatUser.php");
?>
<?php
require 'koneksi.php';

if(isset($_POST['tambah']) || isset($_POST['kurangi'])){
    $cart_id = $_POST ['cart_id'];
    $queryCart = mysqli_query($koneksi, "SELECT * FROM cart WHERE id='$cart_id'");
    $dataCart = mysqli_fetch_array($queryCart);
    $jumlah = $dataCart['jumlah'];

    if(isset($_POST['tambah'])){
        $jumlah++;
    } elseif(isset($_POST['kurangi']) && $jumlah > 1){
        $jumlah--;
    }

    mysqli_query($koneksi, "UPDATE cart SET jumlah='$jumlah' WHERE id='$cart_id'");
}

header("location: keranjang.php");
?>
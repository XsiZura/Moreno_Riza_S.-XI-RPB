<?php
require 'koneksi.php';

if(isset($_POST['hapus'])){
    $cart_id = $_POST['cart_id'];
    $queryDelete = mysqli_query($koneksi, "DELETE FROM cart WHERE id='$cart_id'");

    if($queryDelete){
        echo "<script>alert('Produk berhasil dihapus'); window.location='keranjang.php'</script>";
    } else {
        echo"<script>alert('Gagal menghapus produk'); window.location='keranjang.php'</script>";
    }
}
?>
<?php
session_start();
require 'koneksi.php';

$nama = htmlspecialchars($_GET['nama']);
$queryP = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_produk='$nama'");
$queryK = mysqli_query($koneksi, "SELECT * FROM kategori");
$produk = mysqli_fetch_array($queryP);
$kategori = mysqli_fetch_array($queryK);

$queryPt = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' LIMIT 4");

if (isset($_POST['addbtn'])) {
    $id_produk = $produk['id'];
    $kategori_id = $produk['kategori_id'];
    $harga = $produk['harga'];
    $stok = 1;

    $queryCart = mysqli_query($koneksi, "INSERT INTO cart (produk_id, kategori_id, total, jumlah) VALUES ('$id_produk','$kategori_id','$harga','$stok')");
    if ($queryCart) {
        echo "<script>alert('Produk Berhasil ditambahkan'); window.location='keranjang.php'</script>";
    } else {
        echo "<script>alert('Gagal menambahkan produk');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Detail </title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <?php require 'navbar.php'; ?>

    <!-- Detail Produk -->
    <div class="container-fluid py-5">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-5 mb-5">
                    <img src="image/<?php echo $produk['foto']; ?>" class="w-100">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo $produk['nama_produk']; ?></h1>
                    <p class="fs-5">
                        Kategori: <?php echo $kategori['nama']; ?>
                    </p>
                    <p class="fs-5">
                        <?php echo $produk['detail']; ?>
                    </p>
                    <p class="fs-3 text-harga">
                        Rp. <?php echo number_format($produk['harga']); ?>
                    </p>
                    <p class="fs-3">
                        Stok: <strong><?php echo $produk['stok'] ?></strong>
                    </p>

                    <div class="mt-5 d-flex justify-content-between">
                        <a href="Produk.php" role="button" class="btn btn-warning">Kembali</a>
                        <form method="post">
                            <button type="submit" class="btn btn-primary" name="addbtn">Tambah Ke Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Terkait -->
    <div class="container-fluid py-5 color1">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>
            <div class="row">
                <?php while ($data = mysqli_fetch_array($queryPt)) { ?>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <img src="image/<?php echo $data['foto'] ?>" class="img-fluid img-thumbnail" alt="">
                    </div>
                <?php } ?>
            </div>
        </div>

        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="fontawesome/js/all.min.js"></script>
</body>

</html>
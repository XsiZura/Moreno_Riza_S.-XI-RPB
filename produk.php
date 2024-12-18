<?php
session_start();
require 'koneksi.php';

$queryK = mysqli_query($koneksi, "SELECT * FROM kategori");

// get produk
if (isset($_GET['keyword'])) {
    $queryP = mysqli_query($koneksi, "SELECT * FROM produk WHERE nama_produk LIKE '%$_GET[keyword]%'");
}
// get produk by kategori
else if (isset($_GET['kategori'])) {
    $queryGetK = mysqli_query($koneksi, "SELECT id FROM kategori WHERE nama='$_GET[kategori]'");
    $kategoriId = mysqli_fetch_array($queryGetK);

    $queryP = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori_id='$kategoriId[id]'");
}

//get produk by nama produk
else {
    $queryP = mysqli_query($koneksi, "SELECT * FROM produk");
}

$countData = mysqli_num_rows($queryP);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<style>
    .banner-produk {
        height: 45vh;
        background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('image/banner.jpg');
        background-position: cover;
        background-size: unset;
    }
</style>

<body>
    <?php
    require 'navbar.php';
    ?>

    <!-- banner -->
    <div class="containee-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while ($kategori = mysqli_fetch_array($queryK)) { ?>
                        <a class="no-decoration" href="produk.php?kategori=<?php echo $kategori['nama']; ?>">
                            <li class="list-group-item"><?php echo $kategori['nama']; ?></li>
                        </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">
                    <?php
                    if ($countData < 1) {
                    ?>
                        <div class="alert alert-warning mt3 text-center" role="alert">
                            Produk yang anda cari tidak ada
                        </div>
                    <?php
                    }
                    ?>
                    <?php while ($produk = mysqli_fetch_array($queryP)) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="image/<?php echo $produk ['foto']?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $produk['nama_produk']?></h5>
                                    <p class="card-text text-detail"><?php echo $produk['detail']?></p>
                                    <p class="card-text text-harga">Rp.<?php echo number_format($produk['harga'])?></p>
                                    <a href="p-detail.php?nama=<?php echo $produk['nama_produk'];?>" class="btn color4 text-white">Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script src=" bootstrap/js/bootstrap.bundle.min.js">
    </script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>
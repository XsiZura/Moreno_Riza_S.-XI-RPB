<?php
require 'session.php';
require '../koneksi.php';

$querykategori = mysqli_query($koneksi, "SELECT * FROM kategori");
$jumlahkategori = mysqli_num_rows($querykategori);

$queryproduk = mysqli_query($koneksi, "SELECT * FROM produk");
$jumlahproduk = mysqli_num_rows($queryproduk);

$queryuser = mysqli_query($koneksi, "SELECT * FROM user");
$jumlahuser = mysqli_num_rows($queryuser);

$queryDetail = mysqli_query($koneksi, "SELECT * FROM detail_transaksi");
$jumlahDetail = mysqli_num_rows($queryDetail);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/styled.css">
</head>

<style>
    .kotak {
        border: solid;
    }

    .summary-kategori {
        background-color: #037fb7;
        border-radius: 15px;
    }

    .summary-produk {
        background-color: #97b703;
        border-radius: 15px;
    }

    .summary-user {
        background-color: black;
        border-radius: 15px;
    }

    .summary-detail {
        background-color: #51d844;
        border-radius: 15px;
    }

    .no-decoration {
        text-decoration: none;
    }
</style>

<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="kategori.php">Kategori</a>
        <a href="produk.php">Produk</a>
        <a href="lihatUser.php">User</a>
        <a href="detail.php">Transaksi</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container mt-5">
        <navbar aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i> Home
                </li>
            </ol>
        </navbar>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-kategori p-4">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-list fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-black">
                                <h3 class="fs-2">Kategori</h3>
                                <p class="fs-4"><?php echo $jumlahkategori; ?> kategori</p>
                                <p><a href="kategori.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-produk p-4">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-box-archive fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-black">
                                <h3 class="fs-2">Produk</h3>
                                <p class="fs-4"><?php echo $jumlahproduk; ?> produk</p>
                                <p><a href="produk.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-user p-4">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-user fa-7x text-white"></i>
                            </div>
                            <div class="col-6 text-white">
                                <h3 class="fs-2">User</h3>
                                <p class="fs-4"><?php echo $jumlahuser; ?> user</p>
                                <p><a href="lihatUser.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mb-3">
                    <div class="summary-detail p-4">
                        <div class="row">
                            <div class="col-6">
                                <i class="fa-solid fa-clipboard fa-7x text-black-50"></i>
                            </div>
                            <div class="col-6 text-black">
                                <h3 class="fs-3">Transaksi</h3>
                                <p class="fs-4"><?php echo $jumlahDetail; ?> Transaksi</p>
                                <p><a href="detail.php" class="text-white no-decoration">Lihat Detail</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>

</body>

</html>
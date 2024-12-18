<?php
require 'session.php';
require '../koneksi.php';

$querydetail = mysqli_query($koneksi, "  SELECT 
        dt.transaksi_id,
        p.nama_produk AS nama_produk,
        k.nama AS nama_kategori,
        dt.jumlah,
        dt.tanggal_transaksi,
        dt.harga_total AS total
    FROM detail_transaksi dt
    JOIN produk p ON dt.produk_id = p.id
    JOIN kategori k ON dt.kategori_id = k.id
    ORDER BY dt.transaksi_id ASC");
$jumlahdetail = mysqli_num_rows($querydetail);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi </title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/styled.css">
</head>
<style>
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
                    <a class="no-decoration text-muted" href="../AdminPanel/">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    Data Transaksi
                </li>
            </ol>
        </navbar>
        <div class="mt-3">
            <h2 class="text-center">Data Transaksi</h2>
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>id_transaksi</th>
                            <th>produk</th>
                            <th>kategori</th>
                            <th>jumlah</th>
                            <th>total</th>
                            <th>tanggal_transaksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if ($jumlahdetail == 0) {
                        ?>
                            <tr>
                                <td colspan="6" class="text text-center">Data Transaksi Tidak tersedia</td>
                            </tr>
                            <?php

                        } else {
                            while ($data = mysqli_fetch_array($querydetail)) {
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $data['transaksi_id']; ?></td>
                                    <td><?php echo $data['nama_produk']; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?></td>
                                    <td><?php echo $data['jumlah']; ?></td>
                                    <td><?php echo $data['total']; ?></td>
                                    <td><?php echo $data['tanggal_transaksi']?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>
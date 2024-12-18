<?php
require 'session.php';
require '../koneksi.php';

$queryuser = mysqli_query($koneksi, "SELECT * FROM user");
$jumlahuser = mysqli_num_rows($queryuser);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Kategori</title>
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
                    User
                </li>
            </ol>
        </navbar>
        <div class="mt-3">
            <h2 class="text-center">List User</h2>
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if ($jumlahuser == 0) {
                        ?>
                            <tr>
                                <td colspan="3" class="text text-center">Data user tidak tersedia</td>
                            </tr>
                            <?php

                        } else {
                            while ($data = mysqli_fetch_array($queryuser)) {
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $data['username']; ?></td>
                                    <td>
                                        <a href="delete_user.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Anda Yakin ingin menghapus ini?')" class="btn btn-danger">Hapus</a>
                                    </td>
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
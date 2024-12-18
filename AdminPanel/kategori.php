<?php
require 'session.php';
require '../koneksi.php';

$querykategori = mysqli_query($koneksi, "SELECT * FROM kategori");
$jumlahkategori = mysqli_num_rows($querykategori);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
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
                    Kategori
                </li>
            </ol>
        </navbar>

        <div class="my-5 col-12 col-md-6">
            <h3 Tambah Kategori> </h3>
            <form action="" method="post">
                <div>
                    <label for="kategori">Kategori</label>
                    <input type="text" id="kategori" name="kategori" placeholder="input nama kategori" class="form-control mt-3" required>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
                </div>
            </form>
            <!-- <div class="alert alert-primary mt-3" role="alert"></div> -->
        </div>
        <?php
        if (isset($_POST['simpan'])) {
            $kategori = htmlspecialchars($_POST['kategori']);
            $kategorisama = mysqli_query($koneksi, "SELECT nama FROM kategori WHERE  nama='$kategori'");
            $jumlah = mysqli_num_rows($kategorisama);

            if ($jumlah > 0) {
        ?>
                <div class="alert alert-warning mt-3" role="alert">
                    kategori sudah ada
                </div>
                <?php
            } else {
                $simpan = mysqli_query($koneksi, "INSERT INTO kategori (nama) VALUES ('$kategori')");
                if ($simpan) {
                ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        kategori Berhasil Disimpan
                    </div>
                    <meta http-equiv="refresh" content="2; url=kategori.php" />
        <?php
                } else {
                    echo mysqli_error($koneksi);
                }
            }
        }
        ?>
        <div class="mt-3">
            <h2>List Kategori</h2>
            <div class="table-responsive mt-5">
                <table class="table">
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
                        if ($jumlahkategori == 0) {
                        ?>
                            <tr>
                                <td colspan="3" class="text text-center">Data kategori tidak tersedia</td>
                            </tr>
                            <?php

                        } else {
                            while ($data = mysqli_fetch_array($querykategori)) {
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td>
                                        <a href="kategoridetail.php?p=<?php echo $data['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-magnifying-glass"></i></i></a>

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
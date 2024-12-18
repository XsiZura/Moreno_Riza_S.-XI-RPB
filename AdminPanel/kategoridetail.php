<?php
require 'session.php';
require '../koneksi.php';

$id = $_GET['p'];
$query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id='$id'");
$data = mysqli_fetch_array($query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kategori</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/styled.css">
</head>

<body>
    <nav>
        <a href="index.php">Home</a>
        <a href="kategori.php">Kategori</a>
        <a href="produk.php">Produk</a>
        <a href="lihatUser.php">User</a>
        <a href="detail.php">Transaksi</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container mt-3">

        <h2>Detail Kategori</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post">
                <div>
                    <div class="mt-5 mb-1 d-flex justify-content-between">
                        <label for="kategori">Kategori</label><a href="kategori.php" role="button" class="btn btn-warning"><i class="fa-solid fa-arrow-left-long"></i></a>
                    </div>
                    <input type="text" name="kategori" id="kategori" class="form-control" value="<?php echo $data['nama'] ?>">
                </div>

                <div class="mt-5 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary " name="editbtn">Edit</button>
                    <button type="submit" class="btn btn-danger" name="hapusbtn">Delete</button>
                </div>
            </form>
            <?php
            if (isset($_POST['editbtn'])) {
                $kategori = htmlspecialchars($_POST['kategori']);

                if ($data['nama'] == $kategori) {
            ?>
                    <meta http-equiv="refresh" content="2; url=kategori.php" />
                    <?php
                } else {
                    $query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama='$kategori'");
                    $jumlahdata = mysqli_num_rows($query);

                    if ($jumlahdata > 0) {
                    ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            kategori sudah ada
                        </div>
                        <?php
                    } else {
                        $simpan = mysqli_query($koneksi, "UPDATE kategori SET nama='$kategori' WHERE id='$id'");
                        if ($simpan) {
                        ?>
                            <div class="alert alert-primary mt-3" role="alert">
                                kategori Berhasil Diupdate
                            </div>
                            <meta http-equiv="refresh" content="2; url=kategori.php" />
                    <?php
                        } else {
                            echo mysqli_error($koneksi);
                        }
                    }
                }
            }

            if (isset($_POST['hapusbtn'])) {
                $check = mysqli_query($koneksi, "SELECT * FROM produk WHERE kategori_id='$id'");
                $datahitung = mysqli_num_rows($check);


                if ($datahitung > 0) {
                    ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Kategori tidak bisa dihapus karena sudah digunakan di produk
                    </div>
                <?php
                    die();
                }
                $queryhapus = mysqli_query($koneksi, "DELETE FROM kategori WHERE id='$id'");

                if ($queryhapus) {
                ?>
                    <div class="alert alert-warning mt3" role="alert">
                        Kategori Berhasil Dihapus
                    </div>
                    <meta http-equiv="refresh" content="2; url=kategori.php" />
            <?php
                } else {
                    echo mysqli_error($koneksi);
                }
            }
            ?>
        </div>
    </div>

    <script src=" ../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>
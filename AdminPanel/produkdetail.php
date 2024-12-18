<?php

require 'session.php';
require '../koneksi.php';


$id = $_GET['p'];
$query = mysqli_query($koneksi, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id WHERE a.id='$id'");
$data = mysqli_fetch_array($query);

$querykategori = mysqli_query($koneksi, "SELECT * FROM kategori WHERE id!='$data[kategori_id]'");

function generateRandomString($length = 10)
{
    $character = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characterlenght = strlen($character);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString = $character[rand(0, $characterlenght - 1)];
    }
    return $randomString;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styled.css">
</head>

<style>
    form div {
        margin-bottom: 10;
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
        <h2> Detail Produk</h2>

        <div class="col-12 col-md-6">
            <form action="" method="post" enctype="multipart/form-data">

                <div class="mt-3 d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="produk.php" role="button" class="btn btn-warning"><i class="fa-solid fa-arrow-left-long"></i></a>
                </div>
                <div>
                    <label for="name">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $data['nama_produk']; ?>">
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value=""><?php echo $data['nama_kategori']; ?></option>
                        <?php
                        while ($dataKategori = mysqli_fetch_array($querykategori)) {
                        ?>
                            <option value="<?php echo $dataKategori['id'] ?>"><?php echo $dataKategori['nama'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" value="<?php echo $data['harga']; ?>" name="harga">
                </div>
                <div>
                    <label for="currentFoto">Foto Produk Sekarang</label>
                    <img src="../image/<?php echo $data['foto'] ?>" alt="" width="400px" class="mt-3">
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"><?php echo $data['detail']; ?></textarea>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" value="<?php echo $data['stok']; ?>" name="stok">
                </div>
                <div class="mt-3 d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary" name="edit">Simpan</button>
                    <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                </div>
            </form>

            <?php
            if (isset($_POST['edit'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $stok = htmlspecialchars($_POST['stok']);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imagefiletype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imagefiletype;

                if ($nama == '' || $harga == '') {
                } else {
                    if ($kategori == '') {
                        $queryUpdate = mysqli_query($koneksi, "UPDATE produk SET nama_produk='$nama', harga='$harga', detail='$detail', stok='$stok' WHERE id='$id'");
                    } else {
                        $queryUpdate = mysqli_query($koneksi, "UPDATE produk SET kategori_id='$kategori', nama_produk='$nama', harga='$harga', detail='$detail', stok='$stok' WHERE id='$id'");
                    }
            ?>
                    <meta http-equiv="refresh" content="2; url=produk.php" />
                    <?php

                    if ($nama_file != '') {
                        if ($image_size > 9000000) {
                    ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                Ukuran terlalu besar
                            </div>
                            <?php
                        } else {
                            if ($imagefiletype != 'jpg' && $imagefiletype != 'png' && $imagefiletype != 'gif') {
                            ?>
                                <div class="alert alert-warning mt-3" role="alert">
                                    File harus bertipe jpg/png/gif
                                </div>
                                <?php
                            } else {
                                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);

                                $queryupdate = mysqli_query($koneksi, "UPDATE produk SET foto='$new_name' WHERE id='$id'");

                                if ($queryupdate) {
                                ?>
                                    <div class="alert alert-primary mt-3" role="alert">
                                        Produk Berhasil Diupdate
                                    </div>

                                    <meta http-equiv="refresh" content="2; url=produk.php" />
                    <?php
                                } else {
                                    echo mysqli_error($koneksi);
                                }
                            }
                        }
                    }
                }
            }

            if (isset($_POST['hapus'])) {
                $queryHapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id='$id'");

                if ($queryHapus) {
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                        Produk Berhasil Dihapus
                    </div>
                    <meta http-equiv="refresh" content="2; url=produk.php" />
            <?php
                }
            }
            ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>
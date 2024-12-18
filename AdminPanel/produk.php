<?php
require 'session.php';
require '../koneksi.php';

$querybarang = mysqli_query($koneksi, "SELECT a.*, b.nama AS nama_kategori FROM produk a JOIN kategori b ON a.kategori_id=b.id");
$jumlahBarang = mysqli_num_rows($querybarang);

$querykategori = mysqli_query($koneksi, "SELECT * FROM kategori");

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
    <title>Produk</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/styled.css">
</head>
</head>

<style>
    .no-decoration {
        text-decoration: none;
    }

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
        <navbar aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a class="no-decoration text-muted" href="../AdminPanel/">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>

                <li class="breadcrumb-item active" aria-current="page">
                    Produk
                </li>
            </ol>
        </navbar>

        <div class="my-5 col-12 col-md-6">
            <h3>Tambah Produk</h3>

            <form action="" method="post" enctype="multipart/form-data">
                <div>
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
                </div>
                <div>
                    <label for="kategori">Kategori</label>
                    <select name="kategori" id="kategori" class="form-control" required>
                        <option value="">Pilih satu</option>
                        <?php
                        while ($data = mysqli_fetch_array($querykategori)) {
                        ?>
                            <option value="<?php echo $data['id'] ?>"><?php echo $data['nama'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" name="harga" required>
                </div>
                <div>
                    <label for="foto">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" name="stok" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary mt-2" name="simpan">Simpan</button>
                </div>
            </form>

            <?php
            if (isset($_POST['simpan'])) {
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['kategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $detail = htmlspecialchars($_POST['detail']);
                $stok = htmlspecialchars($_POST['stok']);
                $namaSama = mysqli_query($koneksi, "SELECT nama_produk FROM produk WHERE nama_produk='$nama'");
                $jumlah = mysqli_num_rows($namaSama);

                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imagefiletype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imagefiletype;


                if ($nama == '' || $kategori == '' || $harga == '') {
            ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Nama, kategori dan harga wajib di isi
                    </div>
                    <?php
                } else {
                    if ($nama_file != '') {
                        if ($image_size > 90000000000000000000) {
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
                            }
                        }
                    }

                    if ($jumlah > 0) {
                        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            nama produk sudah ada
                        </div>
                    <?php
                    } else {
                        $Tambahquery = mysqli_query($koneksi, "INSERT INTO produk (kategori_id, nama_produk, harga, foto, detail, stok) 
                                                VALUES ('$kategori','$nama','$harga','$new_name','$detail','$stok')");
                    ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Produk Berhasil Disimpan
                        </div>
                        <meta http-equiv="refresh" content="2; url=produk.php" />
            <?php
                    }
                    echo mysqli_error($koneksi);
                }
            }
            ?>
        </div>


        <div class="mt-3 mb-5">
            <h2>List Produk</h2>

            <div class="table-responsive mt-5">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($jumlahBarang == 0) {
                        ?>
                            <td colspan="7" class="text-center">Data barang tidak tersedia</td>
                            <?php
                        } else {
                            $i = 1;
                            while ($data = mysqli_fetch_array($querybarang)) {
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $data['nama_produk']; ?></td>
                                    <td><?php echo $data['nama_kategori']; ?></td>
                                    <td>Rp. <?php echo number_format($data['harga']) ?></td>
                                    <td><?php echo $data['stok']; ?></td>
                                    <td>
                                        <a href="produkdetail.php?p=<?php echo $data['id']; ?>" class="btn btn-warning"><i class="fa-solid fa-magnifying-glass"></i></i></a>
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

    <script src=" ../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>
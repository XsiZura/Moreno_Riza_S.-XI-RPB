<?php
require 'session.php';

$produk = mysqli_query($koneksi, "SELECT id, nama_produk, harga, foto, detail FROM produk LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <?php
    require 'navbar.php';
    ?>

    <!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>RenZ Clothing Store</h1>
            <h3>What are you looking for?</h3>
            <div class="col-md-8 offset-md-2">
                <form action="produk.php" method="get">
                    <div class="input-group input-group-lg my-4">
                        <input type="text" class="form-control" placeholder="Search" aria-label="Search"
                            aria-describedby="basic-addon2" name="keyword">
                        <button type="submit" class="btn color2 text-white">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- highlight kategori -->
    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk Terlaris</h3>

            <div class="row mt-5">
                <div class="col-md-4 mb-3">
                    <div class="highlight-kategori kategori-baju-pria d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=baju pria">Baju Pria</a></h4>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="highlight-kategori kategori-baju-wanita d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=baju wanita">Baju Wanita</a></h4>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="highlight-kategori kategori-hoodie d-flex justify-content-center align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=hoodie">Hoodie</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-5">
        <div class="container text-center">
            <h3>Produk</h3>
            <div class="row mt-5">
                <?php while ($data = mysqli_fetch_array($produk)) { ?>
                    <div class="col-sm-6 col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src=" image/<?php echo $data['foto'] ?>" class="card-img-top" alt="">
                            </div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama_produk']; ?></h4>
                            <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                            <p class="card-text text-harga">Rp.<?php echo number_format($data['harga']) ?></p>
                            <a href="p-detail.php?nama=<?php echo $data['nama_produk'] ?>" class="btn color4 text-white">Lihat Detail</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <a href="produk.php" class="btn btn-outline-warning mt-3 p-2 fs-3" role="button">See More</a>
        </div>
    </div>


    <div class="container-fluid color1 py-5">
        <div class="container text-center">
            <h3 class="text-white">About Us</h3>
            <p class="fs-5 mt-3 text-white">
                Ini Sebuah Webstore
            </p>
        </div>
    </div>
                    
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>
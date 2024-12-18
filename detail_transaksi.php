<?php
require 'koneksi.php';

$transaksi_id = $_GET['transaksi_id'];
$query = mysqli_query($koneksi, "SELECT dt.*, p.nama_produk, k.nama AS nama_kategori 
                                 FROM detail_transaksi dt 
                                 JOIN produk p ON dt.produk_id = p.id 
                                 JOIN kategori k ON dt.kategori_id = k.id 
                                 WHERE dt.transaksi_id = '$transaksi_id'");

$transaksiQuery = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id = '$transaksi_id'");
$transaksi = mysqli_fetch_array($transaksiQuery);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container py-5">
        <h2 class="text-center">Detail Transaksi</h2>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Transaksi ID: <?php echo $transaksi['id']; ?></h5>
                <p><strong>Total Harga:</strong> Rp. <?php echo number_format($transaksi['total_harga']); ?></p>
                <p><strong>Metode Pembayaran:</strong> <?php echo $transaksi['metode_pembayaran']; ?></p>

                <!-- Tambahkan Subtotal -->
                <h5 class="mt-4">Detail Barang</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $subtotal = 0; // Inisialisasi subtotal
                        while ($data = mysqli_fetch_array($query)) {
                            $subtotal += $data['harga_total']; // Tambahkan harga total barang ke subtotal
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $data['nama_produk']; ?></td>
                                <td><?php echo $data['nama_kategori']; ?></td>
                                <td><?php echo $data['jumlah']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- Tampilkan Subtotal -->
                <p><strong>Subtotal:</strong> Rp. <?php echo number_format($subtotal); ?></p>

                <a href="keranjang.php" class="btn btn-primary">Kembali ke Keranjang</a>
            </div>
        </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
require 'koneksi.php';

// Ambil data keranjang
$querycart = mysqli_query($koneksi, "SELECT cart.*, produk.nama_produk, kategori.nama AS nama_kategori, produk.harga AS harga_satuan FROM cart JOIN produk ON cart.produk_id = produk.id JOIN kategori ON cart.kategori_id = kategori.id");

$totalHarga = 0;
while ($data = mysqli_fetch_array($querycart)) {
    $totalHarga += $data['harga_satuan'] * $data['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRIS Payment</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container py-5">
        <h2 class="text-center">Pembayaran QRIS</h2>
        <div class="card mt-3">
            <div class="card-body">
                <h5>Detail Barang</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        mysqli_data_seek($querycart, 0);
                        while ($data = mysqli_fetch_array($querycart)) {
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $data['nama_produk']; ?></td>
                                <td><?php echo $data['nama_kategori']; ?></td>
                                <td><?php echo $data['jumlah']; ?></td>
                                <td>Rp. <?php echo number_format($data['harga_satuan'] * $data['jumlah']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <h5 class="text-center mt-4">Total: Rp. <?php echo number_format($totalHarga); ?></h5>

                <!-- QR Code -->
                <div class="text-center">
                    <img src="image/fake_qr.png" alt="QR Code Palsu" width="200">
                    <p>Scan QR untuk menyelesaikan pembayaran.</p>
                </div>
                <a href="keranjang.php" class="btn btn-primary">Kembali ke Keranjang</a>
            </div>
        </div>
    </div>
</body>

</html>
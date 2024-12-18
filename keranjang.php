<?php
require 'koneksi.php';

$querycart = mysqli_query($koneksi, "SELECT cart.*, produk.nama_produk, kategori.nama AS nama_kategori, produk.harga AS harga_satuan FROM cart JOIN produk ON cart.produk_id = produk.id JOIN kategori ON cart.kategori_id = kategori.id");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<style>
    .no-decoration {
        text-decoration: none;
    }

    .qr-container {
        text-align: center;
        margin-top: 30px;
    }
</style>

<body>
    <?php
    require 'navbar.php';
    ?>
    <div class="container-fluid py-5">
        <div class="container mt-5">
            <h2 class="text-center">Keranjang</h2>
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. </th>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $totalHarga = 0;
                        while ($data = mysqli_fetch_array($querycart)) {
                            $hargaTotal = $data['harga_satuan'] * $data['jumlah'];
                            $totalHarga += $hargaTotal;
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $data['nama_kategori']; ?></td>
                                <td><?php echo $data['nama_produk']; ?></td>
                                <td>
                                    <form action="update_keranjang.php" method="post">
                                        <input type="hidden" name="cart_id" value="<?php echo $data['id']; ?>">
                                        <button type="submit" name="kurangi" class="btn btn-danger btn-sm">-</button>
                                        <?php echo $data['jumlah']; ?>
                                        <button type="submit" name="tambah" class="btn btn-success btn-sm">+</button>
                                    </form>
                                </td>
                                <td>Rp. <?php echo number_format($hargaTotal); ?></td>
                                <td>
                                    <form action="hapus_keranjang.php" method="post" style="display: inline;">
                                        <input type="hidden" name="cart_id" value="<?php echo $data['id'] ?>">
                                        <button type="submit" name="hapus" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Total Bayar:</strong></td>
                            <td><strong>Rp. <?php echo number_format($totalHarga); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-grid gap-2">
                    <a href="produk.php" role="button" class="btn btn-warning">Tambah Produk</a>
                    <form action="proses_transaksi.php" method="post">
                        <div class="mb-3">
                            <label for="metodePembayaran" class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metodePembayaran" class="form-select" onchange="toggleNominalInput()">
                                <option value="qris">QRIS</option>
                                <option value="bayar_langsung">Bayar Langsung</option>
                            </select>
                        </div>
                        <div class="mb-3" id="nominalContainer" style="display: none;">
                            <label for="nominal" class="form-label">Nominal Pembayaran</label>
                            <input type="number" name="nominal" id="nominal" class="form-control" placeholder="Masukkan jumlah pembayaran">
                            <small id="nominalHelp" class="form-text text-muted">Pastikan nominal cukup untuk pembayaran</small>
                        </div>
                        <button class="btn btn-primary" type="submit">Bayar</button>
                        <a href="produk.php" role="button" class="btn btn-success">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleNominalInput() {
            const metodePembayaran = document.getElementById("metodePembayaran").value;
            const nominalContainer = document.getElementById("nominalContainer");

            if (metodePembayaran === "bayar_langsung") {
                nominalContainer.style.display = "block";
            } else {
                nominalContainer.style.display = "none";
            }
        }
    </script>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>
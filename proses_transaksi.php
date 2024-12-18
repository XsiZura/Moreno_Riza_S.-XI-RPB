<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $metodePembayaran = $_POST['metode_pembayaran'];

    $querycart = mysqli_query($koneksi, "SELECT cart.*, produk.nama_produk, kategori.nama AS nama_kategori, produk.harga AS harga_satuan FROM cart JOIN produk ON cart.produk_id = produk.id JOIN kategori ON cart.kategori_id = kategori.id");

    $totalHarga = 0;
    while ($data = mysqli_fetch_array($querycart)) {
        $totalHarga += $data['harga_satuan'] * $data['jumlah'];
    }

    if ($metodePembayaran == "qris") {
        header("Location: qr_payment.php"); // Arahkan ke halaman QRIS
        exit();
    } else if ($metodePembayaran == "bayar_langsung") {
        $nominal = $_POST['nominal'];

        if ($nominal < $totalHarga) {
            echo "<script>alert('Nominal pembayaran tidak mencukupi!'); window.history.back();</script>";
        } else {
            $tanggalTransaksi = date("Y-m-d H:i:s");
            $insertTransaksi = mysqli_query($koneksi, "INSERT INTO transaksi (total_harga, metode_pembayaran, tanggal) VALUES ('$totalHarga', '$metodePembayaran', '$tanggalTransaksi')");

            if ($insertTransaksi) {
                $transaksi_id = mysqli_insert_id($koneksi);
                $querycart = mysqli_query($koneksi, "SELECT * FROM cart");
                while ($data = mysqli_fetch_array($querycart)) {
                    $produk_id = $data['produk_id'];
                    $kategori_id = $data['kategori_id'];
                    $jumlah = $data['jumlah'];
                    $hargaSatuan = $data['harga_satuan'];
                    $total = $hargaSatuan * $jumlah;

                    mysqli_query($koneksi, "INSERT INTO detail_transaksi (transaksi_id, produk_id, kategori_id, jumlah, harga_total) VALUES ('$transaksi_id', '$produk_id', '$kategori_id', '$jumlah', '$total')");
                }

                mysqli_query($koneksi, "DELETE FROM cart");

                echo "<script>alert('Transaksi berhasil!'); window.location='detail_transaksi.php?transaksi_id=$transaksi_id';</script>";
            }
        }
    }
}

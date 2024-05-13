<?php
// Penghasilan Penjualan
$queryPenghasilan = mysqli_query(Koneksi(), "SELECT SUM(total_bayar) AS total_penjualan FROM tbl_order");
$dataPenghasilan = mysqli_fetch_assoc($queryPenghasilan);
$totalPenjualan = $dataPenghasilan['total_penjualan'];

// Total Produk
$queryTotalProduk = mysqli_query(Koneksi(), "SELECT COUNT(*) AS total_produk FROM tbl_produk");
$dataTotalProduk = mysqli_fetch_assoc($queryTotalProduk);
$totalProduk = $dataTotalProduk['total_produk'];

// Total Order
$queryTotalOrder = mysqli_query(Koneksi(), "SELECT COUNT(*) AS total_order FROM tbl_order");
$dataTotalOrder = mysqli_fetch_assoc($queryTotalOrder);
$totalOrder = $dataTotalOrder['total_order'];
?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Penghasilan Penjualan</h5>
                <div class="card-body">
                    <h3 class="card-title"><?= "Rp " . number_format($totalPenjualan, 0, ",", ".") ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Total Produk</h5>
                <div class="card-body">
                    <h3 class="card-title"><?= $totalProduk ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Total Order</h5>
                <div class="card-body">
                    <h3 class="card-title"><?= $totalOrder ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
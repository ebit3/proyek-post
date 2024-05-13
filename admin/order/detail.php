<?php
$data_user_login = $_SESSION['info_user'];

if (isset($_GET['id'])) {

    # code...
    $id_order = $_GET['id'];

    $queryOrder = mysqli_query(Koneksi(), "SELECT * FROM tbl_order WHERE id_order = '" . $id_order . "'");
    $dataOrder = showData($queryOrder);

    $queryDetailOrder = mysqli_query(Koneksi(), "SELECT * FROM tbl_detail_order WHERE order_id = '" . $id_order . "'");
    $dataDetailOrder = showData($queryDetailOrder);
}

?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Detail Pesanan</h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary"></div>
                <div class="card-body">
                    <?php foreach ($dataOrder as $row) : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kode Pesanan</label>
                                    <input type="text" name="" class="form-control" id="" value="<?= $row['kode_pesanan'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Total Pesanan</label>
                                    <input type="text" name="" class="form-control" id="" value="<?= number_format($row['total_bayar'], 2, ",", ".") ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jumlah Pembayaran</label>
                                    <input type="text" name="" class="form-control" id="" value="<?= number_format($row['jumlah_bayar'], 2, ',', '.') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Kembalian</label>
                                    <input type="text" name="" class="form-control" id="" value="<?= $row['kembalian'] ?>">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <hr>

                    <div class="card-title mb-4">
                        Detail Pesanan
                    </div>

                    <?php foreach ($dataDetailOrder as $rows) : ?>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $rows['produk'] ?></td>
                                            <td>Rp <?= number_format($rows['harga'], 2, ".", ',') ?></td>
                                            <td><?= $rows['qty'] ?></td>
                                            <td>Rp <?= number_format($rows['total_harga'], 2, '.', ',') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div class="card-footer">
                    <a href="?page=data-penjualan" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
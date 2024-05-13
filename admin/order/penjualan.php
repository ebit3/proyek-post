<?php

$koneksi = koneksi();

$data_user_login = $_SESSION['info_user'];

$query = mysqli_query($koneksi, "SELECT * FROM tbl_order WHERE user_id = '" . $data_user_login['id_user'] . "'");

$data = showData($query);

?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Data Penjualan</h1>

    <?php if (isset($_SESSION['status-kategori']) === true) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>
                <?= isset($_SESSION['pesan-kategori-tambah']) ? $_SESSION['pesan-kategori-tambah'] : '' ?>
                <?= isset($_SESSION['pesan-kategori-hapus']) ? $_SESSION['pesan-kategori-hapus'] : '' ?>
                <?= isset($_SESSION['pesan-kategori-edit']) ? $_SESSION['pesan-kategori-edit'] : '' ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    endif;
    unset($_SESSION['status-kategori']);
    unset($_SESSION['pesan-kategori-tambah']);
    unset($_SESSION['pesan-kategori-hapus']);
    unset($_SESSION['pesan-kategori-edit']);
    ?>

    <div class="card mb-4">
        <div class="card-header bg-primary"></div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Pesanan</th>
                        <th>Total Pesanan</th>
                        <th>Pembayaran</th>
                        <th>Kembalian</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Kode Pesanan</th>
                        <th>Total Pesanan</th>
                        <th>Pembayaran</th>
                        <th>Kembalian</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($data as $no => $row) : ?>
                        <tr>
                            <td><?= $no + 1 ?></td>
                            <td><?= $row['kode_pesanan'] ?></td>
                            <td><?= $row['total_bayar'] ?></td>
                            <td><?= $row['jumlah_bayar'] ?></td>
                            <td><?= $row['kembalian'] ?></td>
                            <td><?= date('H.i d-m-Y', strtotime($row['tgl_pesanan'])) ?></td>
                            <td>
                                <a href="?page=detail-penjualan&&id=<?= $row['id_order'] ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
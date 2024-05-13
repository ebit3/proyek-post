<?php

$koneksi = koneksi();

$data_user_login = $_SESSION['info_user'];

$query = mysqli_query($koneksi, "SELECT * FROM tbl_produk INNER JOIN tbl_kategori ON tbl_produk.kategori_id = tbl_kategori.id_kategori WHERE tbl_produk.user_id = '" . $data_user_login['id_user'] . "'");

$data = showData($query);

?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Produk</h1>

    <?php if (isset($_SESSION['status-produk']) === true) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>
                <?= isset($_SESSION['pesan-produk-tambah']) ? $_SESSION['pesan-produk-tambah'] : '' ?>
                <?= isset($_SESSION['pesan-produk-hapus']) ? $_SESSION['pesan-produk-hapus'] : '' ?>
                <?= isset($_SESSION['pesan-produk-edit']) ? $_SESSION['pesan-produk-edit'] : '' ?>
                <?= isset($_SESSION['pesan-stok-ubah']) ? $_SESSION['pesan-stok-ubah'] : '' ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    endif;
    unset($_SESSION['status-produk']);
    unset($_SESSION['pesan-produk-tambah']);
    unset($_SESSION['pesan-produk-hapus']);
    unset($_SESSION['pesan-produk-edit']);
    unset($_SESSION['pesan-stok-ubah']);
    ?>

    <div class="card mb-4">
        <div class="card-header">
            <a href="?page=produk-tambah" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Data Produk
            </a>
            |
            <a href="?page=stok" class="btn btn-success">
                <i class="fas fa-plus me-1"></i>
                Data Stok
            </a>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Kategori Produk</th>
                        <th>Harga Produk</th>
                        <th>Stok Produk</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Kategori Produk</th>
                        <th>Harga Produk</th>
                        <th>Stok Produk</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($data as $no => $row) : ?>
                        <tr>
                            <td><?= $no + 1 ?></td>
                            <td><?= $row['produk'] ?></td>
                            <td><?= $row['kategori'] ?></td>
                            <td><?= number_format($row['harga'], 2, ',', '.') ?></td>
                            <td><?= $row['stok'] ?></td>
                            <td>
                                <a href="?page=produk-hapus&&id=<?= encryptID($row['id_produk']) ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                                |
                                <a href="?page=produk-edit&&id=<?= encryptID($row['id_produk']) ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-user-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
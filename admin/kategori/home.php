<?php

$koneksi = koneksi();

$data_user_login = $_SESSION['info_user'];

$query = mysqli_query($koneksi, "SELECT * FROM tbl_kategori WHERE user_id = '" . $data_user_login['id_user'] . "'");

$data = showData($query);

?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Kategori</h1>

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
        <div class="card-header">
            <a href="?page=kategori-tambah" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Data Kategori
            </a>
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Kategori</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($data as $no => $row) : ?>
                        <tr>
                            <td><?= $no + 1 ?></td>
                            <td><?= $row['kategori'] ?></td>
                            <td>
                                <a href="?page=kategori-hapus&&id=<?= encryptID($row['id_kategori']) ?>" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                                |
                                <a href="?page=kategori-edit&&id=<?= encryptID($row['id_kategori']) ?>" class="btn btn-warning btn-sm">
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
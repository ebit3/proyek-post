<?php
$data_user_login = $_SESSION['info_user'];


if (isset($_POST['simpan'])) {

    $data = array(
        'user_id' => $_POST['user_id'],
        'kategori' => $_POST['kategori']
    );

    $hasil_kategori = tambahKategori($data);
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Kategori</h1>
    <div class="row">
        <form action="" method="post">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary"></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Masukkan Kategori">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="user_id" id="user_id" class="form-control" value="<?= $data_user_login['id_user'] ?>">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        <a href="?page=kategori" class="btn btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
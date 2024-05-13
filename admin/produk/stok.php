<?php
$data_user_login = $_SESSION['info_user'];

$query = mysqli_query(Koneksi(), "SELECT * FROM tbl_produk WHERE user_id = '" . $data_user_login['id_user'] . "'");

$dataProduk = showData($query);

if (isset($_POST['simpan'])) {

    if (isset($_POST['simpan'])) {

        $data = array(
            'produk_id' => $_POST['produk_id'],
            'jml' => $_POST['jml'],
            'user_id' => $data_user_login['id_user'],
            'opsi' => $_POST['opsi'] // Ambil nilai opsi dari input formulir
        );

        $hasil_stok = UbahStok($data);
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Stok</h1>
    <div class="row">
        <form action="" method="post">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary"></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="Opsi" class="form-label">Opsi</label>
                            <select name="opsi" id="" class="form-select">
                                <option></option>
                                <option value="tambah">Tambah Stok</option>
                                <option value="kurang">Kurang Stok</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="produk" class="form-label">Produk</label>
                            <select name="produk_id" id="" class="form-select">
                                <option></option>
                                <?php foreach ($dataProduk as $data) : ?>
                                    <option value="<?= $data['id_produk'] ?>"><?= $data['produk'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jmlStok" class="form-label">Jumlah Stok</label>
                            <input type="number" name="jml" class="form-control" placeholder="Masukkan jumlah stok ..." id="">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="user_id" id="user_id" class="form-control" value="<?= $data_user_login['id_user'] ?>">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                        <a href="?page=produk" class="btn btn-danger">Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
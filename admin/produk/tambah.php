<?php
$data_user_login = $_SESSION['info_user'];

$query = mysqli_query(Koneksi(), "SELECT * FROM tbl_kategori WHERE user_id = '" . $data_user_login['id_user'] . "'");

$dataKategori = showData($query);

if (isset($_POST['simpan'])) {

    $data = array(
        'kategori_id' => $_POST['kategori_id'],
        'user_id' => $_POST['user_id'],
        'produk' => $_POST['produk'],
        'harga' => $_POST['harga'],
        'stok' => $_POST['stok'],
    );

    $hasil_produk = tambahProduk($data);
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Produk</h1>
    <div class="row">
        <form action="" method="post">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary"></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select name="kategori_id" id="" class="form-select">
                                        <option></option>
                                        <?php foreach ($dataKategori as $row) : ?>
                                            <option value="<?= $row['id_kategori'] ?>"><?= $row['kategori'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="produk" class="form-label">Produk</label>
                                    <input type="text" name="produk" id="produk" class="form-control" placeholder="Masukkan produk">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control" placeholder="Masukkan harga">
                                </div>
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" name="stok" id="stok" class="form-control" placeholder="Masukkan stok">
                                </div>
                            </div>
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
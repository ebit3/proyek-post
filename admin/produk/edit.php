<?php
$data_user_login = $_SESSION['info_user'];

$query = mysqli_query(Koneksi(), "SELECT * FROM tbl_kategori WHERE user_id = '" . $data_user_login['id_user'] . "'");

$dataKategori = showData($query);

// Pastikan ada parameter ID pada URL
if (isset($_GET['id'])) {

    $id_produk = decryptID($_GET['id']);

    // Memeriksa apakah data produk tersedia
    $data = showDataIdProduk($id_produk);

    $a = mysqli_query(Koneksi(), "SELECT * FROM tbl_kategori WHERE id_kategori = '" . $data['kategori_id'] . "'");
    $b = mysqli_fetch_assoc($a);

    // Jika data produk tidak ditemukan, tampilkan pesan error
    if (!$data) {
        echo "<script>alert('Data tidak ditemukan')</script>";
        exit;
    }

    // Memproses form jika ada pengiriman data
    if (isset($_POST['simpan'])) {

        // // Ambil data dari formulir yang dikirimkan
        // $produk = isset($_POST['id_produk']) ? $_POST['id_produk'] : '';

        // Ubah data produk
        $data_produk = array(
            'kategori_id' => $_POST['kategori_id'],
            'user_id' => $_POST['user_id'],
            'produk' => $_POST['produk'],
            'harga' => $_POST['harga'],
            'stok' => $_POST['stok'],
        );

        $hasil_produk = editproduk($id_produk, $data_produk);

        // Periksa hasil proses edit produk
        if ($hasil_produk === true) {
            // Redirect kembali ke halaman produk
            header("Location: ?page=produk");
            exit;
        } else {
            // Tampilkan pesan kesalahan jika terjadi kesalahan saat mengedit
            echo "<script>alert('Edit produk Gagal')</script>" . $hasil_produk;
        }
    }
} else {
    // Jika tidak ada parameter ID pada URL, tampilkan pesan error
    echo "<script>alert('Data Tidak ditemukan')</script>";
    exit;
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
                                        <option value="<?= $data['kategori_id'] ?>"><?= $b['kategori'] ?></option>
                                        <?php foreach ($dataKategori as $row) : ?>
                                            <option value="<?= $row['id_kategori'] ?>"><?= $row['kategori'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="produk" class="form-label">Produk</label>
                                    <input type="text" name="produk" id="produk" class="form-control" placeholder="Masukkan produk" value="<?= $data['produk'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control" placeholder="Masukkan harga" value="<?= $data['harga'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" name="stok" id="stok" class="form-control" placeholder="Masukkan stok" value="<?= $data['stok'] ?>">
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
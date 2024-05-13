<?php

$data_user_login = $_SESSION['info_user'];

// Pastikan ada parameter ID pada URL
if (isset($_GET['id'])) {

    $id_kategori = decryptID($_GET['id']);

    // Memeriksa apakah data kategori tersedia
    $data = showDataIdKategori($id_kategori);

    // Jika data kategori tidak ditemukan, tampilkan pesan error
    if (!$data) {
        echo "<script>alert('Data tidak ditemukan')</script>";
        exit;
    }

    // Memproses form jika ada pengiriman data
    if (isset($_POST['simpan'])) {
        // Ambil data dari formulir yang dikirimkan
        $kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '';

        // Ubah data kategori
        $data_kategori = array(
            'kategori' => $kategori
        );

        $hasil_kategori = editKategori($id_kategori, $data_kategori);

        // Periksa hasil proses edit kategori
        if ($hasil_kategori === true) {
            // Redirect kembali ke halaman kategori
            header("Location: ?page=kategori");
            exit;
        } else {
            // Tampilkan pesan kesalahan jika terjadi kesalahan saat mengedit
            echo "<script>alert('Edit Kategori Gagal')</script>" . $hasil_kategori;
        }
    }
} else {
    // Jika tidak ada parameter ID pada URL, tampilkan pesan error
    echo "<script>alert('Data Tidak ditemukan')</script>";
    exit;
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
                            <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Masukkan Kategori" value="<?= $data['kategori'] ?>">
                        </div>
                        <div class="mb-3">
                            <input type="hidden" name="user_id" id="user_id" class="form-control" value="<?= $data_user_login['id_user'] ?>">
                            <input type="hidden" name="kategori_id" id="kategori_id" class="form-control" value="<?= $data['id_kategori'] ?>">
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
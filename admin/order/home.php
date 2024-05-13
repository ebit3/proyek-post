<?php

// Tangkap parameter pesan dari URL
$pesan = isset($_GET['pesan']) ? $_GET['pesan'] : '';

// Tampilkan pesan jika ada
if (!empty($pesan)) {
    echo "<script>alert('$pesan')</script>";
}

$koneksi = koneksi();

$data_user_login = $_SESSION['info_user'];

$query = mysqli_query($koneksi, "SELECT * FROM tbl_produk WHERE user_id = '" . $data_user_login['id_user'] . "'");

$data = showData($query);

// Inisialisasi session untuk keranjang belanja dan barang yang sudah dipesan
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = array(); // Array untuk menyimpan ID produk yang ada di keranjang belanja
}

if (!isset($_SESSION['barang_dipesan'])) {
    $_SESSION['barang_dipesan'] = array(); // Array untuk menyimpan informasi barang yang sudah dipesan
}

// Jika tombol "Tambah ke Keranjang" ditekan
if (isset($_POST['tambah_ke_keranjang'])) {
    // Ambil ID produk dari formulir
    $produk_id = $_POST['id_produk'];

    // Ambil jumlah qty dari formulir
    $qty = $_POST['qty'];

    // Periksa apakah produk sudah ada dalam keranjang belanja
    if (!in_array($produk_id, $_SESSION['keranjang'])) {
        // Tambahkan ID produk ke dalam keranjang belanja
        $_SESSION['keranjang'][] = $produk_id;

        // Ambil informasi produk dari database berdasarkan ID produk
        $produk_info = showDataIdProduk($produk_id); // Fungsi untuk mengambil informasi produk dari database

        // Simpan informasi produk beserta qty ke dalam session
        $produk_info['qty'] = $qty;
        $_SESSION['barang_dipesan'][] = $produk_info; // Simpan informasi produk ke dalam session
    }
}

// Jika tombol "Hapus" ditekan
if (isset($_POST['hapus_barang'])) {
    // Ambil index barang yang akan dihapus
    $index = $_POST['index_barang'];

    // Hapus barang dari session berdasarkan index
    unset($_SESSION['barang_dipesan'][$index]);
    unset($_SESSION['keranjang'][$index]);
}

// Jika tombol "Selesai Pesan" ditekan
if (isset($_POST['selesai_pesan'])) {

    // Simpan data pesanan ke dalam tabel tbl_order    
    $total_pembayaran = $_POST['total_bayar'];
    $id_user = $data_user_login['id_user']; // Ambil ID pengguna dari session
    $total_bayar = $_POST['bayar']; // Ambil nilai total_bayar dari formulir
    $kembalian = $_POST['kembalian'];

    if ($total_bayar < $total_pembayaran) {
        // Redirect dengan membawa pesan dalam parameter URL
        header("Location: ?page=penjualan&pesan=Uang Tidak Cukup");
        exit();
    }

    // Generate kode pesanan acak
    $kode_pesanan = generateRandomString(5);

    // Loop untuk setiap barang yang dipesan
    foreach ($_SESSION['barang_dipesan'] as $produk) {
        // Ambil informasi produk dari database
        $id_produk = $produk['id_produk'];
        $qty = $produk['qty'];

        // Cek apakah stok mencukupi
        $query_produk = mysqli_query($koneksi, "SELECT stok FROM tbl_produk WHERE id_produk = '$id_produk'");
        $data_produk = mysqli_fetch_assoc($query_produk);
        $stok = $data_produk['stok'];

        if ($qty > $stok) {
            // Redirect dengan membawa pesan dalam parameter URL
            header("Location: ?page=penjualan&pesan=Stok Produk Tidak Mencukupi");
            exit();
        }

        // Kurangi stok produk
        $sisa_stok = $stok - $qty;
        $update_stok = mysqli_query($koneksi, "UPDATE tbl_produk SET stok = '$sisa_stok' WHERE id_produk = '$id_produk'");
        if (!$update_stok) {

            // Handle kesalahan jika gagal mengupdate stok
            echo "gagal melakukan perubahan";
        }
    }

    $query_order = "INSERT INTO tbl_order (user_id, kode_pesanan, total_bayar, jumlah_bayar, kembalian, tgl_pesanan) VALUES ('$id_user', '$kode_pesanan', '$total_pembayaran', '$total_bayar', '$kembalian', NOW())";
    mysqli_query($koneksi, $query_order);
    $id_order = mysqli_insert_id($koneksi);

    // Simpan detail pesanan ke dalam tabel tbl_detail_order
    foreach ($_SESSION['barang_dipesan'] as $produk) {
        $id_produk = $produk['id_produk'];
        $harga = $produk['harga'];
        $nama_produk = $produk['produk'];
        $qty = $produk['qty'];
        $subtotal = $produk['harga'] * $produk['qty'];

        $query_detail_order = "INSERT INTO tbl_detail_order (user_id, order_id, produk_id, produk, harga, qty, total_harga) VALUES ('$id_user', '$id_order', '$id_produk', '$nama_produk', '$harga', '$qty', '$subtotal')";
        mysqli_query($koneksi, $query_detail_order);
    }

    // Kosongkan session setelah pesanan selesai
    $_SESSION['keranjang'] = array();
    $_SESSION['barang_dipesan'] = array();

    // Redirect atau lakukan tindakan lain setelah pesanan selesai
    $_SESSION['status-order'] = true;
    $_SESSION['pesan-order-tambah'] = "Order Berhasil Silahkan Lanjutkan Orderan Berikutnya";

    header("Location: ?page=penjualan");
    exit();
}


?>

<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4">Pesanan</h1>

    <?php if (isset($_SESSION['status-order']) === true) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>
                <?= isset($_SESSION['pesan-order-tambah']) ? $_SESSION['pesan-order-tambah'] : '' ?>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    endif;
    unset($_SESSION['status-order']);
    unset($_SESSION['pesan-order-tambah']);
    ?>

    <div class="card mb-4">
        <div class="card-header bg-primary">
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $no => $row) : ?>
                        <tr>
                            <td><?= $no + 1 ?></td>
                            <td><?= $row['produk'] ?></td>
                            <td><?= $row['stok'] ?></td>
                            <td><?= number_format($row['harga'], 2, ",", ".") ?></td>
                            <td>
                                <form action="" method="post">
                                    <?php
                                    // Periksa apakah produk sudah ada di keranjang belanja
                                    $disabled = in_array($row['id_produk'], $_SESSION['keranjang']) ? "disabled" : "";
                                    ?>
                                    <div class="row g-3 align-items-center">
                                        <div class="col">
                                            <input type="number" name="qty" class="form-control" value="1" min="1">
                                        </div>
                                        <div class="col">
                                            <button type="submit" name="tambah_ke_keranjang" class="btn btn-primary" <?= $disabled ?>>
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id_produk" value="<?= $row['id_produk'] ?>">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tampilan keranjang belanja -->
    <div class="card mb-4">
        <div class="card-body">
            <h3>Keranjang Belanja</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalBayar = 0;
                    foreach ($_SESSION['barang_dipesan'] as $index => $produk) {
                        $subtotal = $produk['harga'] * $produk['qty'];
                        $totalBayar += $subtotal;
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $produk['produk'] ?></td>
                            <td><?= number_format($produk['harga'], 2, ",", ".") ?></td>
                            <td><?= $produk['qty'] ?></td>
                            <td><?= number_format($subtotal, 2, ",", ".") ?></td>
                            <td>
                                <form action="" method="post">
                                    <button type="submit" name="hapus_barang" value="<?= $index ?>" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <!-- hidden item -->
                                    <input type="hidden" name="index_barang" value="<?= $index ?>">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" class="text-end">Total Bayar:</td>
                        <td><?= number_format($totalBayar, 2, ",", ".") ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title mb-3">
                <h3>Total Bayar : <?= number_format($totalBayar, 2, ",", ".") ?></h3>
            </div>
            <form action="" method="post">
                <div class="mb-3 row">
                    <label for="inputBayar" class="col-sm-2 col-form-label">Bayar</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="inputBayar" name="bayar">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="staticKembalian" class="col-sm-2 col-form-label">Kembalian</label>
                    <div class="col-sm-10">
                        <input type="text" name="kembalian" readonly class="form-control-plaintext" id="staticKembalian">
                    </div>
                </div>

                <!-- hidden item -->
                <input type="hidden" name="total_bayar" id="" value="<?= $totalBayar ?>">

                <button type="submit" name="selesai_pesan" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Ambil elemen input bayar dan kembalian
    const inputBayar = document.getElementById('inputBayar');
    const inputKembalian = document.getElementById('staticKembalian');

    // Fungsi untuk mengubah format angka menjadi format Rupiah Indonesia
    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + ribuan;
    }

    // Hitung kembalian ketika nilai input bayar berubah
    inputBayar.addEventListener('input', function() {
        // Ambil nilai total bayar dari PHP
        const totalBayar = <?= $totalBayar ?>;

        // Ambil nilai yang dimasukkan pengguna untuk bayar
        const bayar = parseFloat(inputBayar.value);

        // Hitung kembalian
        const kembalian = bayar - totalBayar;

        // Tampilkan kembalian dengan format Rupiah
        inputKembalian.value = formatRupiah(kembalian);

        // Jika kembalian kurang dari atau sama dengan 0, tampilkan pesan "Tidak Ada Kembalian"
        if (kembalian <= 0) {
            inputKembalian.value = "Tidak Ada Kembalian";
        }
    });
</script>
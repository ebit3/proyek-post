<?php

session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dbn_post');

function Koneksi()
{
    // Membuat koneksi ke database
    $koneksi = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Memeriksa apakah koneksi berhasil atau tidak
    if (!$koneksi) {
        throw new Exception("Koneksi ke database gagal: " . mysqli_connect_error());
    }

    // Mengatur karakter set koneksi
    mysqli_set_charset($koneksi, 'utf8');

    return $koneksi;
}

// registrasi
function Register($data)
{
    $koneksi = Koneksi();

    $name = isset($data['name']) ? mysqli_real_escape_string($koneksi, $data['name']) : '';
    $email = isset($data['email']) ? mysqli_real_escape_string($koneksi, $data['email']) : '';
    $password = isset($data['password']) ? password_hash($data['password'], PASSWORD_DEFAULT) : '';

    // Memastikan data yang diperlukan diisi
    if (empty($name) || empty($email) || empty($password)) {

        return "Semua kolom harus diisi";
    }

    // Membuat dan mengeksekusi prepared statement
    $query = mysqli_prepare($koneksi, "INSERT INTO tbl_users (name, email, password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($query, 'sss', $name, $email, $password);
    $result = mysqli_stmt_execute($query);

    // Memeriksa apakah query berhasil dieksekusi
    if ($result) {

        return header("Location: login.php");
    } else {

        return "Gagal melakukan registrasi: " . mysqli_error($koneksi);
    }
}

// login
function Login($email, $password)
{
    $koneksi = Koneksi();

    // Mencegah serangan SQL Injection dengan menggunakan mysqli_real_escape_string
    $email = mysqli_real_escape_string($koneksi, $email);

    // Mencari pengguna dengan email yang cocok
    $query = mysqli_prepare($koneksi, "SELECT * FROM tbl_users WHERE email = ?");
    mysqli_stmt_bind_param($query, 's', $email);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    // Memeriksa apakah pengguna ditemukan
    if (mysqli_num_rows($result) === 1) {
        // Memeriksa kecocokan password
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Jika password cocok, kembalikan data pengguna
            return $user;
        } else {
            // Jika password tidak cocok, kembalikan pesan kesalahan
            return "Password salah";
        }
    } else {
        // Jika tidak ada pengguna dengan email yang cocok, kembalikan pesan kesalahan
        return "Email tidak ditemukan";
    }
}

function showData($query)
{
    $koneksi = koneksi(); // Anda mungkin perlu mengubah ini sesuai dengan fungsi koneksi Anda

    $data = [];

    // Periksa apakah koneksi berhasil
    if (!$koneksi) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    // Pastikan $query adalah objek hasil dari mysqli_query
    if (!$query) {
        die("Error: " . mysqli_error($koneksi));
    }

    // Loop melalui setiap baris hasil query dan tambahkan ke dalam array $data
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = $row;
    }

    // Bebaskan memori dari hasil query
    mysqli_free_result($query);

    // Tutup koneksi database
    mysqli_close($koneksi);

    return $data;
}

// Fungsi untuk mengenkripsi ID
function encryptID($id)
{
    $key = 'secret_key'; // Kunci enkripsi (pastikan kunci ini aman)
    $cipher = 'aes-256-cbc'; // Algoritma enkripsi

    // Buat IV secara acak dengan panjang 16 byte
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($iv_length);

    // Mengenkripsi ID menggunakan OpenSSL dengan IV
    $encrypted = openssl_encrypt($id, $cipher, $key, 0, $iv);
    if ($encrypted === false) {
        // Penanganan kesalahan jika enkripsi gagal
        throw new Exception("<script>alert('Gagal melakukan enkripsi ID coba lagi')</script>");
    }

    // Menggabungkan IV dengan data terenkripsi dan diencode dengan base64 agar aman untuk disimpan
    $combined = $iv . $encrypted;
    $encoded = base64_encode($combined);
    return urlencode($encoded);
}

// Fungsi untuk mendekripsi ID
function decryptID($encrypted)
{
    $key = 'secret_key'; // Kunci enkripsi (sama dengan kunci yang digunakan untuk enkripsi)
    $cipher = 'aes-256-cbc'; // Algoritma enkripsi

    // Mendekodekan string yang dienkripsi dari base64
    $decoded = base64_decode(urldecode($encrypted));
    if ($decoded === false) {
        // Penanganan kesalahan jika dekode base64 gagal
        throw new Exception("<script>alert('Gagal melakukan enkripsi ID coba lagi')</script>");
    }

    // Mendapatkan IV dari awal string
    $iv_length = openssl_cipher_iv_length($cipher);
    $iv = substr($decoded, 0, $iv_length);
    $data = substr($decoded, $iv_length);

    // Mendekripsi data menggunakan OpenSSL dengan IV
    $decrypted = openssl_decrypt($data, $cipher, $key, 0, $iv);
    if ($decrypted === false) {
        // Penanganan kesalahan jika dekripsi gagal
        throw new Exception("<script>alert('Gagal melakukan enkripsi ID coba lagi')</script>");
    }

    return $decrypted;
}

// Fungsi untuk menghasilkan karakter acak
function generateRandomString($length = 5)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// kategori
function tambahKategori($data)
{
    $koneksi = Koneksi();
    // Memvalidasi data yang diterima
    $user_id = isset($data['user_id']) ? mysqli_real_escape_string($koneksi, $data['user_id']) : '';
    $kategori = isset($data['kategori']) ? mysqli_real_escape_string($koneksi, strtolower($data['kategori'])) : '';

    // Memastikan data yang diperlukan diisi
    if (empty($kategori) || empty($user_id)) {

        return "Semua kolom harus diisi";
    }

    // Membuat dan mengeksekusi prepared statement
    $query = mysqli_prepare($koneksi, "INSERT INTO tbl_kategori (user_id, kategori) VALUES (?, ?)");
    mysqli_stmt_bind_param($query, 'ss', $user_id, $kategori);
    $result = mysqli_stmt_execute($query);

    // Memeriksa apakah query berhasil dieksekusi
    if ($result) {
        $_SESSION['status-kategori'] = true;
        $_SESSION['pesan-kategori-tambah'] = "Tambah Data Berhasil";
        header("Location: ?page=kategori");
        exit();
    } else {
        return "Tambah Data Gagal " . mysqli_error($koneksi);
    }
}

function showDataIdKategori($id)
{
    $koneksi = koneksi();

    // Lindungi ID dari serangan SQL Injection
    $id = mysqli_real_escape_string($koneksi, $id);

    // Buat query untuk menampilkan data berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_kategori WHERE id_kategori = '$id'");

    // Periksa apakah query berhasil dieksekusi
    if ($query) {
        // Ambil data dari hasil query
        $data = mysqli_fetch_assoc($query);
        return $data; // Kembalikan data yang ditemukan
    } else {
        return "Gagal menampilkan data: " . mysqli_error($koneksi);
    }
}

function editKategori($id, $data)
{
    $koneksi = koneksi();

    // Mendapatkan nilai data yang akan diubah
    $kategori = isset($data['kategori']) ? mysqli_real_escape_string($koneksi, $data['kategori']) : '';

    // Memastikan data yang diperlukan diisi
    if (empty($kategori)) {

        return "Semua kolom harus diisi";
    }

    // Membuat dan mengeksekusi prepared statement untuk mengubah data kategori
    $query = mysqli_prepare($koneksi, "UPDATE tbl_kategori SET kategori = ? WHERE id_kategori = ?");
    mysqli_stmt_bind_param($query, 'si', $kategori, $id);
    $result = mysqli_stmt_execute($query);

    // Memeriksa apakah query berhasil dieksekusi
    if ($result) {
        $_SESSION['status-kategori'] = true;
        $_SESSION['pesan-kategori-edit'] = "Ubah Data Berhasil";
        return true;
    } else {
        return "Gagal mengubah data kategori: " . mysqli_error($koneksi);
    }
}

function hapusKategori($id)
{
    $koneksi = koneksi();

    // Membuat prepared statement untuk menghapus data kategori berdasarkan ID
    $query = mysqli_prepare($koneksi, "DELETE FROM tbl_kategori WHERE id_kategori = ?");

    // Bind parameter ID ke prepared statement
    mysqli_stmt_bind_param($query, 'i', $id);

    // Eksekusi prepared statement
    $result = mysqli_stmt_execute($query);

    // Memeriksa apakah query berhasil dieksekusi
    if ($result) {
        $_SESSION['status-kategori'] = true;
        $_SESSION['pesan-kategori-hapus'] = "Hapus Data Berhasil";
        header("Location: ?page=kategori");
        exit();
    } else {
        return "Hapus kategori gagal: " . mysqli_error($koneksi);
    }
}

// produk
function showDataIdProduk($id)
{
    $koneksi = koneksi();

    // Lindungi ID dari serangan SQL Injection
    $id = mysqli_real_escape_string($koneksi, $id);

    // Buat query untuk menampilkan data berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM tbl_produk WHERE id_produk = '$id'");

    // Periksa apakah query berhasil dieksekusi
    if ($query) {
        // Ambil data dari hasil query
        $data = mysqli_fetch_assoc($query);
        return $data; // Kembalikan data yang ditemukan
    } else {
        return "Gagal menampilkan data: " . mysqli_error($koneksi);
    }
}

function tambahProduk($data)
{
    $koneksi = Koneksi();
    // Memvalidasi data yang diterima
    $user_id = isset($data['user_id']) ? mysqli_real_escape_string($koneksi, $data['user_id']) : '';
    $kategori = isset($data['kategori_id']) ? mysqli_real_escape_string($koneksi, strtolower($data['kategori_id'])) : '';
    $produk = isset($data['produk']) ? mysqli_real_escape_string($koneksi, strtolower($data['produk'])) : '';
    $harga = isset($data['harga']) ? mysqli_real_escape_string($koneksi, strtolower($data['harga'])) : '';
    $stok = isset($data['stok']) ? mysqli_real_escape_string($koneksi, strtolower($data['stok'])) : '';

    // Memastikan data yang diperlukan diisi
    if (empty($kategori) || empty($user_id) || empty($produk) || empty($harga) || empty($stok)) {

        return "Semua kolom harus diisi";
    }

    // Membuat dan mengeksekusi prepared statement
    $query = mysqli_prepare($koneksi, "INSERT INTO tbl_produk (kategori_id, user_id, produk, harga, stok) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($query, 'sssss', $kategori, $user_id, $produk, $harga, $stok);
    $result = mysqli_stmt_execute($query);

    // Memeriksa apakah query berhasil dieksekusi
    if ($result) {
        $_SESSION['status-produk'] = true;
        $_SESSION['pesan-produk-tambah'] = "Tambah Data Berhasil";
        header("Location: ?page=produk");
        exit();
    } else {
        return "Tambah Data Gagal " . mysqli_error($koneksi);
    }
}

function hapusProduk($id)
{
    $koneksi = koneksi();

    // Membuat prepared statement untuk menghapus data kategori berdasarkan ID
    $query = mysqli_prepare($koneksi, "DELETE FROM tbl_produk WHERE id_produk = ?");

    // Bind parameter ID ke prepared statement
    mysqli_stmt_bind_param($query, 'i', $id);

    // Eksekusi prepared statement
    $result = mysqli_stmt_execute($query);

    // Memeriksa apakah query berhasil dieksekusi
    if ($result) {
        $_SESSION['status-produk'] = true;
        $_SESSION['pesan-produk-hapus'] = "Hapus Data Berhasil";
        header("Location: ?page=produk");
        exit();
    } else {
        return "Hapus produk gagal: " . mysqli_error($koneksi);
    }
}

function editProduk($id, $data)
{
    $koneksi = koneksi();

    // Mendapatkan nilai data yang akan diubah
    $kategori_id = isset($data['kategori_id']) ? mysqli_real_escape_string($koneksi, $data['kategori_id']) : '';
    $produk = isset($data['produk']) ? mysqli_real_escape_string($koneksi, $data['produk']) : '';
    $harga = isset($data['harga']) ? mysqli_real_escape_string($koneksi, $data['harga']) : '';
    $stok = isset($data['stok']) ? mysqli_real_escape_string($koneksi, $data['stok']) : '';
    $user_id = $data['user_id'];

    // Memastikan data yang diperlukan diisi
    if (empty($kategori_id) || empty($produk) || empty($harga) || empty($stok)) {
        return "Semua kolom harus diisi";
    }

    // Membuat dan mengeksekusi prepared statement untuk mengubah data produk
    $query = mysqli_prepare($koneksi, "UPDATE tbl_produk SET kategori_id = ?, user_id = ?,  produk = ?, harga = ?, stok = ? WHERE id_produk = ?");
    mysqli_stmt_bind_param($query, 'sisiii', $kategori_id, $user_id, $produk, $harga, $stok, $id);
    $result = mysqli_stmt_execute($query);

    // Memeriksa apakah query berhasil dieksekusi
    if ($result) {
        $_SESSION['status-produk'] = true;
        $_SESSION['pesan-produk-edit'] = "Ubah Data Berhasil";
        return true;
    } else {
        return "Gagal mengubah data produk: " . mysqli_error($koneksi);
    }
}

function UbahStok($data)
{
    $koneksi = Koneksi();
    $produk_id = $data['produk_id'];
    $opsi = $data['opsi'];
    $jmlStok = $data['jml'];

    // Memastikan data yang diperlukan diisi
    if (empty($jmlStok)) {
        return "Semua kolom harus diisi";
    }

    // ambil data stok saat ini
    $queryStok = mysqli_query($koneksi, "SELECT stok FROM tbl_produk WHERE id_produk = '$produk_id'");
    $dataStok = mysqli_fetch_assoc($queryStok)['stok'];

    // Cek operasi yang diminta
    if ($opsi === "kurang") {
        // Pastikan stok cukup untuk dikurangi
        if ($dataStok < $jmlStok) {
            return "Stok tidak mencukupi";
        }
        $dataStok -= $jmlStok;
    } elseif ($opsi === "tambah") {
        // Tambahkan stok
        $dataStok += $jmlStok;
    } else {
        return "Opsi tidak valid";
    }

    // Perbarui stok dalam database
    $update_stok = mysqli_query($koneksi, "UPDATE tbl_produk SET stok = '$dataStok' WHERE id_produk = '$produk_id'");

    if ($update_stok) {

        $_SESSION['status-produk'] = true;
        $_SESSION['pesan-stok-ubah'] = "Stok Berhasil Di$opsi";
        header("Location: ?page=produk");
        exit();
    } else {

        return "Gagal mengubah data produk: " . mysqli_error($koneksi);
    }
}

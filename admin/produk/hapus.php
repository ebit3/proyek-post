<?php

if (isset($_GET['id'])) {
    $id_produk = decryptID($_GET['id']);

    if ($id_produk !== false) {

        $hasil_delete = hapusProduk($id_produk);
    } else {

        // Tindakan jika dekripsi gagal
        echo "ID tidak valid.";
    }
} else {
    // Tindakan jika parameter 'id' tidak ditemukan dalam URL
    echo "Parameter 'id' tidak ditemukan dalam URL.";
}

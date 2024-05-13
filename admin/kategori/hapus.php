<?php

if (isset($_GET['id'])) {
    $id_kategori = decryptID($_GET['id']);

    if ($id_kategori !== false) {

        $hasil_delete = hapusKategori($id_kategori);
    } else {
        
        // Tindakan jika dekripsi gagal
        echo "ID tidak valid.";
    }
} else {
    // Tindakan jika parameter 'id' tidak ditemukan dalam URL
    echo "Parameter 'id' tidak ditemukan dalam URL.";
}

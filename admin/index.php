<?php include '../include/header.php'; ?>

<div id="layoutSidenav_content">
    <main>
        <?php

        // Mendapatkan URL saat ini
        $url = $_SERVER['REQUEST_URI'];

        $page = isset($_GET['page']) ? $_GET['page'] : '';

        switch ($page) {
            case 'dashboard':
                require_once 'dashboard/home.php';
                break;
            case 'kategori':
                require_once 'kategori/home.php';
                break;
            case 'kategori-tambah':
                require_once 'kategori/tambah.php';
                break;
            case 'kategori-hapus':
                require_once 'kategori/hapus.php';
                break;
            case 'kategori-edit':
                require_once 'kategori/edit.php';
                break;
            case 'produk':
                require_once 'produk/home.php';
                break;
            case 'produk-tambah':
                require_once 'produk/tambah.php';
                break;
            case 'produk-hapus':
                require_once 'produk/hapus.php';
                break;
            case 'produk-edit':
                require_once 'produk/edit.php';
                break;
            case 'stok':
                require_once 'produk/stok.php';
                break;
            case 'penjualan':
                require_once 'order/home.php';
                break;
            case 'data-penjualan':
                require_once 'order/penjualan.php';
                break;
            case 'detail-penjualan':
                require_once 'order/detail.php';
                break;
            case 'logout':
                require_once 'logout/logout.php';
                break;
            default:
                require_once 'dashboard/home.php';
        }

        ?>
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Kasir Dinamis 2029</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php include '../include/footer.php' ?>
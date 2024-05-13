<?php

include '../config/config.php';
ob_start();

if (!isset($_SESSION['status_login']) === true) {

    # code...
    header('Location: ../auth/login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Kasir Dinamis</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="?page=dashboard">Kasir Dinamis</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="?page=dashboard">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Data Master</div>
                        <a class="nav-link" href="?page=kategori">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Kategori
                        </a>
                        <a class="nav-link" href="?page=produk">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Produk
                        </a>
                        <div class="sb-sidenav-menu-heading">Data Transaksi</div>
                        <a class="nav-link" href="?page=penjualan">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Penjualan
                        </a>
                        <a class="nav-link" href="?page=data-penjualan">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Data Penjualan
                        </a>
                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link" href="?page=logout">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>
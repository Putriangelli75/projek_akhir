<?php

session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>Dashboard Pelanggan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body style="background:#f4f6f9;">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow">

    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="#">

            <img
                src="../assets/img/logo-jakabaring.png"
                alt="Logo Jakabaring"
                width="50"
                height="50"
                class="me-2">

            <div>

                <strong>Jakabaring Sport Center</strong>

                <br>

                <small style="font-size:12px;">
                    Sistem Pemesanan Lapangan
                </small>

            </div>

        </a>

        <div>

            <span class="text-white me-3">

                Selamat Datang,
                <strong><?= $_SESSION['nama']; ?></strong>

            </span>

            <a href="../auth/logout.php"
               class="btn btn-danger btn-sm">

                Logout

            </a>

        </div>

    </div>

</nav>

<!-- Isi Dashboard -->
<div class="container mt-4">

    <div class="text-center mb-4">

        <img
            src="../assets/img/logo-jakabaring.png"
            alt="Logo Jakabaring"
            width="120"
            class="mb-3">

        <h2>Dashboard Pelanggan</h2>

        <p class="text-muted">

            Selamat datang di Sistem Pemesanan Lapangan
            Jakabaring Sport Center

        </p>

    </div>

    <div class="row">

        <!-- Booking -->
        <div class="col-md-4 mb-3">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <h5>Buat Booking</h5>

                    <p>

                        Pesan lapangan olahraga sesuai jadwal yang tersedia.

                    </p>

                    <a href="booking.php"
                       class="btn btn-primary">

                        Booking Sekarang

                    </a>

                </div>

            </div>

        </div>

        <!-- Riwayat -->
        <div class="col-md-4 mb-3">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <h5>Riwayat Booking</h5>

                    <p>

                        Lihat seluruh riwayat booking yang pernah dilakukan.

                    </p>

                    <a href="riwayat.php"
                       class="btn btn-success">

                        Lihat Riwayat

                    </a>

                </div>

            </div>

        </div>

        <!-- Pembayaran -->
        <div class="col-md-4 mb-3">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <h5>Pembayaran</h5>

                    <p>

                        Upload bukti pembayaran booking lapangan.

                    </p>

                    <a href="pembayaran.php"
                       class="btn btn-warning">

                        Upload Pembayaran

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>
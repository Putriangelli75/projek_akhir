<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';
if (!isset($conn) && isset($koneksi)) {
    $conn = $koneksi;
} elseif (!isset($conn)) {
    die('Database connection not established.');
}
$totalUser = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM users WHERE role='pelanggan'")
);

$totalLapangan = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM lapangan")
);

$totalBooking = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM booking")
);

$totalPendapatan = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT SUM(total_harga) as total
         FROM booking
         WHERE status='Lunas'"
    )
);

$pendapatan = $totalPendapatan['total'];

if ($pendapatan == "") {
    $pendapatan = 0;
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Dashboard Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background:#f4f6f9;">

    <nav class="navbar navbar-dark bg-success">

        <div class="hero-banner">
            <img src="../assets/img/header-admin.jpg" alt="Jakabaring Sport Center">

            <div class="hero-overlay">
                <h1>Dashboard Admin</h1>
                <p>Sistem Pemesanan Lapangan</p>
                <p>Jakabaring Sport Center</p>
            </div>
        </div>
        <div class="container">

            <span class="navbar-brand">

                Jakabaring Sport Center

            </span>

            <div>

                <span class="text-white me-3">

                    <?= $_SESSION['nama']; ?>

                </span>

                <a href="../auth/logout.php"
                    class="btn btn-light btn-sm">

                    Logout

                </a>

            </div>

        </div>

    </nav>

    <div class="container mt-4">

        <h2 class="mb-4">

            Dashboard Admin

        </h2>

        <div class="row">

            <div class="col-md-3">

                <div class="card shadow">

                    <div class="card-body">

                        <h5>Total Pelanggan</h5>

                        <h2>

                            <?= $totalUser; ?>

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card shadow">

                    <div class="card-body">

                        <h5>Total Lapangan</h5>

                        <h2>

                            <?= $totalLapangan; ?>

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card shadow">

                    <div class="card-body">

                        <h5>Total Booking</h5>

                        <h2>

                            <?= $totalBooking; ?>

                        </h2>

                    </div>

                </div>

            </div>

            <div class="col-md-3">

                <div class="card shadow">

                    <div class="card-body">

                        <h5>Pendapatan</h5>

                        <h6>

                            Rp <?= number_format($pendapatan); ?>

                        </h6>

                    </div>

                </div>

            </div>

        </div>

        <hr>

        <div class="row mt-4">

            <div class="col-md-3">

                <a
                    href="lapangan.php"
                    class="btn btn-primary w-100">

                    Kelola Lapangan

                </a>

            </div>

            <div class="col-md-3">

                <a
                    href="booking.php"
                    class="btn btn-success w-100">

                    Data Booking

                </a>

            </div>

            <div class="col-md-3">

                <a
                    href="pembayaran.php"
                    class="btn btn-warning w-100">

                    Verifikasi Pembayaran

                </a>

            </div>

            <div class="col-md-3">

                <a
                    href="laporan.php"
                    class="btn btn-danger w-100">

                    Laporan

                </a>

            </div>

        </div>

    </div>

</body>

</html>
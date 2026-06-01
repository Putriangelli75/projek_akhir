<?php

session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'pelanggan') {
    header("Location: ../auth/login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard Pelanggan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <nav class="navbar navbar-dark bg-success">

        <div class="container">

            <span class="navbar-brand">
                Jakabaring Sport Center
            </span>

            <div>

                <?= $_SESSION['nama']; ?>

                <a href="../auth/logout.php"
                    class="btn btn-light btn-sm ms-3">

                    Logout

                </a>

            </div>

        </div>

    </nav>

    <div class="container mt-4">

        <h2>Dashboard Pelanggan</h2>

        <div class="row mt-4">

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body">

                        <h5>Booking Lapangan</h5>

                        <a href="booking.php"
                            class="btn btn-primary">

                            Pesan Sekarang

                        </a>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body">

                        <h5>Riwayat Booking</h5>

                        <a href="riwayat.php"
                            class="btn btn-success">

                            Lihat Riwayat

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
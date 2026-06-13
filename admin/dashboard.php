<?php

session_start();

if (
    !isset($_SESSION['id_user']) ||
    $_SESSION['role'] != 'admin'
) {
    header("Location: ../auth/login.php");
    exit;
}

require '../config/koneksi.php';

/* =========================
   STATISTIK
========================= */

$totalUser = $db->query("
SELECT COUNT(*)
FROM users
WHERE role='pelanggan'
")->fetchColumn();

$totalLapangan = $db->query("
SELECT COUNT(*)
FROM lapangan
")->fetchColumn();

$totalBooking = $db->query("
SELECT COUNT(*)
FROM booking
")->fetchColumn();

$revenue = $db->query("
SELECT IFNULL(SUM(total_bayar),0)
FROM booking
WHERE status='selesai'
")->fetchColumn();

/* =========================
   MEMBERSHIP
========================= */

$regular = $db->query("
SELECT COUNT(*)
FROM users
WHERE role='pelanggan'
AND poin < 100
")->fetchColumn();

$premium = $db->query("
SELECT COUNT(*)
FROM users
WHERE role='pelanggan'
AND poin >= 100
")->fetchColumn();

/* =========================
   UTILISASI LAPANGAN
========================= */

$lapanganAktif = $totalLapangan;

$utilisasi =
    $totalLapangan > 0
    ? 100
    : 0;

include '../layouts/header.php';

?>

<div class="container-fluid">

<div class="row">

    <?php include '../layouts/sidebar_admin.php'; ?>

    <div class="col-md-10">

        <div class="content p-4">

            <!-- HERO -->

            <div class="hero-banner mb-4">

                <div>

                    <h1>Dashboard Admin</h1>

                    <p>
                        Kelola seluruh aktivitas booking lapangan
                        dengan mudah.
                    </p>

                </div>

            </div>

            <!-- CARD STATISTIK -->

            <div class="row g-3 mb-4">

                <div class="col-md-3">

                    <div class="card shadow border-0">

                        <div class="card-body text-center">

                            <h4>Total User</h4>

                            <h1><?= $totalUser ?></h1>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card shadow border-0">

                        <div class="card-body text-center">

                            <h4>Total Lapangan</h4>

                            <h1><?= $totalLapangan ?></h1>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card shadow border-0">

                        <div class="card-body text-center">

                            <h4>Total Booking</h4>

                            <h1><?= $totalBooking ?></h1>

                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card shadow border-0">

                        <div class="card-body text-center">

                            <h4>Revenue</h4>

                            <h2>
                                Rp <?= number_format($revenue) ?>
                            </h2>

                        </div>

                    </div>

                </div>

            </div>

            <!-- MEMBERSHIP & UTILISASI -->

            <div class="row mb-4">

                <div class="col-md-6">

                    <div class="card shadow">

                        <div class="card-header bg-success text-white">

                            Membership

                        </div>

                        <div class="card-body">

                            <p>
                                Regular Member :
                                <strong><?= $regular ?></strong>
                            </p>

                            <p>
                                Premium Member :
                                <strong><?= $premium ?></strong>
                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">

                            Utilisasi Lapangan

                        </div>

                        <div class="card-body text-center">

                            <h1>
                                <?= $utilisasi ?>%
                            </h1>

                            <p>
                                Lapangan Aktif :
                                <?= $lapanganAktif ?>
                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <!-- GRAFIK -->

            <div class="card shadow mb-4">

                <div class="card-header bg-dark text-white">

                    Grafik Revenue

                </div>

                <div class="card-body">

                    <canvas id="revenueChart"></canvas>

                </div>

            </div>

            <!-- DATA LAPANGAN -->

            <div class="card shadow">

                <div class="card-header bg-success text-white">

                    Data Lapangan Terbaru

                </div>

                <div class="card-body">

                    <table class="table table-striped">

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Harga</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            $data = $db->query("
                            SELECT *
                            FROM lapangan
                            ORDER BY id_lapangan DESC
                            LIMIT 5
                            ");

                            while ($row = $data->fetch(PDO::FETCH_ASSOC)) {

                            ?>

                                <tr>

                                    <td><?= $row['id_lapangan'] ?></td>

                                    <td><?= $row['nama_lapangan'] ?></td>

                                    <td><?= $row['jenis_olahraga'] ?></td>

                                    <td>
                                        Rp <?= number_format($row['harga_per_jam']) ?>
                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>
```

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
document.getElementById('revenueChart'),
{
    type:'bar',

    data:{

        labels:[
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun'
        ],

        datasets:[{

            label:'Revenue',

            data:[
                1000000,
                2500000,
                1800000,
                3000000,
                2200000,
                4500000
            ]

        }]
    }
});

</script>

<?php include '../layouts/footer.php'; ?>

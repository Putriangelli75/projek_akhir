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

$totalUser = $db->query("
SELECT COUNT(*)
FROM users
")->fetchColumn();

$totalLapangan = $db->query("
SELECT COUNT(*)
FROM lapangan
")->fetchColumn();

$totalBooking = $db->query("
SELECT COUNT(*)
FROM booking
")->fetchColumn();

$totalRevenue = $db->query("
SELECT IFNULL(
SUM(total_bayar),0
)
FROM booking
WHERE status='disetujui'
")->fetchColumn();

$regular = $db->query("
SELECT COUNT(*)
FROM users
WHERE membership='regular'
")->fetchColumn();

$premium = $db->query("
SELECT COUNT(*)
FROM users
WHERE membership='premium'
")->fetchColumn();

$lapanganAktif = $db->query("
SELECT COUNT(*)
FROM lapangan
WHERE status='aktif'
")->fetchColumn();

$utilisasi = 0;

if ($totalLapangan > 0) {

    $utilisasi = round(
        ($lapanganAktif / $totalLapangan) * 100
    );
}

include '../layouts/header.php';

?>

<div class="container-fluid">

    <div class="row">

        <?php include '../layouts/sidebar_admin.php'; ?>

        <div class="col-md-10">

            <div class="content">

                <div class="hero-banner mb-4">

                    <div>

                        <h1>Dashboard Admin</h1>

                        <p>
                            Kelola seluruh aktivitas booking lapangan
                            dengan mudah.
                        </p>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-3 mb-3">

                        <div class="card card-stat shadow">

                            <div class="card-body text-center">

                                <h5>Total User</h5>

                                <h1>

                                    <?= $totalUser ?>

                                </h1>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3 mb-3">

                        <div class="card card-stat shadow">

                            <div class="card-body text-center">

                                <h5>Total Lapangan</h5>

                                <h1>

                                    <?= $totalLapangan ?>

                                </h1>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3 mb-3">

                        <div class="card card-stat shadow">

                            <div class="card-body text-center">

                                <h5>Total Booking</h5>

                                <h1>

                                    <?= $totalBooking ?>

                                </h1>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-3 mb-3">

                        <div class="card card-stat shadow">

                            <div class="card-body text-center">

                                <h5>Revenue</h5>

                                <h4>

                                    Rp <?= number_format($totalRevenue) ?>

                                </h4>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="row mt-2">

                    <div class="col-md-6">

                        <div class="card shadow">

                            <div class="card-header bg-success text-white">

                                Membership

                            </div>

                            <div class="card-body">

                                <p>

                                    Regular Member :
                                    <strong>

                                        <?= $regular ?>

                                    </strong>

                                </p>

                                <p>

                                    Premium Member :
                                    <strong>

                                        <?= $premium ?>

                                    </strong>

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

                <div class="card mt-4 shadow">

                    <div class="card-header bg-dark text-white">

                        Grafik Revenue

                    </div>

                    <div class="card-body">

                        <canvas id="revenueChart"></canvas>

                    </div>

                </div>

                <div class="card mt-4 shadow">

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

                                while (
                                    $row =
                                    $data->fetch(PDO::FETCH_ASSOC)
                                ) {

                                ?>

                                    <tr>

                                        <td>

                                            <?= $row['id_lapangan'] ?>

                                        </td>

                                        <td>

                                            <?= $row['nama_lapangan'] ?>

                                        </td>

                                        <td>

                                            <?= $row['jenis_olahraga'] ?>

                                        </td>

                                        <td>

                                            Rp
                                            <?= number_format(
                                                $row['harga_per_jam']
                                            ) ?>

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

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx =
        document.getElementById(
            'revenueChart'
        );

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [

                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun'

            ],

            datasets: [{

                label: 'Revenue',

                data: [

                    1000000,
                    2500000,
                    1800000,
                    3000000,
                    2200000,
                    4500000

                ]

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    display: true

                }

            }

        }

    });
</script>

<?php include '../layouts/footer.php'; ?>
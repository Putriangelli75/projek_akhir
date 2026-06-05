<?php

session_start();

if (
    !isset($_SESSION['id_user']) ||
    $_SESSION['role'] != 'pelanggan'
) {
    header("Location: ../auth/login.php");
    exit;
}

require '../config/koneksi.php';

$id_user = $_SESSION['id_user'];

$data = $db->query("

SELECT

b.*,
l.nama_lapangan

FROM booking b

JOIN lapangan l
ON b.id_lapangan = l.id_lapangan

WHERE b.id_user = $id_user

ORDER BY b.id_booking DESC

");

include '../layouts/header.php';

?>

<div class="container-fluid">

    <div class="row">

        <?php include '../layouts/sidebar_pelanggan.php'; ?>

        <div class="col-md-10">

            <div class="content p-4">

                <h2 class="mb-4">
                    Riwayat Booking
                </h2>

                <div class="card shadow">

                    <div class="card-body">

                        <table class="table table-bordered table-hover">

                            <thead class="table-dark">

                                <tr>

                                    <th>Kode Booking</th>

                                    <th>Lapangan</th>

                                    <th>Tanggal</th>

                                    <th>Jam</th>

                                    <th>Durasi</th>

                                    <th>Total Bayar</th>

                                    <th>Bukti</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php
                                while (
                                    $row =
                                    $data->fetch(PDO::FETCH_ASSOC)
                                ) {
                                ?>

                                    <tr>

                                        <td>
                                            <?= $row['kode_booking'] ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                $row['nama_lapangan']
                                            ) ?>
                                        </td>

                                        <td>
                                            <?= $row['tanggal_booking'] ?>
                                        </td>

                                        <td>
                                            <?= $row['jam_mulai'] ?>
                                        </td>

                                        <td>
                                            <?= $row['durasi'] ?> Jam
                                        </td>

                                        <td>
                                            Rp <?= number_format(
                                                    $row['total_bayar']
                                                ) ?>
                                        </td>

                                        <td>

                                            <?php
                                            if (
                                                !empty($row['bukti_pembayaran'])
                                            ) {
                                            ?>

                                                <a
                                                    href="../uploads/<?= $row['bukti_pembayaran'] ?>"
                                                    target="_blank">

                                                    Lihat Bukti

                                                </a>

                                            <?php
                                            } else {
                                                echo "-";
                                            }
                                            ?>

                                        </td>

                                        <td>

                                            <?php

                                            $status =
                                                strtolower(
                                                    $row['status']
                                                );

                                            if (
                                                $status ==
                                                'pending'
                                            ) {

                                                echo "
                                                <span class='badge bg-warning'>
                                                    Pending
                                                </span>
                                                ";
                                            } elseif (
                                                $status ==
                                                'disetujui'
                                            ) {

                                                echo "
                                                <span class='badge bg-success'>
                                                    Disetujui
                                                </span>
                                                ";
                                            } elseif (
                                                $status ==
                                                'ditolak'
                                            ) {

                                                echo "
                                                <span class='badge bg-danger'>
                                                    Ditolak
                                                </span>
                                                ";
                                            } elseif (
                                                $status ==
                                                'selesai'
                                            ) {

                                                echo "
                                                <span class='badge bg-primary'>
                                                    Selesai
                                                </span>
                                                ";
                                            } else {

                                                echo "
                                                <span class='badge bg-secondary'>
                                                    -
                                                </span>
                                                ";
                                            }

                                            ?>

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

<?php include '../layouts/footer.php'; ?>
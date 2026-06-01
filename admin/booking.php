<?php

session_start();

if(!isset($_SESSION['id_user'])){
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$data = mysqli_query(
    $conn,
    "SELECT
        booking.*,
        users.nama,
        lapangan.nama_lapangan
    FROM booking
    JOIN users
        ON booking.id_user = users.id_user
    JOIN lapangan
        ON booking.id_lapangan = lapangan.id_lapangan
    ORDER BY booking.id_booking DESC"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Data Booking</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">

<h2>Data Booking</h2>

<table class="table table-bordered">

<tr>

<th>No</th>
<th>Pelanggan</th>
<th>Lapangan</th>
<th>Tanggal</th>
<th>Jam</th>
<th>Total</th>
<th>Status</th>

</tr>

<?php

$no = 1;

while($d = mysqli_fetch_assoc($data)){

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $d['nama']; ?></td>

<td><?= $d['nama_lapangan']; ?></td>

<td><?= $d['tanggal']; ?></td>

<td>

<?= $d['jam_mulai']; ?>

-

<?= $d['jam_selesai']; ?>

</td>

<td>

Rp <?= number_format($d['total_harga']); ?>

</td>

<td>

<?= $d['status']; ?>

</td>

</tr>

<?php } ?>

</table>

<a
href="dashboard.php"
class="btn btn-secondary">

Kembali

</a>

</div>

</body>
</html>
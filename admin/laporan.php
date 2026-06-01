<?php

session_start();

if(!isset($_SESSION['id_user'])){
    header("Location: ../auth/login.php");
    exit;
}

include '../config/koneksi.php';

$tanggal_awal = "";
$tanggal_akhir = "";

$where = "";

if(isset($_POST['filter'])){

    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $where = "
    WHERE booking.tanggal
    BETWEEN '$tanggal_awal'
    AND '$tanggal_akhir'
    ";
}

$query = mysqli_query(
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
    $where
    ORDER BY booking.tanggal DESC"
);

$totalPendapatan = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT SUM(total_harga) as total
        FROM booking
        WHERE status='Lunas'"
    )
);

$total = $totalPendapatan['total'];

if($total == ""){
    $total = 0;
}
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Laporan Booking</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
@media print{
    .no-print{
        display:none;
    }
}
</style>

</head>

<body>

<div class="container mt-4">

<h2>Laporan Booking Lapangan</h2>

<div class="card mb-3 no-print">

<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-4">

<label>Tanggal Awal</label>

<input
type="date"
name="tanggal_awal"
class="form-control"
required>

</div>

<div class="col-md-4">

<label>Tanggal Akhir</label>

<input
type="date"
name="tanggal_akhir"
class="form-control"
required>

</div>

<div class="col-md-4">

<label>&nbsp;</label>

<div>

<button
type="submit"
name="filter"
class="btn btn-primary">

Filter

</button>

<button
type="button"
onclick="window.print()"
class="btn btn-success">

Cetak

</button>

<a
href="dashboard.php"
class="btn btn-secondary">

Kembali

</a>

</div>

</div>

</div>

</form>

</div>

</div>

<div class="alert alert-success">

<b>Total Pendapatan Lunas :</b>

Rp <?= number_format($total); ?>

</div>

<table class="table table-bordered">

<thead>

<tr>

<th>No</th>
<th>Pelanggan</th>
<th>Lapangan</th>
<th>Tanggal</th>
<th>Jam</th>
<th>Total</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($d = mysqli_fetch_assoc($query)){

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

</tbody>

</table>

</div>

</body>
</html>
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

$id_booking = $_GET['id'];
$status     = $_GET['status'];

/*
|--------------------------------------------------
| Update status booking
|--------------------------------------------------
*/
$stmt = $db->prepare("
UPDATE booking
SET status = ?
WHERE id_booking = ?
");

$stmt->execute([
    $status,
    $id_booking
]);

/*
|--------------------------------------------------
| Jika selesai -> tambah point
|--------------------------------------------------
*/
if ($status == 'selesai') {

    $user = $db->query("
    SELECT id_user
    FROM booking
    WHERE id_booking = $id_booking
    ")->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        $db->exec("
        UPDATE users
        SET poin = poin + 10
        WHERE id_user = " . $user['id_user']
        );
    }
}

header("Location: booking.php");
exit;
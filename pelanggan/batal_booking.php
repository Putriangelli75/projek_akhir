<?php

session_start();

require '../config/koneksi.php';

$id_booking = $_GET['id'];
$id_user    = $_SESSION['id_user'];

/*
|--------------------------------------------------
| Kurangi point user 10
|--------------------------------------------------
*/
$db->prepare("
UPDATE users
SET poin = CASE
    WHEN poin >= 10 THEN poin - 10
    ELSE 0
END
WHERE id_user = ?
")->execute([$id_user]);

/*
|--------------------------------------------------
| Hapus booking
|--------------------------------------------------
*/
$stmt = $db->prepare("
DELETE FROM booking
WHERE id_booking = ?
AND id_user = ?
");

$stmt->execute([
    $id_booking,
    $id_user
]);

header("Location: riwayat_booking.php");
exit;
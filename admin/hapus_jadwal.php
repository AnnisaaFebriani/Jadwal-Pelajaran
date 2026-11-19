<?php
include '../auth.php';
include '../koneksi.php';
auth('admin');

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = intval($_GET['id']);

$query = mysqli_query(
    $koneksi,
    "SELECT kelas FROM jadwal WHERE id = '$id'"
);

$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: dashboard.php");
    exit;
}

$kelas = $data['kelas'];

$pecah = explode(' ', $kelas, 2);

$tingkat = $pecah[0];
$jurusan = isset($pecah[1]) ? $pecah[1] : '';

$stmt = mysqli_prepare(
    $koneksi,
    "DELETE FROM jadwal WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);

header(
    "Location: jadwal.php?tingkat=" .
    urlencode($tingkat) .
    "&jurusan=" .
    urlencode($jurusan)
);

exit;
?>
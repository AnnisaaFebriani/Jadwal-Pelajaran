<?php
include '../auth.php';
include '../koneksi.php';
auth('admin');

if (!isset($_GET['id']) || !isset($_GET['jurusan'])) {
    header("Location: dashboard.php");
    exit;
}

$id = intval($_GET['id']);
$jurusan = $_GET['jurusan'];

if ($jurusan !== 'RPL' && $jurusan !== 'TKJ') {
    header("Location: dashboard.php");
    exit;
}

$query = mysqli_query(
    $koneksi,
    "DELETE FROM users
     WHERE id = '$id'
     AND role = 'guru'
     AND jurusan = '$jurusan'"
);

header(
    "Location: guru_mapel.php?jurusan=" .
    urlencode($jurusan)
);
exit;
?>
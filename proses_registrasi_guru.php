<?php

include 'koneksi.php';

if (!isset($_POST['daftar'])) {
    header("Location: registrasi_guru.php");
    exit;
}

$nama = trim($_POST['nama']);
$jurusan = strtoupper(trim($_POST['jurusan']));
$mapel = trim($_POST['mapel']);
$password = $_POST['password'];

if ($nama == '' || $jurusan == '' || $mapel == '' || $password == '') {
    die("Semua data wajib diisi.");
}

if ($jurusan != 'RPL' && $jurusan != 'TKJ') {
    die("Jurusan tidak valid.");
}

$cek = mysqli_prepare(
    $koneksi,
    "SELECT id FROM users WHERE nama = ? AND role = 'guru'"
);

mysqli_stmt_bind_param(
    $cek,
    "s",
    $nama
);

mysqli_stmt_execute($cek);

$resultCek = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($resultCek) > 0) {

    mysqli_stmt_close($cek);

    die("Guru dengan nama tersebut sudah terdaftar.");

}

mysqli_stmt_close($cek);

$password_hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO users
    (nama, password, role, jurusan, mapel)
    VALUES (?, ?, 'guru', ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $nama,
    $password_hash,
    $jurusan,
    $mapel
);

if (mysqli_stmt_execute($stmt)) {

    mysqli_stmt_close($stmt);

    header("Location: login.php?pesan=registrasi_guru_berhasil");
    exit;

} else {

    echo "Registrasi guru gagal: " . mysqli_error($koneksi);

    mysqli_stmt_close($stmt);
}
?>
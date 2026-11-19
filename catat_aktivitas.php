<?php

function catatAktivitas($koneksi, $aktivitas)
{
    if (!isset($_SESSION['id'], $_SESSION['nama'], $_SESSION['role'])) {
        return;
    }

    if ($_SESSION['role'] === 'admin') {
        return;
    }

    $user_id = $_SESSION['id'];
    $nama = $_SESSION['nama'];
    $role = $_SESSION['role'];

    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO aktivitas 
        (user_id, nama, role, aktivitas)
        VALUES (?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "isss",
        $user_id,
        $nama,
        $role,
        $aktivitas
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>
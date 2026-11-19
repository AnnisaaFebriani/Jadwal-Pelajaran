<?php

session_start();

/** @var mysqli $koneksi */
include 'koneksi.php';

$nama = $_POST['nama'] ?? '';
$password = $_POST['password'] ?? '';

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM users WHERE nama='$nama'"
);

$user = mysqli_fetch_assoc($query);

if ($user) {

    if (password_verify($password, $user['password'])) {

        $_SESSION['id']    = $user['id'];
        $_SESSION['nama']  = $user['nama'];
        $_SESSION['role']  = $user['role'];
        $_SESSION['kelas'] = $user['kelas'];

        $user_id = $user['id'];
        $nama_user = $user['nama'];
        $role = $user['role'];
        $aktivitas = "Login ke sistem";

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
            $nama_user,
            $role,
            $aktivitas
        );

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($user['role'] == 'admin') {

            header("Location: admin/dashboard.php");
            exit;

        } elseif ($user['role'] == 'guru') {

            header("Location: guru/dashboard.php");
            exit;

        } elseif ($user['role'] == 'siswa') {

            header("Location: siswa/dashboard.php");
            exit;

        } else {

            echo "
            <script>
                alert('Role pengguna tidak valid.');
                window.location.href = 'login.php';
            </script>
            ";
            exit;
        }

    } else {

        echo "
        <script>
            alert('Nama atau password salah!');
            window.location.href = 'login.php';
        </script>
        ";
        exit;
    }

} else {

    echo "
    <script>
        alert('Nama atau password salah!');
        window.location.href = 'login.php';
    </script>
    ";
    exit;
}
?>
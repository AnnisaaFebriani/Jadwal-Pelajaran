<?php
include 'koneksi.php';

$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO users (nis, nama, password, role, kelas)
VALUES (
    '$nis',
    '$nama',
    '$password',
    'siswa',
    '$kelas'
)";

$result = mysqli_query($koneksi, $query);

if($result){
    header("Location: login.php");
    exit;
}else{
    echo "Registrasi gagal: " . mysqli_error($koneksi);
}
?>
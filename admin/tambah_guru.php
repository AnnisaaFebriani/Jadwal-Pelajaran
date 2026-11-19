<?php
include '../auth.php';
include '../koneksi.php';
auth('admin');

if (!isset($_GET['jurusan'])) {
    header("Location: dashboard.php");
    exit;
}

$jurusan = $_GET['jurusan'];

if ($jurusan !== 'RPL' && $jurusan !== 'TKJ') {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);
    $password_input = $_POST['password'];

    if ($nama == '' || $mapel == '' || $password_input == '') {

        $error = "Nama guru, mata pelajaran, dan password wajib diisi.";

    } else {

        $cek = mysqli_query(
            $koneksi,
            "SELECT id FROM users
             WHERE nama = '$nama'
             AND role = 'guru'"
        );

        if (mysqli_num_rows($cek) > 0) {

            $error = "Guru dengan nama tersebut sudah terdaftar.";

        } else {

            $password = password_hash(
                $password_input,
                PASSWORD_DEFAULT
            );

            $query = mysqli_query(
                $koneksi,
                "INSERT INTO users
                (nama, password, role, kelas, nis, jurusan, mapel)
                VALUES
                ('$nama', '$password', 'guru', NULL, NULL, '$jurusan', '$mapel')"
            );

            if ($query) {

                header(
                    "Location: guru_mapel.php?jurusan=" .
                    urlencode($jurusan)
                );

                exit;

            } else {

                $error = "Data guru gagal ditambahkan: " .
                         mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tambah Guru | SMKN 1 Bukateja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            color: #495057;
            min-height: 100vh;
        }

        .header-admin {
            background-color: #5d7b9d;
            padding: 35px 0;
            color: white;
            border-radius: 0 0 25px 25px;
            margin-bottom: 35px;
        }

        .box {
            background-color: white;
            border-radius: 20px;
            padding: 35px;
            max-width: 700px;
            margin: auto;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .title {
            color: #3f5872;
            font-weight: 700;
        }

        .form-label {
            color: #3f5872;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px 14px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #5d7b9d;
            box-shadow: 0 0 0 0.2rem rgba(93, 123, 157, 0.15);
        }

        .jurusan {
            background-color: #e7f0ff;
            color: #5d7b9d;
            border-radius: 10px;
            padding: 11px 14px;
            font-weight: 600;
        }

        .btn-simpan-custom {
            display: inline-block;
            background-color: #5d7b9d !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 9px;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-simpan-custom:hover {
            background-color: #486580 !important;
            color: #ffffff !important;
        }

        .btn-kembali-custom {
            display: inline-block;
            background-color: #e7f0ff !important;
            color: #5d7b9d !important;
            border: none !important;
            border-radius: 9px;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-kembali-custom:hover {
            background-color: #5d7b9d !important;
            color: #ffffff !important;
        }

        .alert {
            border-radius: 10px;
        }

    </style>

</head>

<body>

<div class="header-admin text-center shadow-sm">

    <div class="container">

        <h2 class="fw-bold">
            Tambah Guru
        </h2>

        <p class="opacity-75 mb-0">
            SMK Negeri 1 Bukateja
        </p>

    </div>

</div>

<div class="container pb-5">

    <div class="box">

        <h4 class="title mb-4">
            Tambah Data Guru
        </h4>

        <?php if (isset($error)) { ?>

            <div class="alert alert-danger">
                <?= htmlspecialchars($error); ?>
            </div>

        <?php } ?>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nama Guru
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    placeholder="Masukkan nama guru"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Mata Pelajaran
                </label>

                <select
                    name="mapel"
                    class="form-select"
                    required
                >

                    <option value="">
                        Pilih Mata Pelajaran
                    </option>

                    <option value="Matematika">
                        Matematika
                    </option>

                    <option value="Pendidikan Pancasila">
                        Pendidikan Pancasila
                    </option>

                    <option value="Bahasa Indonesia">
                        Bahasa Indonesia
                    </option>

                    <option value="Bahasa Inggris">
                        Bahasa Inggris
                    </option>

                    <option value="Bahasa Jawa">
                        Bahasa Jawa
                    </option>

                    <option value="PJOK">
                        PJOK
                    </option>

                    <option value="Sejarah">
                        Sejarah
                    </option>

                    <option value="Bimbingan Konseling">
                        Bimbingan Konseling
                    </option>

                    <option value="Agama Islam">
                        Agama Islam
                    </option>

                    <option value="Seni Budaya">
                        Seni Budaya
                    </option>

                    <option value="Informatika">
                        Informatika
                    </option>

                    <option value="Kejuruan">
                        Kejuruan
                    </option>

                    <option value="PKDK">
                        PKDK
                    </option>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Password Guru
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Buat password untuk guru"
                    required
                >

                <small class="text-muted">
                    Password ini digunakan guru untuk login.
                </small>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Jurusan
                </label>

                <div class="jurusan">
                    <?= htmlspecialchars($jurusan); ?>
                </div>

            </div>

            <div class="d-flex gap-2">

                <a
                    href="guru_mapel.php?jurusan=<?= urlencode($jurusan); ?>"
                    class="btn-kembali-custom"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    name="simpan"
                    class="btn-simpan-custom"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>
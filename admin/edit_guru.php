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
    "SELECT * FROM users
     WHERE id = '$id'
     AND role = 'guru'
     AND jurusan = '$jurusan'"
);

$data = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: guru_mapel.php?jurusan=" . urlencode($jurusan));
    exit;
}

$daftar_mapel = [
    'Matematika',
    'Pendidikan Pancasila',
    'B. Indonesia',
    'B. Inggris',
    'B. Jawa',
    'PJOK',
    'Sejarah',
    'Bimbingan Konseling',
    'Agama Islam',
    'Seni Budaya',
    'Kejuruan',
    'PKDK',
    'Informatika'
];

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);

    if ($nama == '' || $mapel == '') {

        $error = "Nama guru dan mata pelajaran wajib diisi.";

    } elseif (!in_array($mapel, $daftar_mapel)) {

        $error = "Mata pelajaran tidak valid.";

    } else {

        $update = mysqli_query(
            $koneksi,
            "UPDATE users
             SET nama = '$nama',
                 mapel = '$mapel'
             WHERE id = '$id'
             AND role = 'guru'
             AND jurusan = '$jurusan'"
        );

        if ($update) {

            header(
                "Location: guru_mapel.php?jurusan=" .
                urlencode($jurusan)
            );

            exit;

        } else {

            $error = "Data guru gagal diperbarui: " . mysqli_error($koneksi);
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

    <title>Edit Guru | SMKN 1 Bukateja</title>

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

        .btn-simpan {
            background-color: #5d7b9d;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 10px 22px;
            font-weight: 600;
        }

        .btn-simpan:hover {
            background-color: #486580;
            color: white;
        }

        .btn-kembali {
            background-color: #e7f0ff;
            color: #5d7b9d;
            border: none;
            border-radius: 9px;
            padding: 10px 22px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-kembali:hover {
            background-color: #5d7b9d;
            color: white;
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
            Edit Guru
        </h2>

        <p class="opacity-75 mb-0">
            SMK Negeri 1 Bukateja
        </p>

    </div>

</div>

<div class="container pb-5">

    <div class="box">

        <h4 class="title mb-4">
            Edit Data Guru
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
                    value="<?= htmlspecialchars($data['nama']); ?>"
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

                    <?php foreach ($daftar_mapel as $mapel) { ?>

                        <option
                            value="<?= htmlspecialchars($mapel); ?>"
                            <?= $data['mapel'] === $mapel ? 'selected' : ''; ?>
                        >

                            <?= htmlspecialchars($mapel); ?>

                        </option>

                    <?php } ?>

                </select>

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
                    class="btn-kembali"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    name="simpan"
                    class="btn-simpan"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>
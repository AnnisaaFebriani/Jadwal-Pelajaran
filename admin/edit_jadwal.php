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
    "SELECT * FROM jadwal WHERE id = '$id'"
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

$jurusan = strtoupper(trim($jurusan));

$jam_list = [
    1  => '07:40 - 08:20',
    2  => '08:20 - 08:50',
    3  => '08:50 - 09:30',
    4  => '09:45 - 10:25',
    5  => '10:25 - 10:55',
    6  => '10:55 - 11:30',
    7  => '12:30 - 13:05',
    8  => '13:05 - 13:40',
    9  => '13:40 - 14:10',
    10 => '14:40 - 15:10',
    11 => '15:10 - 15:40'
];

$queryGuru = mysqli_query(
    $koneksi,
    "SELECT id, nama, mapel
     FROM users
     WHERE role = 'guru'
     AND UPPER(jurusan) = '$jurusan'
     ORDER BY nama ASC"
);

if (!$queryGuru) {
    die("Error: " . mysqli_error($koneksi));
}

if (isset($_POST['simpan'])) {

    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $guru_id = intval($_POST['guru']);

    $hari_valid = [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat'
    ];

    if (!in_array($hari, $hari_valid)) {

        $error = "Hari tidak valid.";

    } elseif (!is_numeric($jam) || $jam < 1 || $jam > 11) {

        $error = "Jam tidak valid.";

    } else {

        $stmtGuru = mysqli_prepare(
            $koneksi,
            "SELECT id, nama, mapel
             FROM users
             WHERE id = ?
             AND role = 'guru'
             AND UPPER(jurusan) = ?"
        );

        mysqli_stmt_bind_param(
            $stmtGuru,
            "is",
            $guru_id,
            $jurusan
        );

        mysqli_stmt_execute($stmtGuru);

        $resultGuru = mysqli_stmt_get_result($stmtGuru);
        $dataGuru = mysqli_fetch_assoc($resultGuru);

        mysqli_stmt_close($stmtGuru);

        if (!$dataGuru) {

            $error = "Guru tidak sesuai dengan jurusan kelas.";

        } else {

            $guru = $dataGuru['nama'];
            $mapel = $dataGuru['mapel'];

            $stmt = mysqli_prepare(
                $koneksi,
                "UPDATE jadwal
                 SET hari = ?,
                     jam = ?,
                     mapel = ?,
                     guru = ?
                 WHERE id = ?"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssssi",
                $hari,
                $jam,
                $mapel,
                $guru,
                $id
            );

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header(
                    "Location: jadwal.php?tingkat=" .
                    urlencode($tingkat) .
                    "&jurusan=" .
                    urlencode($jurusan)
                );

                exit;

            } else {

                $error = "Gagal mengubah jadwal.";

                mysqli_stmt_close($stmt);
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

    <title>Edit Jadwal | SMKN 1 Bukateja</title>

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

        .form-select,
        .form-control {
            border-radius: 10px;
            padding: 11px 14px;
            border: 1px solid #dee2e6;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #5d7b9d;
            box-shadow: 0 0 0 0.2rem rgba(93, 123, 157, 0.15);
        }

        .kelas-box {
            background-color: #e7f0ff;
            color: #5d7b9d;
            border-radius: 10px;
            padding: 11px 14px;
            font-weight: 600;
        }

        .jurusan-box {
            background-color: #f1f3f5;
            color: #6c757d;
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

        .info {
            font-size: 13px;
            color: #8a949e;
            margin-top: 6px;
        }

    </style>

</head>

<body>

<div class="header-admin text-center shadow-sm">

    <div class="container">

        <h2 class="fw-bold">
            Edit Jadwal
        </h2>

        <p class="opacity-75 mb-0">
            SMK Negeri 1 Bukateja
        </p>

    </div>

</div>

<div class="container pb-5">

    <div class="box">

        <h4 class="title mb-4">
            Edit Jadwal <?= htmlspecialchars($kelas); ?>
        </h4>

        <?php if (isset($error)) { ?>

            <div class="alert alert-danger">
                <?= htmlspecialchars($error); ?>
            </div>

        <?php } ?>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Kelas
                </label>

                <div class="kelas-box">
                    <?= htmlspecialchars($kelas); ?>
                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Jurusan
                </label>

                <div class="jurusan-box">
                    <?= htmlspecialchars($jurusan); ?>
                </div>

                <div class="info">
                    Guru yang tersedia hanya guru jurusan
                    <?= htmlspecialchars($jurusan); ?>.
                </div>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Hari
                </label>

                <select name="hari"
                        class="form-select"
                        required>

                    <?php

                    $hari_list = [
                        'Senin',
                        'Selasa',
                        'Rabu',
                        'Kamis',
                        'Jumat'
                    ];

                    foreach ($hari_list as $hari) {

                    ?>

                        <option
                            value="<?= $hari; ?>"
                            <?= $data['hari'] == $hari ? 'selected' : ''; ?>>

                            <?= $hari; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Jam
                </label>

                <select name="jam"
                        class="form-select"
                        required>

                    <?php foreach ($jam_list as $nomor => $waktu) { ?>

                        <option
                            value="<?= $nomor; ?>"
                            <?= (string)$data['jam'] === (string)$nomor ? 'selected' : ''; ?>>

                            Jam <?= $nomor; ?> — <?= $waktu; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Guru Pengampu
                </label>

                <select name="guru"
                        id="guru"
                        class="form-select"
                        required>

                    <option value="">
                        Pilih Guru
                    </option>

                    <?php

                    $guru_tersedia = false;

                    while ($guru = mysqli_fetch_assoc($queryGuru)) {

                        $guru_tersedia = true;

                    ?>

                        <option
                            value="<?= $guru['id']; ?>"
                            data-mapel="<?= htmlspecialchars($guru['mapel']); ?>"
                            <?= $guru['nama'] == $data['guru'] ? 'selected' : ''; ?>>

                            <?= htmlspecialchars($guru['nama']); ?>

                        </option>

                    <?php } ?>

                </select>

                <?php if (!$guru_tersedia) { ?>

                    <div class="alert alert-warning mt-2">
                        Belum ada guru untuk jurusan
                        <?= htmlspecialchars($jurusan); ?>.
                    </div>

                <?php } ?>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Mata Pelajaran
                </label>

                <input
                    type="text"
                    id="mapel"
                    class="form-control"
                    value="<?= htmlspecialchars($data['mapel']); ?>"
                    readonly>

                <div class="info">
                    Mata pelajaran otomatis mengikuti guru yang dipilih.
                </div>

            </div>

            <div class="d-flex gap-2">

                <a
                    href="jadwal.php?tingkat=<?= urlencode($tingkat); ?>&jurusan=<?= urlencode($jurusan); ?>"
                    class="btn-kembali">

                    Kembali

                </a>

                <button
                    type="submit"
                    name="simpan"
                    class="btn-simpan">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

<script>

const guru = document.getElementById('guru');
const mapel = document.getElementById('mapel');

function updateMapel() {

    const selected = guru.options[guru.selectedIndex];

    if (selected) {
        mapel.value = selected.getAttribute('data-mapel') || '';
    } else {
        mapel.value = '';
    }

}

guru.addEventListener('change', updateMapel);

updateMapel();

</script>

</body>

</html>
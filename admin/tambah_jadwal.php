<?php
include '../auth.php';
include '../koneksi.php';
auth('admin');

if (!isset($_GET['tingkat']) || !isset($_GET['jurusan'])) {
    header("Location: dashboard.php");
    exit;
}

$tingkat = $_GET['tingkat'];
$jurusan = $_GET['jurusan'];

$tingkat_valid = ['X', 'XI', 'XII'];
$jurusan_valid = ['RPL', 'TKJ'];

if (!in_array($tingkat, $tingkat_valid) || !in_array($jurusan, $jurusan_valid)) {
    header("Location: dashboard.php");
    exit;
}

$kelas = $tingkat . ' ' . $jurusan;

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
     AND jurusan = '$jurusan'
     ORDER BY nama ASC"
);

if (!$queryGuru) {
    die("Error: " . mysqli_error($koneksi));
}

if (isset($_POST['simpan'])) {

    $hari = $_POST['hari'];
    $jam = $_POST['jam'];
    $guru_id = intval($_POST['guru']);

    if ($jam === 'custom') {

        $jam_awal = intval($_POST['jam_awal']);
        $jam_akhir = intval($_POST['jam_akhir']);

        if (
            $jam_awal < 1 ||
            $jam_awal > 11 ||
            $jam_akhir < 1 ||
            $jam_akhir > 11
        ) {
            $error = "Jam tidak valid.";
        } elseif ($jam_awal > $jam_akhir) {
            $error = "Jam awal tidak boleh lebih besar dari jam akhir.";
        }

    } else {

        $jam_awal = intval($jam);
        $jam_akhir = intval($jam);

    }

    $hari_list = [
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat'
    ];

    if (!isset($error) && !in_array($hari, $hari_list)) {
        $error = "Hari tidak valid.";
    }

    if (!isset($error)) {

        $stmtGuru = mysqli_prepare(
            $koneksi,
            "SELECT nama, mapel
             FROM users
             WHERE id = ?
             AND role = 'guru'
             AND jurusan = ?"
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

            $error = "Guru tidak sesuai dengan jurusan.";

        } else {

            $guru = $dataGuru['nama'];
            $mapel = $dataGuru['mapel'];

            for ($i = $jam_awal; $i <= $jam_akhir; $i++) {

                $jam_simpan = (string)$i;

                $stmt = mysqli_prepare(
                    $koneksi,
                    "INSERT INTO jadwal
                    (hari, jam, mapel, guru, kelas)
                    VALUES (?, ?, ?, ?, ?)"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "sssss",
                    $hari,
                    $jam_simpan,
                    $mapel,
                    $guru,
                    $kelas
                );

                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }

            header(
                "Location: jadwal.php?tingkat=" .
                urlencode($tingkat) .
                "&jurusan=" .
                urlencode($jurusan)
            );

            exit;
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

    <title>Tambah Jadwal | SMKN 1 Bukateja</title>

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

        .kelas-box {
            background-color: #e7f0ff;
            color: #5d7b9d;
            border-radius: 10px;
            padding: 11px 14px;
            font-weight: 600;
        }

        .btn-simpan {
            background-color: #5d7b9d !important;
            color: white !important;
            border: none !important;
            border-radius: 9px;
            padding: 10px 22px;
            font-weight: 600;
        }

        .btn-simpan:hover {
            background-color: #486580 !important;
        }

        .btn-kembali {
            background-color: #e7f0ff !important;
            color: #5d7b9d !important;
            border: none !important;
            border-radius: 9px;
            padding: 10px 22px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-kembali:hover {
            background-color: #5d7b9d !important;
            color: white !important;
        }

        .jam-option {
            font-weight: 500;
        }

    </style>

</head>

<body>

<div class="header-admin text-center shadow-sm">

    <div class="container">

        <h2 class="fw-bold">
            Tambah Jadwal
        </h2>

        <p class="opacity-75 mb-0">
            SMK Negeri 1 Bukateja
        </p>

    </div>

</div>

<div class="container pb-5">

    <div class="box">

        <h4 class="title mb-4">
            Tambah Jadwal Pelajaran
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
                    Hari
                </label>

                <select name="hari"
                        class="form-select"
                        required>

                    <option value="">
                        Pilih Hari
                    </option>

                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Jam
                </label>

                <select name="jam"
                        id="jam"
                        class="form-select"
                        required>

                    <option value="">
                        Pilih Jam
                    </option>

                    <?php foreach ($jam_list as $nomor => $waktu) { ?>

                        <option value="<?= $nomor; ?>">
                            Jam <?= $nomor; ?> — <?= $waktu; ?>
                        </option>

                    <?php } ?>

                    <option value="custom">
                        Custom
                    </option>

                </select>

            </div>

            <div class="mb-3"
                 id="customJam"
                 style="display: none;">

                <label class="form-label">
                    Dari Jam
                </label>

                <select name="jam_awal"
                        id="jam_awal"
                        class="form-select mb-3">

                    <option value="">
                        Pilih Jam Awal
                    </option>

                    <?php foreach ($jam_list as $nomor => $waktu) { ?>

                        <option value="<?= $nomor; ?>">
                            Jam <?= $nomor; ?> — <?= $waktu; ?>
                        </option>

                    <?php } ?>

                </select>

                <label class="form-label">
                    Sampai Jam
                </label>

                <select name="jam_akhir"
                        id="jam_akhir"
                        class="form-select">

                    <option value="">
                        Pilih Jam Akhir
                    </option>

                    <?php foreach ($jam_list as $nomor => $waktu) { ?>

                        <option value="<?= $nomor; ?>">
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

                    <?php while ($guru = mysqli_fetch_assoc($queryGuru)) { ?>

                        <option
                            value="<?= $guru['id']; ?>"
                            data-mapel="<?= htmlspecialchars($guru['mapel']); ?>">

                            <?= htmlspecialchars($guru['nama']); ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Mata Pelajaran
                </label>

                <input type="text"
                       name="mapel"
                       id="mapel"
                       class="form-control"
                       readonly
                       placeholder="Mata pelajaran otomatis terisi">

            </div>

            <div class="d-flex gap-2">

                <a href="jadwal.php?tingkat=<?= urlencode($tingkat); ?>&jurusan=<?= urlencode($jurusan); ?>"
                   class="btn-kembali">

                    Kembali

                </a>

                <button type="submit"
                        name="simpan"
                        class="btn-simpan">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<script>

const guru = document.getElementById('guru');
const mapel = document.getElementById('mapel');

const jam = document.getElementById('jam');
const customJam = document.getElementById('customJam');
const jamAwal = document.getElementById('jam_awal');
const jamAkhir = document.getElementById('jam_akhir');

guru.addEventListener('change', function () {

    const selected = this.options[this.selectedIndex];

    mapel.value =
        selected.getAttribute('data-mapel') || '';

});

jam.addEventListener('change', function () {

    if (this.value === 'custom') {

        customJam.style.display = 'block';

        jamAwal.required = true;
        jamAkhir.required = true;

    } else {

        customJam.style.display = 'none';

        jamAwal.required = false;
        jamAkhir.required = false;

        jamAwal.value = '';
        jamAkhir.value = '';

    }

});

</script>

</body>
</html>
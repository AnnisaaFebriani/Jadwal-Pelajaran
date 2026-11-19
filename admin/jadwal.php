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

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM jadwal 
     WHERE kelas = '$kelas'
     ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'), jam ASC"
);

if (!$query) {
    die("Error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jadwal <?= htmlspecialchars($kelas); ?> | SMKN 1 Bukateja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            color: #495057;
        }

        .header-admin {
            background-color: #5d7b9d;
            padding: 35px 0;
            color: white;
            border-radius: 0 0 25px 25px;
            margin-bottom: 30px;
        }

        .box-table {
            background-color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .title {
            color: #3f5872;
            font-weight: 700;
        }

        .kelas-badge {
            display: inline-block;
            background-color: #e7f0ff;
            color: #5d7b9d;
            padding: 7px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
        }

        .btn-tambah {
            background-color: #5d7b9d;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 9px 18px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-tambah:hover {
            background-color: #486580;
            color: white;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background-color: #f8f9fa;
        }

        .table thead th {
            color: #5d7b9d;
            font-size: 13px;
            text-transform: uppercase;
            padding: 15px;
            border: none;
        }

        .table tbody td {
            padding: 15px;
            border-top: 1px solid #f1f1f1;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8fbff;
        }

        .hari {
            font-weight: 600;
            color: #3f5872;
        }

        .jam {
            color: #8a949e;
            font-size: 14px;
        }

        .mapel {
            font-weight: 600;
            color: #495057;
        }

        .guru {
            color: #6c757d;
        }

        .btn-edit {
            background-color: #e7f0ff;
            color: #5d7b9d;
            border: none;
            border-radius: 7px;
            padding: 6px 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-edit:hover {
            background-color: #5d7b9d;
            color: white;
        }

        .btn-hapus {
            background-color: #fff1f1;
            color: #d9534f;
            border: 1px solid #ffdfdf;
            border-radius: 7px;
            padding: 6px 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-hapus:hover {
            background-color: #d9534f;
            color: white;
        }

        .btn-kembali {
            display: inline-block;
            margin-top: 20px;
            background-color: #e7f0ff;
            color: #5d7b9d;
            border-radius: 9px;
            padding: 9px 18px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-kembali:hover {
            background-color: #5d7b9d;
            color: white;
        }

        .kosong {
            padding: 40px !important;
            color: #8a949e;
        }
    </style>
</head>

<body>

<div class="header-admin text-center shadow-sm">
    <div class="container">
        <h2 class="fw-bold">Jadwal Pelajaran</h2>
        <p class="opacity-75 mb-0">
            SMK Negeri 1 Bukateja
        </p>
    </div>
</div>

<div class="container pb-5">

    <div class="box-table">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="title mb-2">
                    Jadwal Pelajaran
                </h4>

                <span class="kelas-badge">
                    Kelas <?= htmlspecialchars($kelas); ?>
                </span>
            </div>

            <a href="tambah_jadwal.php?tingkat=<?= urlencode($tingkat); ?>&jurusan=<?= urlencode($jurusan); ?>"
               class="btn-tambah">
                + Tambah Jadwal
            </a>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (mysqli_num_rows($query) > 0) { ?>

                    <?php while ($data = mysqli_fetch_assoc($query)) { ?>

                        <tr>

                            <td class="hari">
                                <?= htmlspecialchars($data['hari']); ?>
                            </td>

                            <td class="jam">
                                <?= htmlspecialchars($data['jam']); ?>
                            </td>

                            <td class="mapel">
                                <?= htmlspecialchars($data['mapel']); ?>
                            </td>

                            <td class="guru">
                                <?= htmlspecialchars($data['guru']); ?>
                            </td>

                            <td class="text-center">

                                <a href="edit_jadwal.php?id=<?= $data['id']; ?>&tingkat=<?= urlencode($tingkat); ?>&jurusan=<?= urlencode($jurusan); ?>"
                                   class="btn-edit">
                                    Edit
                                </a>

                                <a href="hapus_jadwal.php?id=<?= $data['id']; ?>&tingkat=<?= urlencode($tingkat); ?>&jurusan=<?= urlencode($jurusan); ?>"
                                   class="btn-hapus"
                                   onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    Hapus
                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>
                        <td colspan="5" class="text-center kosong">
                            Belum ada jadwal untuk kelas <?= htmlspecialchars($kelas); ?>
                        </td>
                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

        <a href="dashboard.php" class="btn-kembali">
            Kembali ke Dashboard
        </a>

    </div>

</div>

</body>
</html>
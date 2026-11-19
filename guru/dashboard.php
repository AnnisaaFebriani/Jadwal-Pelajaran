<?php

include '../auth.php';
include '../koneksi.php';
include '../catat_aktivitas.php';

auth('guru');

$nama_guru = $_SESSION['nama'];

catatAktivitas($koneksi, "Melihat jadwal mengajar");

$query = mysqli_prepare(
    $koneksi,
    "SELECT hari, jam, mapel, kelas
     FROM jadwal
     WHERE guru = ?
     ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'), 
              CAST(jam AS UNSIGNED) ASC"
);

mysqli_stmt_bind_param($query, "s", $nama_guru);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);

$jadwal = [];

while ($data = mysqli_fetch_assoc($result)) {
    $jadwal[] = $data;
}

mysqli_stmt_close($query);

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

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Guru | SMKN 1 Bukateja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            color: #495057;
            min-height: 100vh;
        }

        .header-guru {
            background-color: #5d7b9d;
            padding: 35px 0;
            color: white;
            border-radius: 0 0 25px 25px;
            margin-bottom: 35px;
        }

        .welcome {
            background: white;
            border-radius: 20px;
            padding: 25px 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .welcome h4 {
            color: #3f5872;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .welcome p {
            margin: 0;
            color: #7b8794;
        }

        .card-jadwal {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .title {
            color: #3f5872;
            font-weight: 700;
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 12px;
        }

        .table thead th {
            background-color: #e7f0ff;
            color: #5d7b9d;
            font-size: 13px;
            font-weight: 700;
            border: none;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            border-top: 1px solid #edf0f3;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8fbff;
        }

        .badge-hari {
            display: inline-block;
            background-color: #e7f0ff;
            color: #5d7b9d;
            padding: 7px 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        .badge-jam {
            display: inline-block;
            background-color: #f1f3f5;
            color: #495057;
            padding: 7px 12px;
            border-radius: 8px;
            font-weight: 600;
        }

        .jam-waktu {
            display: block;
            font-size: 11px;
            color: #8a949e;
            margin-top: 3px;
            font-weight: 500;
        }

        .btn-logout {
            background-color: #e7f0ff;
            color: #5d7b9d;
            border: none;
            border-radius: 9px;
            padding: 9px 18px;
            text-decoration: none;
            font-weight: 600;
        }

        .btn-logout:hover {
            background-color: #5d7b9d;
            color: white;
        }

        .btn-cetak {
            background-color: #5d7b9d;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 9px 18px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-cetak:hover {
            background-color: #486580;
            color: white;
        }

        .empty {
            padding: 40px;
            text-align: center;
            color: #8a949e;
        }

        @media (max-width: 768px) {

            .card-jadwal {
                padding: 20px;
            }

            .table {
                min-width: 650px;
            }

        }

        @media print {

            @page {
                size: A4;
                margin: 15mm;
            }

            body {
                background: white;
                color: black;
            }

            .header-guru {
                background: white !important;
                color: black !important;
                border-radius: 0;
                padding: 5px 0 15px;
                margin-bottom: 15px;
                box-shadow: none !important;
            }

            .header-guru p {
                color: black !important;
            }

            .welcome {
                box-shadow: none;
                padding: 5px 0 15px;
                margin-bottom: 10px;
            }

            .welcome h4 {
                color: black !important;
            }

            .welcome p {
                color: black !important;
            }

            .card-jadwal {
                box-shadow: none;
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                border-radius: 0;
            }

            .table thead th {
                background-color: #e7f0ff !important;
                color: #3f5872 !important;
                border: 1px solid #adb5bd !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table th,
            .table td {
                border: 1px solid #adb5bd !important;
                color: black !important;
            }

            .badge-hari {
                background-color: #e7f0ff !important;
                color: #3f5872 !important;
                padding: 5px 8px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .badge-jam {
                background-color: #f1f3f5 !important;
                color: black !important;
                padding: 5px 8px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .jam-waktu {
                color: #555 !important;
            }

            .table tbody tr:hover {
                background-color: white !important;
            }

        }

    </style>

</head>

<body>

<div class="header-guru text-center shadow-sm">

    <div class="container">

        <h2 class="fw-bold">
            Jadwal Mengajar Guru
        </h2>

        <p class="mb-0 opacity-75">
            SMK Negeri 1 Bukateja
        </p>

    </div>

</div>


<div class="container pb-5">

    <div class="welcome">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h4>
                    Selamat datang,
                    <?= htmlspecialchars($nama_guru); ?>
                </h4>

                <p>
                    Berikut jadwal mengajar Anda.
                </p>

            </div>

            <div class="d-flex align-items-center gap-3 no-print">

                <button
                    type="button"
                    class="btn-cetak"
                    onclick="window.print()">

                    Cetak Jadwal

                </button>

                <a
                    href="../logout.php"
                    class="btn-logout btn-warning"
                    onclick="return confirm('Yakin ingin keluar?')">

                    Logout

                </a>

            </div>

        </div>

    </div>


    <div class="card-jadwal">

        <div class="mb-4">

            <h4 class="title mb-1">
                Jadwal Mengajar
            </h4>

        </div>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Hari</th>

                        <th>Jam</th>

                        <th>Mata Pelajaran</th>

                        <th>Kelas</th>

                    </tr>

                </thead>

                <tbody>

                <?php if (count($jadwal) > 0) { ?>

                    <?php foreach ($jadwal as $index => $data) { ?>

                        <?php
                        $nomor_jam = intval($data['jam']);
                        $waktu_jam = $jam_list[$nomor_jam] ?? '-';
                        ?>

                        <tr>

                            <td>
                                <?= $index + 1; ?>
                            </td>

                            <td>

                                <span class="badge-hari">

                                    <?= htmlspecialchars($data['hari']); ?>

                                </span>

                            </td>

                            <td>

                                <span class="badge-jam">

                                    Jam ke-<?= htmlspecialchars($data['jam']); ?>

                                    <span class="jam-waktu">
                                        <?= htmlspecialchars($waktu_jam); ?>
                                    </span>

                                </span>

                            </td>

                            <td class="fw-semibold">

                                <?= htmlspecialchars($data['mapel']); ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($data['kelas']); ?>

                            </td>

                        </tr>

                    <?php } ?>

                <?php } else { ?>

                    <tr>

                        <td colspan="5">

                            <div class="empty">

                                Belum ada jadwal mengajar untuk

                                <strong>
                                    <?= htmlspecialchars($nama_guru); ?>
                                </strong>.

                            </div>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>

</html>
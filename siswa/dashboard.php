<?php

if (session_status() === PHP_SESSION_NONE) {
}

require_once __DIR__ . '/../koneksi.php';
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../catat_aktivitas.php';

auth('siswa');

catatAktivitas($koneksi, "Melihat jadwal");

if ($_SESSION['role'] != "siswa") {
    header("Location: ../login.php");
    exit;
}

$kelas_siswa = $_SESSION['kelas'];

$query = "SELECT * FROM jadwal
          WHERE kelas = '$kelas_siswa'
          ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'), jam ASC";

$nama_siswa = $_SESSION['nama'];

$data = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Siswa | SMKN 1 Bukateja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body {
            background: #f6f8fb;
            font-family: 'Segoe UI', sans-serif;
            color: #495057;
        }

        .header {
            background: #5d7b9d;
            padding: 40px;
            border-radius: 0 0 30px 30px;
            color: white;
        }

        .box {
            background: white;
            border-radius: 18px;
            padding: 25px;
            margin-top: -30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        }

        .table-wrapper {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e5ebf2;
        }

        .table {
            margin-bottom: 0;
            border: none;
        }

        .table thead {
            background: #5d7b9d;
        }

        .table thead th {
            background: #5d7b9d;
            color: white;
            border: none;
            padding: 14px 12px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .table tbody td {
            border-color: #edf1f5;
            padding: 14px 10px;
            vertical-align: middle;
            color: #495057;
        }

        .table tbody tr {
            transition: 0.2s ease;
        }

        .table tbody tr:hover:not(.table-istirahat) {
            background-color: #f7faff;
        }

        .jam-column {
            background-color: #f8fafc;
            color: #5d7b9d !important;
            font-weight: 600;
            min-width: 110px;
        }

        .jam-column small {
            color: #8b98a7 !important;
            font-weight: 400;
        }

        .jadwal-mapel {
            color: #3f5872;
            font-weight: 600;
            font-size: 13px;
        }

        .jadwal-guru {
            color: #8a949e;
            font-size: 11px;
            margin-top: 3px;
        }

        .kosong {
            color: #c1c9d2;
            font-size: 14px;
        }

        .table-istirahat td {
            background-color: #eef5ff !important;
            color: #5d7b9d;
            border-color: #dce9f8;
        }

        .istirahat-text {
            color: #5d7b9d;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .btn-cetak {
            background-color: #5d7b9d;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 7px 16px;
        }

        .btn-cetak:hover {
            background-color: #486580;
            color: white;
        }

        .btn-logout {
            border-radius: 8px;
            padding: 7px 16px;
        }

        @media print {

            body {
                background: white;
            }

            .header {
                background: white !important;
                color: black !important;
                border-radius: 0;
                padding: 10px 0;
                margin-bottom: 20px;
            }

            .header p {
                color: black !important;
            }

            .box {
                margin-top: 0;
                padding: 0;
                box-shadow: none;
            }

            .no-print {
                display: none !important;
            }

            .table-wrapper {
                border: 1px solid #777;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
            }

            .table th,
            .table td {
                border: 1px solid #777 !important;
            }

            .table thead th {
                background-color: #5d7b9d !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table-istirahat td {
                background-color: #eef5ff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .jam-column {
                background-color: #f8fafc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

        }

        @media (max-width: 768px) {

            .box {
                padding: 18px;
            }

            .table {
                min-width: 700px;
            }

        }

    </style>

</head>

<body>

<div class="header text-center">

    <h2 class="fw-bold">
        Dashboard Siswa
    </h2>

    <p class="mb-0 opacity-75">
        SMK Negeri 1 Bukateja
    </p>

</div>


<br><br>


<div class="container mb-5">

    <div class="box">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <div>

                <h4 class="m-0 fw-bold">

                    Hai

                    <span class="text-primary">

                        <?= htmlspecialchars($nama_siswa); ?>

                    </span>

                </h4>

                <h5 class="mt-1">

                    Kelas

                    <span class="text-primary">

                        <?= htmlspecialchars($kelas_siswa); ?>

                    </span>

                </h5>

            </div>


            <div class="d-flex align-items-center gap-3 no-print">

                <button
                    type="button"
                    class="btn btn-cetak"
                    onclick="window.print()">

                    Cetak Jadwal

                </button>


                <a
                    href="../logout.php"
                    class="btn btn-outline-danger btn-logout"
                    onclick="return confirm('Yakin ingin keluar?')">

                    Logout

                </a>

            </div>

        </div>


        <div class="table-responsive">

            <div class="table-wrapper">

                <table class="table table-sm text-center">

                    <thead>

                        <tr>

                            <th width="12%">
                                Jam
                            </th>

                            <?php foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari): ?>

                                <th>
                                    <?= $hari ?>
                                </th>

                            <?php endforeach; ?>

                        </tr>

                    </thead>


                    <tbody>

                    <?php

                    $hari_list = [
                        'Senin',
                        'Selasa',
                        'Rabu',
                        'Kamis',
                        'Jumat'
                    ];

                    $jam_list = [
                        1  => '07:40-08:20',
                        2  => '08:20-08:50',
                        3  => '08:50-09:30',
                        4  => '09:45-10:25',
                        5  => '10:25-10:55',
                        6  => '10:55-11:30',
                        7  => '12:30-13:05',
                        8  => '13:05-13:40',
                        9  => '13:40-14:10',
                        10 => '14:40-15:10',
                        11 => '15:10-15:40'
                    ];


                    $data_jadwal = [];


                    while($d = mysqli_fetch_array($data)) {

                        $data_jadwal[$d['jam']][$d['hari']] = [

                            'mapel' => $d['mapel'],

                            'guru' => $d['guru']

                        ];

                    }


                    if(empty($data_jadwal)) {

                    ?>

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-5 text-muted">

                                Jadwal belum tersedia

                            </td>

                        </tr>

                    <?php

                    } else {

                        $jam_aktif = [

                            1,
                            2,
                            3,
                            'istirahat1',
                            4,
                            5,
                            6,
                            'istirahat2',
                            7,
                            8,
                            9,
                            10,
                            11

                        ];


                        foreach($jam_aktif as $j):

                            $isIstirahat =
                                ($j == 'istirahat1' || $j == 'istirahat2');

                    ?>

                    <tr
                        class="<?= $isIstirahat ? 'table-istirahat' : '' ?>">

                        <td
                            class="jam-column">

                            <?php if($j == 'istirahat1'): ?>

                                <span class="istirahat-text">

                                    09:30 - 09:45

                                </span>

                            <?php elseif($j == 'istirahat2'): ?>

                                <span class="istirahat-text">

                                    11:30 - 12:30

                                </span>

                            <?php else: ?>

                                <?= $j ?>

                                <br>

                                <small>

                                    <?= $jam_list[$j] ?>

                                </small>

                            <?php endif; ?>

                        </td>


                        <?php foreach($hari_list as $hari): ?>

                        <td>

                            <?php if($isIstirahat): ?>

                                <span class="istirahat-text">

                                    ISTIRAHAT

                                </span>


                            <?php elseif(isset($data_jadwal[$j][$hari])): ?>

                                <div class="jadwal-mapel">

                                    <?= htmlspecialchars(
                                        $data_jadwal[$j][$hari]['mapel']
                                    ) ?>

                                </div>


                                <div class="jadwal-guru">

                                    <?= htmlspecialchars(
                                        $data_jadwal[$j][$hari]['guru']
                                    ) ?>

                                </div>


                            <?php else: ?>

                                <span class="kosong">

                                    -

                                </span>

                            <?php endif; ?>

                        </td>

                        <?php endforeach; ?>

                    </tr>

                    <?php

                        endforeach;

                    }

                    ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>
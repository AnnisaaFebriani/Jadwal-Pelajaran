
<?php
include '../auth.php';
include '../koneksi.php';

auth('admin');

if (isset($_POST['hapus_terpilih'])) {

    if (!empty($_POST['aktivitas'])) {

        $ids = $_POST['aktivitas'];
        $ids = array_map('intval', $ids);
        $ids = implode(',', $ids);

        mysqli_query(
            $koneksi,
            "DELETE FROM aktivitas WHERE id IN ($ids)"
        );
    }

    header("Location: statistik.php");
    exit;
}

$queryTotal = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM aktivitas"
);

$totalAktivitas = mysqli_fetch_assoc($queryTotal)['total'];

$queryLogin = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM aktivitas
     WHERE aktivitas = 'Login ke sistem'"
);

$totalLogin = mysqli_fetch_assoc($queryLogin)['total'];

$queryGuru = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM aktivitas
     WHERE role = 'guru'"
);

$totalGuru = mysqli_fetch_assoc($queryGuru)['total'];

$querySiswa = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total
     FROM aktivitas
     WHERE role = 'siswa'"
);

$totalSiswa = mysqli_fetch_assoc($querySiswa)['total'];

$queryAktivitas = mysqli_query(
    $koneksi,
    "SELECT *
     FROM aktivitas
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Statistik Aktivitas | SMKN 1 Bukateja</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
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

        .card-stat {
            background-color: white;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            height: 100%;
        }

        .stat-title {
            color: #7b8794;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-number {
            color: #3f5872;
            font-size: 30px;
            font-weight: 700;
        }

        .box {
            background-color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .title {
            color: #3f5872;
            font-weight: 700;
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
            border: none;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            border-top: 1px solid #f0f1f2;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8fbff;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #5d7b9d;
        }

        .pilih-semua {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #5d7b9d;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin: 0;
        }

        .badge-admin {
            background-color: #e7f0ff;
            color: #5d7b9d;
            padding: 6px 12px;
            border-radius: 7px;
            font-weight: 600;
        }

        .badge-guru {
            background-color: #e8f5e9;
            color: #388e3c;
            padding: 6px 12px;
            border-radius: 7px;
            font-weight: 600;
        }

        .badge-siswa {
            background-color: #fff3cd;
            color: #856404;
            padding: 6px 12px;
            border-radius: 7px;
            font-weight: 600;
        }

        .btn-hapus {
            background-color: #fff1f1;
            color: #d9534f;
            border: 1px solid #ffdfdf;
            border-radius: 9px;
            padding: 9px 18px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-hapus:hover {
            background-color: #d9534f;
            color: white;
        }

        .btn-kembali {
            background-color: #e7f0ff;
            color: #5d7b9d;
            border: none;
            border-radius: 9px;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        .btn-kembali:hover {
            background-color: #5d7b9d;
            color: white;
        }

        .btn-print {
            background-color: #5d7b9d;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 10px 20px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-print:hover {
            background-color: #486580;
            color: white;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #8a949e;
        }

        @media (max-width: 768px) {

            .box {
                padding: 20px;
            }

            .table {
                min-width: 800px;
            }

        }

        @media print {

            body {
                background-color: white !important;
                color: black !important;
            }

            .header-admin {
                background-color: white !important;
                color: black !important;
                border-radius: 0;
                padding: 15px 0;
                margin-bottom: 20px;
                box-shadow: none !important;
            }

            .header-admin p {
                color: black !important;
                opacity: 1 !important;
            }

            .card-stat {
                box-shadow: none !important;
                border: 1px solid #ddd;
            }

            .box {
                box-shadow: none !important;
                padding: 0;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
            }

            .table th,
            .table td {
                border: 1px solid #333 !important;
                color: black !important;
            }

            .badge-admin,
            .badge-guru,
            .badge-siswa {
                background-color: white !important;
                color: black !important;
                border: none !important;
            }

            .btn-print,
            .btn-kembali,
            .btn-hapus,
            .checkbox,
            .pilih-semua {
                display: none !important;
            }

            .table th:first-child,
            .table td:first-child {
                display: none !important;
            }

            .text-muted {
                color: black !important;
            }

            .table tbody tr:hover {
                background-color: white !important;
            }

        }

    </style>

</head>

<body>

<div class="header-admin text-center shadow-sm">

    <div class="container">

        <h2 class="fw-bold">
            Statistik Aktivitas
        </h2>

        <p class="opacity-75 mb-0">
            SMK Negeri 1 Bukateja
        </p>

    </div>

</div>


<div class="container pb-5">

    <div class="row g-4 mb-4">

        <div class="col-md-3">

            <div class="card-stat">

                <div class="stat-title">
                    Total Aktivitas
                </div>

                <div class="stat-number">
                    <?= $totalAktivitas; ?>
                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card-stat">

                <div class="stat-title">
                    Total Login
                </div>

                <div class="stat-number">
                    <?= $totalLogin; ?>
                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card-stat">

                <div class="stat-title">
                    Aktivitas Guru
                </div>

                <div class="stat-number">
                    <?= $totalGuru; ?>
                </div>

            </div>

        </div>


        <div class="col-md-3">

            <div class="card-stat">

                <div class="stat-title">
                    Aktivitas Siswa
                </div>

                <div class="stat-number">
                    <?= $totalSiswa; ?>
                </div>

            </div>

        </div>

    </div>


    <div class="box">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

            <div>

                <h4 class="title mb-1">
                    Riwayat Aktivitas
                </h4>

                <p class="text-muted mb-0">
                    Daftar aktivitas pengguna dalam sistem.
                </p>

            </div>


            <form
                method="POST"
                id="formHapus"
                onsubmit="return konfirmasiHapus()">

                <button
                    type="submit"
                    name="hapus_terpilih"
                    class="btn btn-hapus">

                    Hapus Terpilih

                </button>

            </form>

        </div>


        <div class="d-flex justify-content-end mb-3">

            <label class="pilih-semua">

                Pilih Semua

                <input
                    type="checkbox"
                    id="pilihSemua"
                    class="checkbox">

            </label>

        </div>


        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th style="width: 70px;">
                            Pilih
                        </th>

                        <th>
                            No
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Aktivitas
                        </th>

                        <th>
                            Waktu
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php

                $no = 1;

                if (mysqli_num_rows($queryAktivitas) > 0) {

                    while ($data = mysqli_fetch_assoc($queryAktivitas)) {

                ?>

                    <tr>

                        <td>

                            <input
                                type="checkbox"
                                name="aktivitas[]"
                                value="<?= $data['id']; ?>"
                                class="checkbox aktivitas-checkbox"
                                form="formHapus">

                        </td>


                        <td>
                            <?= $no++; ?>
                        </td>


                        <td class="fw-semibold">
                            <?= htmlspecialchars($data['nama']); ?>
                        </td>


                        <td>

                            <?php if ($data['role'] == 'admin') { ?>

                                <span class="badge-admin">
                                    Admin
                                </span>

                            <?php } elseif ($data['role'] == 'guru') { ?>

                                <span class="badge-guru">
                                    Guru
                                </span>

                            <?php } else { ?>

                                <span class="badge-siswa">
                                    Siswa
                                </span>

                            <?php } ?>

                        </td>


                        <td>
                            <?= htmlspecialchars($data['aktivitas']); ?>
                        </td>


                        <td>

                            <?= date(
                                'd-m-Y H:i',
                                strtotime($data['waktu'])
                            ); ?>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="6">

                            <div class="empty">
                                Belum ada aktivitas.
                            </div>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>


        <div class="mt-4 d-flex justify-content-end gap-2">

            <button
                type="button"
                class="btn-print"
                onclick="window.print()">

                Print

            </button>

            <a
                href="dashboard.php"
                class="btn-kembali">

                Kembali

            </a>

        </div>

    </div>

</div>


<script>

const pilihSemua =
    document.getElementById('pilihSemua');

const checkboxAktivitas =
    document.querySelectorAll('.aktivitas-checkbox');


pilihSemua.addEventListener('change', function () {

    checkboxAktivitas.forEach(function (checkbox) {

        checkbox.checked = pilihSemua.checked;

    });

});


checkboxAktivitas.forEach(function (checkbox) {

    checkbox.addEventListener('change', function () {

        const jumlahDipilih =
            document.querySelectorAll(
                '.aktivitas-checkbox:checked'
            ).length;

        pilihSemua.checked =
            checkboxAktivitas.length > 0 &&
            jumlahDipilih === checkboxAktivitas.length;

    });

});


function konfirmasiHapus() {

    const jumlahDipilih =
        document.querySelectorAll(
            '.aktivitas-checkbox:checked'
        ).length;


    if (jumlahDipilih === 0) {

        alert(
            'Pilih aktivitas yang ingin dihapus terlebih dahulu.'
        );

        return false;

    }


    return confirm(
        'Yakin ingin menghapus ' +
        jumlahDipilih +
        ' aktivitas yang dipilih?'
    );

}

</script>

</body>

</html>
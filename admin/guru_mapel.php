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

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM users 
     WHERE role = 'guru' 
     AND jurusan = '$jurusan' 
     ORDER BY nama ASC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Guru & Mapel <?= htmlspecialchars($jurusan); ?> | SMKN 1 Bukateja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .title {
            color: #3f5872;
            font-weight: 700;
        }

        .badge-jurusan {
            background-color: #e7f0ff;
            color: #5d7b9d;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-tambah {
            background-color: #5d7b9d;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 9px 18px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-tambah:hover {
            background-color: #486580;
            color: white;
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
        }

        .table tbody tr:hover {
            background-color: #f8fbff;
        }

        .btn-back {
            background-color: #e7f0ff;
            color: #5d7b9d;
            border: none;
            border-radius: 9px;
            padding: 9px 18px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-back:hover {
            background-color: #5d7b9d;
            color: white;
        }

        @media (max-width: 768px) {
            .box {
                padding: 20px;
            }

            .header-admin {
                padding: 28px 0;
            }
        }
    </style>
</head>

<body>

<div class="header-admin text-center shadow-sm">
    <div class="container">
        <h2 class="fw-bold">Guru & Mata Pelajaran</h2>
        <p class="opacity-75 mb-0">
            SMK Negeri 1 Bukateja
        </p>
    </div>
</div>

<div class="container pb-5">

    <div class="box">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="title mb-2">
                    Data Guru
                </h4>

                <span class="badge-jurusan">
                    Jurusan <?= htmlspecialchars($jurusan); ?>
                </span>
            </div>

            <a href="tambah_guru.php?jurusan=<?= urlencode($jurusan); ?>"
               class="btn-tambah">
                + Tambah Guru
            </a>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Mata Pelajaran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $no = 1;

                if (mysqli_num_rows($query) > 0) {
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>

                    <tr>

                        <td>
                            <?= $no++; ?>
                        </td>

                        <td class="fw-semibold">
                            <?= htmlspecialchars($data['nama']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($data['mapel']); ?>
                        </td>

                        <td class="text-center">

                            <a href="edit_guru.php?id=<?= $data['id']; ?>&jurusan=<?= urlencode($jurusan); ?>" 
                            class="btn btn-sm btn-outline-secondary px-3 me-1">
                                Edit
                            </a>

                            <a href="hapus_guru.php?id=<?= $data['id']; ?>&jurusan=<?= urlencode($jurusan); ?>" 
                            class="btn btn-sm btn-outline-danger px-3" 
                            onclick="return confirm('Yakin ingin menghapus guru ini?')">
                                Hapus
                            </a>

                        </td>
                    </tr>

                <?php
                    }
                } else {
                ?>

                    <tr>
                        <td colspan="4"
                            class="text-center text-muted py-4">
                            Belum ada data guru untuk jurusan
                            <?= htmlspecialchars($jurusan); ?>
                        </td>
                    </tr>

                <?php
                }
                ?>

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            <a href="dashboard.php" class="btn-back">
                Kembali
            </a>

        </div>

    </div>

</div>

</body>
</html>
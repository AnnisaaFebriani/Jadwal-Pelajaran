<?php
include '../auth.php';
include '../koneksi.php';

auth('admin');

$queryJadwal = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM jadwal"
);

$dataJadwal = mysqli_fetch_assoc($queryJadwal);
$totalJadwal = $dataJadwal['total'];
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin | SMKN 1 Bukateja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        * {
            box-sizing: border-box;
        }

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
            margin-bottom: 40px;
        }

        .header-admin h2 {
            margin-bottom: 5px;
        }

        /* BOX MENU */

        .menu-box {
            background-color: white;
            border-radius: 22px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .dashboard-title {
            color: #3f5872;
            font-weight: 700;
            margin-bottom: 25px;
        }

        /* CARD */

        .dashboard-card {
            border-radius: 20px;
            padding: 30px;
            height: 100%;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.10);
        }

        /* WARNA CARD GURU */

        .card-guru {
            background-color: #f5f8ff;
        }

        .card-guru .card-icon {
            background-color: #e5efff;
            color: #5d7b9d;
        }

        .card-guru .arrow {
            color: #5d7b9d;
        }

        /* WARNA CARD JADWAL */

        .card-jadwal {
            background-color: #f4fbf6;
        }

        .card-jadwal .card-icon {
            background-color: #e3f4e8;
            color: #5f9464;
        }

        .card-jadwal .arrow {
            color: #5f9464;
        }

        /* WARNA CARD STATISTIK */

        .card-statistik {
            background-color: #faf7ff;
        }

        .card-statistik .card-icon {
            background-color: #f0e5ff;
            color: #8665a8;
        }

        .card-statistik .arrow {
            color: #8665a8;
        }

        /* ICON */

        .card-icon {
            width: 65px;
            height: 65px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
        }

        .card-icon svg {
            width: 32px;
            height: 32px;
        }

        /* TEXT */

        .dashboard-card h5 {
            color: #3f5872;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .dashboard-card p {
            color: #8a949e;
            font-size: 14px;
            line-height: 1.6;
            min-height: 45px;
            margin-bottom: 0;
        }

        /* FOOTER CARD */

        .card-footer-info {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-label {
            color: #8a949e;
            font-size: 13px;
        }

        .arrow {
            font-size: 20px;
            font-weight: 500;
        }

        /* LOGOUT */

        .bottom-menu {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f1f2;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .btn-logout {
            background-color: #fff1f1;
            color: #d9534f;
            border: 1px solid #ffdfdf;
            padding: 9px 20px;
            border-radius: 9px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background-color: #d9534f;
            color: white;
        }

        /* MODAL BUTTON */

        .pilihan-btn {
            display: block;
            width: 100%;
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 12px;
            border: 1px solid #e1e6eb;
            background-color: #f8fafc;
            color: #5d7b9d;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .pilihan-btn:last-child {
            margin-bottom: 0;
        }

        .pilihan-btn:hover {
            background-color: #5d7b9d;
            color: white;
            border-color: #5d7b9d;
        }

        /* MODAL */

        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-header {
            background-color: #5d7b9d;
            color: white;
            border: none;
            padding: 20px 25px;
        }

        .modal-body {
            padding: 30px;
        }

        /* RESPONSIVE */

        @media (max-width: 768px) {

            .header-admin {
                padding: 28px 0;
            }

            .menu-box {
                padding: 20px;
            }

            .dashboard-card {
                padding: 25px;
            }

            .bottom-menu {
                margin-top: 25px;
            }

        }

    </style>

</head>

<body>


<!-- HEADER -->

<div class="header-admin text-center shadow-sm">

    <div class="container">

        <h2 class="fw-bold">
            Dashboard Admin
        </h2>

        <p class="opacity-75 mb-0">
            SMK Negeri 1 Bukateja
        </p>

    </div>

</div>


<!-- MENU -->

<div class="container pb-5">

    <div class="menu-box">

        <h4 class="dashboard-title">
            Menu Utama
        </h4>


        <div class="row g-4">


            <!-- GURU & MAPEL -->

            <div class="col-lg-4 col-md-6">

                <div class="dashboard-card card-guru"
                     data-bs-toggle="modal"
                     data-bs-target="#guruMapelModal">

                    <div class="card-icon">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M15 19.128a9.38 9.38 0 0 0 3.75.872c1.42 0 2.77-.316 3.975-.88M16.5 7.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM3.75 20.25a6.75 6.75 0 0 1 13.5 0"/>

                        </svg>

                    </div>

                    <h5>
                        Guru & Mapel
                    </h5>

                    <p>
                        Kelola data guru dan mata pelajaran.
                    </p>

                    <div class="card-footer-info">

                        <div class="card-label">
                            Data Guru & Mata Pelajaran
                        </div>

                        <div class="arrow">
                            →
                        </div>

                    </div>

                </div>

            </div>


            <!-- JADWAL -->

            <div class="col-lg-4 col-md-6">

                <div class="dashboard-card card-jadwal"
                     data-bs-toggle="modal"
                     data-bs-target="#jadwalModal">

                    <div class="card-icon">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M4.5 5.25h15a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1 1.5 1.5h-15A1.5 1.5 0 0 1 3 20.25V6.75a1.5 1.5 0 0 1 1.5-1.5Z"/>

                        </svg>

                    </div>

                    <h5>
                        Jadwal Pelajaran
                    </h5>

                    <p>
                        Kelola jadwal berdasarkan tingkat kelas dan jurusan.
                    </p>

                    <div class="card-footer-info">

                        <div class="card-label">
                            Jadwal Pelajaran
                        </div>

                        <div class="arrow">
                            →
                        </div>

                    </div>

                </div>

            </div>


            <!-- STATISTIK -->

            <div class="col-lg-4 col-md-6">

                <a href="statistik.php"
                   style="text-decoration: none; color: inherit; display: block; height: 100%;">

                    <div class="dashboard-card card-statistik">

                        <div class="card-icon">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M3.75 3v17.25h16.5M7.5 16.5v-5.25M12 16.5V7.5M16.5 16.5v-8.25"/>

                            </svg>

                        </div>

                        <h5>
                            Statistik
                        </h5>

                        <p>
                            Melihat pengguna yang login dan aktivitas sistem.
                        </p>

                        <div class="card-footer-info">

                            <div class="card-label">
                                Statistik Pengguna
                            </div>

                            <div class="arrow">
                                →
                            </div>

                        </div>

                    </div>

                </a>

            </div>


        </div>


        <!-- LOGOUT -->

        <div class="bottom-menu">

            <a href="../logout.php"
               class="btn-logout"
               onclick="return confirm('Yakin ingin keluar?')">

                Logout

            </a>

        </div>


    </div>

</div>


<!-- MODAL GURU & MAPEL -->

<div class="modal fade"
     id="guruMapelModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Guru & Mapel
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <a href="guru_mapel.php?jurusan=RPL"
                   class="pilihan-btn">

                    RPL

                </a>

                <a href="guru_mapel.php?jurusan=TKJ"
                   class="pilihan-btn">

                    TKJ

                </a>

            </div>

        </div>

    </div>

</div>


<!-- MODAL JADWAL -->

<div class="modal fade"
     id="jadwalModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Jadwal Pelajaran
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <button type="button"
                        class="pilihan-btn"
                        data-bs-dismiss="modal"
                        data-bs-toggle="modal"
                        data-bs-target="#kelasXModal">

                    Kelas X

                </button>

                <button type="button"
                        class="pilihan-btn"
                        data-bs-dismiss="modal"
                        data-bs-toggle="modal"
                        data-bs-target="#kelasXIModal">

                    Kelas XI

                </button>

                <button type="button"
                        class="pilihan-btn"
                        data-bs-dismiss="modal"
                        data-bs-toggle="modal"
                        data-bs-target="#kelasXIIModal">

                    Kelas XII

                </button>

            </div>

        </div>

    </div>

</div>


<!-- MODAL KELAS X -->

<div class="modal fade"
     id="kelasXModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Kelas X
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <a href="jadwal.php?tingkat=X&jurusan=RPL"
                   class="pilihan-btn">

                    X RPL

                </a>

                <a href="jadwal.php?tingkat=X&jurusan=TKJ"
                   class="pilihan-btn">

                    X TKJ

                </a>

            </div>

        </div>

    </div>

</div>


<!-- MODAL KELAS XI -->

<div class="modal fade"
     id="kelasXIModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Kelas XI
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <a href="jadwal.php?tingkat=XI&jurusan=RPL"
                   class="pilihan-btn">

                    XI RPL

                </a>

                <a href="jadwal.php?tingkat=XI&jurusan=TKJ"
                   class="pilihan-btn">

                    XI TKJ

                </a>

            </div>

        </div>

    </div>

</div>


<!-- MODAL KELAS XII -->

<div class="modal fade"
     id="kelasXIIModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Kelas XII
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <a href="jadwal.php?tingkat=XII&jurusan=RPL"
                   class="pilihan-btn">

                    XII RPL

                </a>

                <a href="jadwal.php?tingkat=XII&jurusan=TKJ"
                   class="pilihan-btn">

                    XII TKJ

                </a>

            </div>

        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

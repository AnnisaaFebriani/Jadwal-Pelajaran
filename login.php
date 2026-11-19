<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login | SMKN 1 Bukateja</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            background-color: #f8f9fa;
            font-size: 14px;
        }

        .card-login {
            max-width: 400px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .form-control,
        .btn {
            font-size: 14px;
            padding: 10px 12px;
            border-radius: 8px;
        }

        .text-primary-soft {
            color: #5d7b9d !important;
            font-weight: bold;
        }

        .btn-primary-soft {
            background-color: #5d7b9d;
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary-soft:hover {
            background-color: #4a627d;
            color: white;
            transform: translateY(-2px);
        }

        .ask-text {
            font-size: 12px;
            color: #6c757d;
        }

        .btn-guru {
            background-color: #e7f0ff;
            border: 1px solid #d2e1f5;
            color: #5d7b9d;
        }

        .btn-guru:hover {
            background-color: #5d7b9d;
            border-color: #5d7b9d;
            color: white;
        }

    </style>

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-11 col-sm-8 col-md-5 col-lg-4">

            <div class="card card-login mx-auto">

                <div class="card-body p-4">

                    <h4 class="text-center mb-4 text-primary-soft">
                        LOGIN SISTEM
                    </h4>

                    <form action="proses_login.php" method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Nama Pengguna
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                placeholder="Masukkan nama"
                                required
                            >

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary-soft w-100 mb-2">

                            Masuk Sekarang

                        </button>

                    </form>

                    <hr class="my-4">

                    <div class="text-center">

                        <p class="ask-text mb-2">
                            Belum punya akun?
                        </p>

                        <a
                            href="register_siswa.php"
                            class="btn btn-outline-warning w-100 py-2 text-dark fw-medium"
                            style="font-size: 12px;">

                            Daftar Akun Siswa

                        </a>

                    </div>

                    <div class="text-center mt-2">

                        <a
                            href="registrasi_guru.php"
                            class="btn btn-guru w-100 py-2 fw-medium"
                            style="font-size: 12px;">

                            Daftar Akun Guru

                        </a>

                    </div>

                    <div class="text-center mt-3">

                        <a
                            href="home.php"
                            class="btn btn-link text-secondary"
                            style="font-size: 12px; text-decoration: none;">

                            Kembali ke Beranda

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>
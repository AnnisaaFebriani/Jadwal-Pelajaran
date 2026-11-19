<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrasi Guru | SMKN 1 Bukateja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
        }

        .register-box {
            max-width: 500px;
            margin: 60px auto;
            background-color: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .title {
            color: #3f5872;
            font-weight: 700;
        }

        .form-label {
            color: #3f5872;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 11px 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #5d7b9d;
            box-shadow: 0 0 0 0.2rem rgba(93, 123, 157, 0.15);
        }

        .btn-daftar {
            width: 100%;
            background-color: #5d7b9d;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 11px;
            font-weight: 600;
        }

        .btn-daftar:hover {
            background-color: #486580;
            color: white;
        }

        .login-link {
            color: #5d7b9d;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link:hover {
            color: #3f5872;
        }
    </style>

</head>

<body>

<div class="container">

    <div class="register-box">

        <h3 class="title text-center mb-2">
            Registrasi Guru
        </h3>

        <p class="text-center text-muted mb-4">
            SMK Negeri 1 Bukateja
        </p>

        <form action="proses_registrasi_guru.php" method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Nama Guru
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    placeholder="Masukkan nama guru"
                    required
                >

            </div>

            <div class="mb-3">

                <label class="form-label">
                    Jurusan
                </label>

                <select
                    name="jurusan"
                    class="form-select"
                    required
                >

                    <option value="">
                        Pilih Jurusan
                    </option>

                    <option value="RPL">
                        RPL
                    </option>

                    <option value="TKJ">
                        TKJ
                    </option>

                </select>

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

                    <option value="Informatika">
                        Informatika
                    </option>

                    <option value="Matematika">
                        Matematika
                    </option>

                    <option value="Bahasa Indonesia">
                        Bahasa Indonesia
                    </option>

                    <option value="Bahasa Inggris">
                        Bahasa Inggris
                    </option>

                    <option value="Pendidikan Agama Islam">
                        Pendidikan Agama Islam
                    </option>

                    <option value="Pendidikan Pancasila">
                        Pendidikan Pancasila
                    </option>

                    <option value="Sejarah">
                        Sejarah
                    </option>

                    <option value="PJOK">
                        PJOK
                    </option>

                       <option value="Kejuruan">
                        Kejuruan
                    </option>

                </select>

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
                name="daftar"
                class="btn-daftar"
            >
                Daftar
            </button>

        </form>

        <div class="text-center
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skansika Time | SMK Negeri 1 Bukateja</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-soft: #5d7b9d; 
            --text-dark: #44546a;
            --accent-blue: #e3f2fd;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f4f7f9 0%, #e9eff5 100%);
            color: var(--text-dark);
            overflow-x: hidden;
            min-height: 100vh;
        }

      
        .navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e1e8ed;
            padding: 15px 0;
        }

        .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            color: var(--primary-soft) !important;
            letter-spacing: -1px;
        }

        
        .hero-container {
            min-height: calc(100vh - 120px);
            display: flex;
            align-items: center;
        }

        .welcome-card {
            background: white;
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.03);
            border: 1px solid rgba(255,255,255,0.8);
            position: relative;
            z-index: 5;
        }

        .title-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            color: var(--primary-soft);
            font-size: 2rem;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .badge-smk {
            background: var(--accent-blue);
            color: var(--primary-soft);
            font-weight: 600;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 11px;
            margin-bottom: 20px;
            display: inline-block;
        }

       
        .logo-wrapper {
            position: relative;
            display: inline-block;
            padding: 20px;
        }

  
        .logo-wrapper::before {
            content: "";
            position: absolute;
            width: 140%;
            height: 140%;
            background: radial-gradient(circle, rgba(93, 123, 157, 0.15) 0%, transparent 70%);
            top: -20%;
            left: -20%;
            z-index: 1;
            border-radius: 50%;
        }

       
        .dots-dekor {
            position: absolute;
            width: 100px;
            height: 100px;
            background-image: radial-gradient(var(--primary-soft) 2px, transparent 2px);
            background-size: 15px 15px;
            z-index: 1;
            opacity: 0.3;
        }
        .dots-1 { top: -10px; left: -10px; }
        .dots-2 { bottom: -10px; right: -10px; }

        
        .img-main {
            width: 100%;
            max-width: 320px;
            border-radius: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.1);
            position: relative;
            z-index: 2;
            border: 10px solid white;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
        }

        .img-main:hover {
            transform: scale(1.05) rotate(-2deg);
            box-shadow: 0 35px 60px rgba(93, 123, 157, 0.25);
        }

        
        .floating-info {
            position: absolute;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(5px);
            padding: 12px 20px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            z-index: 10;
            border: 1px solid white;
            animation: float 4s ease-in-out infinite;
        }

        .info-1 { top: 10%; right: -20px; border-left: 5px solid var(--primary-soft); }
        .info-2 { bottom: 15%; left: -30px; animation-delay: 2s; border-right: 5px solid var(--primary-soft); }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        
        .status-box {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px dashed #ced4da;
        }

        .status-item h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: var(--primary-soft);
        }

        .status-item span { font-size: 11px; color: #94a3b8; }

        .btn-login {
            background: var(--primary-soft);
            color: white;
            border-radius: 15px;
            padding: 15px 35px;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #a3afc0;
            transform: translateY(2px);
            box-shadow: 0 10px 20px rgba(93, 123, 157, 0.2);
            color: white;
        }

        footer {
            padding: 30px 0;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="#">
           SKANSIKA <span style="font-weight: 300;">TIME</span>
        </a>
        <div class="ms-auto">
            <a href="login.php" class="btn btn-outline-secondary btn-sm rounded-pill px-4 fw-medium">Portal Masuk</a>
        </div>
    </div>
</nav>

<div class="container hero-container">
    <div class="row align-items-center">
        
        <div class="col-lg-6 order-2 order-lg-1">
            <div class="welcome-card">
                <span class="badge-smk">SISTEM PENJADWALAN TERPADU</span>
                <h1 class="title-brand">SMK NEGERI 1 BUKATEJA</h1>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    Wujudkan manajemen waktu belajar yang efisien dan transparan. Akses seluruh jadwal mata pelajaran dalam satu genggaman.
                </p>
                
                <div class="d-flex gap-2 align-items-center">
                    <a href="login.php" class="btn btn-login shadow-sm">Masuk Ke Sistem</a>
                </div>

                <div class="status-box">
                    <div class="status-item">
                        <h6>Online</h6>
                        <span>Status Server</span>
                    </div>
                   
                    <div class="status-item border-start ps-3">
                        <h6><?php echo date("Y"); ?></h6>
                        <span>Tahun Akademik</span>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="col-lg-6 order-1 order-lg-2 text-center mb-5 mb-lg-0">
            <div class="logo-wrapper">
             
                <div class="dots-dekor dots-1"></div>
                <div class="dots-dekor dots-2"></div>
                
                <img src="img/smk.jpg" class="img-main" alt="SMKN 1 Bukateja">

                
                <div class="floating-info info-1 d-none d-md-block">
                    <div class="text-start">
                        <p class="m-0 fw-bold" style="font-size: 12px; color: var(--text-dark);">Jadwal Pelajaran</p>
                        <small style="font-size: 10px; color: #94a3b8;">Real-time Update</small>
                    </div>
                </div>

                
                <div class="floating-info info-2 d-none d-md-block">
                    <div class="text-start">
                        <p class="m-0 fw-bold" style="font-size: 12px; color: var(--text-dark);">Info KBM</p>
                        <small style="font-size: 10px; color: #94a3b8;">Terintegrasi Sistem</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        &copy; <?php echo date("Y"); ?> <strong>Annisa</strong> - RPL - SMK Negeri 1 Bukateja
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Register Siswa | SMKN 1 Bukateja</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <style> 
        body { background-color: #f8f9fa; font-size: 14px; font-family: 'Poppins', sans-serif; } 
        .card-register { max-width: 500px; border: none; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); } 
        .form-control, .btn { font-size: 14px; padding: 10px 12px; border-radius: 8px; } 
        .text-primary-soft { color: #5d7b9d !important; font-weight: bold; } 
        .btn-primary-soft { background-color: #5d7b9d; border: none; color: white; transition: all 0.3s ease; } 
        .btn-primary-soft:hover { background-color: #4a627d; color: white; transform: translateY(-2px); } 
        .ask-text { font-size: 12px; color: #6c757d; } 
        .bg-custom { background: linear-gradient(135deg, #f4f7f9 0%, #e9eff5 100%); min-height: 100vh; } 
    </style> 
</head> 
<body class="bg-custom"> 
    <div class="container"> 
        <div class="row justify-content-center align-items-center vh-100"> 
            <div class="col-11 col-sm-8 col-md-6 col-lg-4"> 
                <div class="card card-register mx-auto"> 
                    <div class="card-body p-4"> 
                        <h4 class="text-center mb-4 text-primary-soft">DAFTAR SISWA</h4> 
                        <form action="proses_register_siswa.php" method="POST"> 
                            <div class="mb-3"> 
                                <label class="form-label">NIS</label> 
                                <input type="text" name="nis" class="form-control" placeholder="Nomor Induk Siswa" required autocomplete="off"> 
                            </div> 
                            <div class="mb-3"> 
                                <label class="form-label">Nama Lengkap</label> 
                                <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required autocomplete="off"> 
                            </div> 
                            <div class="mb-3"> 
                                <label class="form-label">Kelas</label> 
                                <select name="kelas" class="form-control" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="X PPLG">X PPLG</option>
                                    <option value="X TJKT">X TJKT</option>
                                    <option value="XI RPL">XI RPL</option>
                                    <option value="XI TKJ">XI TKJ</option>
                                    <option value="XII RPL">XII RPL</option>
                                    <option value="XII TKJ">XII TKJ</option>
                                </select>
                            </div> 
                            <div class="mb-3"> 
                                <label class="form-label">Password</label> 
                                <input type="password" name="password" class="form-control" placeholder="Buat password (minimal 6 karakter, contoh: Nama123)" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" title="Minimal 6 karakter, harus ada huruf dan angka" autocomplete="new-password"> 
                            </div> 
                            <button type="submit" class="btn btn-primary-soft w-100 mb-0">Buat Akun Sekarang</button> 
                        </form> 
                    </div> 
                    <div class="text-center mt-4"> 
                        <a href="login.php" class="text-decoration-none text-muted" style="font-size: 12px;">&larr; Kembali ke Login</a> 
                    </div> 
                    <br><br> 
                </div> 
            </div> 
        </div> 
    </div> 
</body> 
</html>
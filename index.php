<?php include_once("auth/functions.php"); ?>
<?php
session_start();
if ($_SESSION) {
    header("location: beranda/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UANGKU | Aplikasi Manajemen Keuangan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" href="assets/style.css">
</head>



<body style="background-color: #F2F4FA;">
    <div class="container pt-5">
        <div class="card text-center shadow-lg mx-auto" style="max-width: 480px;">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="true">Masuk</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Daftar</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-5">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <h1 class="card-title">UANGKU</h1>
                        <p>Aplikasi Manajemen Keuangan</p>
                        <?php
                        if (isset($_GET["error"])) {
                            $error = $_GET["error"];
                            if ($error == 1)
                                showError("Email dan password tidak sesuai.");
                            else if ($error == 2)
                                showError("Error database. Silahkan hubungi administrator");
                            else if ($error == 3)
                                showError("Koneksi ke Database gagal. Autentikasi gagal.");
                            else if ($error == 4)
                                showError("Anda tidak boleh mengakses halaman sebelumnya karena belum login. Silahkan login terlebih dahulu.");
                            else
                                showError("Unknown Error.");
                        }
                        ?>
                        <form action="auth/cekLogin.php" method="post">
                            <div class="form-group">
                                <label for="email">Alamat Email</label>
                                <input type="email" class="form-control" name="email" placeholder="contoh@email.com" id="email" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="password">Kata Sandi</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <button type="submit" name="loginBtn" class="btn my-primary text-white btn-block">Kirim</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <h1 class="card-title">UANGKU</h1>
                        <p>Aplikasi Manajemen Keuangan</p>
                        <form>
                            <div class="form-group">
                                <label for="name">Nama kamu</label>
                                <input type="text" class="form-control" placeholder="John Doe" id="name">
                            </div>
                            <div class="form-group">
                                <label for="new-email">Alamat Email</label>
                                <input type="email" class="form-control" placeholder="contoh@email.com" id="new-email" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="new-password">Kata Sandi</label>
                                <input type="password" class="form-control" id="new-password">
                            </div>
                            <button type="submit" class="btn my-primary text-white btn-block">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>

</html>
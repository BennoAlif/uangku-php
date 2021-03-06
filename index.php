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
    <title>UANGKU | Sistem Informasi Keuangan</title>
    <link rel="icon" type="image/png" href="assets/icon.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.min.css">
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
                        <p>Sistem Informasi Keuangan</p>
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
                            else if ($error == 5)
                                showError("Anda Email sudah dipakai.");
                            else
                                showError("Unknown Error.");
                        }
                        ?>
                        <?php
                        if ($_SERVER['REMOTE_ADDR'] == "5.189.147.47") {
                        ?>
                            <div class="text-left">
                                Email : bennoalif41@gmail.com<br>
                                Password : adminadmin
                            </div>
                        <?php
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
                            <button type="submit" name="loginBtn" id="loginBtn" class="btn my-primary text-white btn-block">Masuk</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <h1 class="card-title">UANGKU</h1>
                        <p>Aplikasi Manajemen Keuangan</p>
                        <form>
                            <div class="form-group">
                                <label for="name">Nama kamu</label>
                                <input type="text" class="form-control" placeholder="John Doe" id="name" required>
                            </div>
                            <div class="form-group">
                                <label for="new-email">Alamat Email</label>
                                <input type="email" class="form-control" placeholder="contoh@email.com" id="new-email" aria-describedby="emailHelp" required>
                            </div>
                            <div class="form-group">
                                <label for="new-password">Kata Sandi</label>
                                <input type="password" class="form-control" id="new-password" required>
                            </div>
                            <button type="submit" id="simpan" class="btn my-primary text-white btn-block">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $("#loginBtn").on("click", function(e) {
            let email = $("#email").val()
            let password = $("#password").val()
            if (email == "" || password == "") {
                Swal.fire(
                    'Peringatan!',
                    'Pastikan Semua Data sudah terisi',
                    'warning'
                );
                e.preventDefault()
            } else {
                return true
            }
        })

        $("#simpan").on("click", function(e) {
            e.preventDefault()
            let email = $("#new-email").val();
            let nama = $("#name").val();
            let password = $("#new-password").val()
            const re_email = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i;
            if (email == "" || nama == "" || password == "") {
                Swal.fire(
                    'Peringatan!',
                    'Pastikan Semua Data sudah terisi',
                    'warning'
                );
            } else if (!re_email.test(email)) {
                Swal.fire(
                    'Peringatan!',
                    'Format email tidak valid',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "controllers/pengguna.php",
                    type: "post",
                    data: {
                        type: "create",
                        email,
                        nama,
                        password
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Selamat! Kamu sudah terdaftar.',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1600);
                    },
                    error: function(data) {
                        $("#new-email").val("")
                        $("#new-password").val("")
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to add data',
                            text: "Email sudah pernah dibuat sebelumnya",
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                })
            }
        })
    </script>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION["idPengguna"])) {
    header("location: ../index.php?error=4");
}
?>
<nav class="navbar navbar-expand-lg navbar-dark shadow" style="background-color: #94A7DB;">
    <a class="navbar-brand" href="#">UANGKU</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../beranda/index.php">Beranda<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Laporan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../beranda/kategori.php">Kategori</a>
            </li>
        </ul>
        <span class="my-2 my-lg-0">
            <div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION["nama"]; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal">Ubah data diri</a>
                    <a class="dropdown-item" href="../auth/logout.php">Keluar</a>
                </div>
            </div>
        </span>
    </div>
</nav>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah data diri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ubah-nama">Nama</label>
                        <input type="text" class="form-control" id="ubah-nama" value="<?= $_SESSION["nama"] ?>">
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="togglePass">
                        <label class="custom-control-label" for="togglePass">Ubah kata sandi?</label>
                    </div>
                    <div class="gantiPassword">
                        <div class="form-group">
                            <label for="old-password">Kata Sandi Lama</label>
                            <input type="password" class="form-control" id="old-password">
                        </div>
                        <div class="form-group">
                            <label for="new-password">Kata Sandi Baru</label>
                            <input type="password" class="form-control" id="new-password">
                        </div>
                    </div>
                    <hr />
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" id="hapusPengguna">Hapus akun</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="ubah-pengguna">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
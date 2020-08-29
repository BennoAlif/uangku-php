<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body style="background-color: #F2F4FA;">
    <?php include_once("./components/navbar.php") ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-md-5 col-lg-4 mb-4">
                <div class="p-3 rounded-lg shadow-lg">
                    <h3>Semua Transaksi</h3>
                    <p class="mb-3">Meliputi semua bulan.</p>
                    <?php
                    include_once("../auth/functions.php");
                    $db = dbConnect();
                    $idPengguna = $_SESSION['idPengguna'];
                    $month = date('m');
                    $dateNow = date('Y-m-d');

                    if ($db->connect_errno == 0) {
                        $sql = "SELECT SUM(nominal) AS nominal, jenis FROM transaksi WHERE id_user = $idPengguna GROUP BY jenis ORDER BY jenis";
                        $res = $db->query($sql);
                        if ($res) {
                            $data = $res->fetch_all(MYSQLI_ASSOC);
                            $jumlah = 0;
                            $peng = 0;
                            $pem = 0;
                            if ($data) {
                                if (isset($data[1])) {
                                    $peng = $data[0]["jenis"] == "pengeluaran" ? $data[0]["nominal"] : $data[1]["nominal"];
                                    $pem = $data[0]["jenis"] == "pemasukan" ? $data[0]["nominal"] : $data[1]["nominal"];
                                    $jumlah = $data[0]["nominal"] - $data[1]["nominal"];
                                } else if (isset($data[0])) {
                                    $peng = $data[0]["jenis"] == "pengeluaran" ? $data[0]["nominal"] : 0;
                                    $pem = $data[0]["jenis"] == "pemasukan" ? $data[0]["nominal"] : 0;
                                    $jumlah = $data[0]["jenis"] == "pengeluaran" ? 0 - $data[0]["nominal"] : $data[0]["nominal"];
                                } else {
                                    $jumlah = 0;
                                }
                            }
                    ?>
                            <div class="row">
                                <div class="col-6">
                                    <small>Pemasukan</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-right text-success"><?= rupiah($pem) ?></h4>
                                </div>
                                <div class="col-6">
                                    <small>Pengeluaran</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-right my-text-danger"><?= rupiah($peng) ?></h4>
                                </div>
                            </div>
                            <hr />
                            <h3 class="text-right text-primary mb-4"><?= rupiah($jumlah) ?></h3>
                    <?php
                        }
                    }
                    ?>
                    <button type="button" class="btn btn-danger btn-block" data-target="#expenseModal" data-toggle="modal">Tambah Pengeluaran</button>
                    <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#incomeModal">Tambah Pemasukan</button>

                    <div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pengeluaran</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nominal">Nominal</label>
                                            <input type="number" class="form-control" id="nominal" placeholder="Contoh: 20000">
                                        </div>
                                        <div class="form-group">
                                            <label for="date">Tanggal</label>
                                            <input type="date" class="form-control" id="date">
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Kategori</label>
                                            <?php
                                            if ($db->connect_errno == 0) {
                                                $sql = "SELECT * FROM kategori WHERE tipe = 'pengeluaran'";
                                                $res = $db->query($sql);
                                                if ($res) {
                                            ?>
                                                    <select class="form-control" id="category">
                                                        <option>Pilih kategori...</option>
                                                        <?php
                                                        $data = $res->fetch_all(MYSQLI_ASSOC);
                                                        foreach ($data as $val) {
                                                        ?>
                                                            <option value="<?= $val["id"] ?>"><?= $val["nama_kategori"] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                            <?php
                                                    $res->free();
                                                } else
                                                    echo "Gagal eksekusi SQL";
                                            } else
                                                echo "Gagal Koneksi";
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="catatan">Catatan</label>
                                            <textarea class="form-control" id="catatan" rows="3" placeholder="Contoh: Makan nasi padang"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="button" id="simpanOutcome" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="incomeModal" tabindex="-1" aria-labelledby="incomeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="incomeModalLabel">Tambah Pemasukan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nominalIncome">Nominal</label>
                                            <input type="number" class="form-control" id="nominalIncome" placeholder="Contoh: 20000">
                                        </div>
                                        <div class="form-group">
                                            <label for="dateIncome">Tanggal</label>
                                            <input type="date" class="form-control" id="dateIncome">
                                        </div>
                                        <div class="form-group">
                                            <label for="categoryIncome">Kategori</label>
                                            <?php
                                            if ($db->connect_errno == 0) {
                                                $sql = "SELECT * FROM kategori WHERE tipe = 'pemasukan'";
                                                $res = $db->query($sql);
                                                if ($res) {
                                            ?>
                                                    <select class="form-control" id="categoryIncome">
                                                        <option>Pilih kategori...</option>
                                                        <?php
                                                        $data = $res->fetch_all(MYSQLI_ASSOC);
                                                        foreach ($data as $val) {
                                                        ?>
                                                            <option value="<?= $val["id"] ?>"><?= $val["nama_kategori"] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                            <?php
                                                    $res->free();
                                                } else
                                                    echo "Gagal eksekusi SQL";
                                            } else
                                                echo "Gagal Koneksi";
                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="catatanIncome">Catatan</label>
                                            <textarea class="form-control" id="catatanIncome" rows="3" placeholder="Contoh: Makan nasi padang"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="button" id="simpanIncome" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7 col-lg-8">
                <div class="p-3 rounded-lg shadow-lg">
                    <h3 class="mb-4">Detail Transaksi Bulan <?= date('F Y'); ?></h3>
                    <?php
                    if ($db->connect_errno == 0) {
                        $sql = "SELECT transaksi.id, nominal, jenis, tanggal, catatan, nama_kategori, tipe FROM transaksi JOIN kategori ON transaksi.id_kategori = kategori.id WHERE id_user = '$idPengguna' AND MONTH(tanggal) = '$month'";
                        $res = $db->query($sql);
                        if ($res) {
                    ?>
                            <table id="table_id" class="display nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nominal</th>
                                        <th>Kategori</th>
                                        <th>Catatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data = $res->fetch_all(MYSQLI_ASSOC);
                                    foreach ($data as $val) {
                                    ?>
                                        <tr class="item<?= $val['id'] ?>">
                                            <td><?= $val["tanggal"] ?></td>
                                            <td class="<?= $val['jenis'] == "pemasukan" ? "text-success" : "text-danger" ?>"><?= rupiah($val["nominal"]); ?></td>
                                            <td><?= $val["nama_kategori"] ?></td>
                                            <td><?= $val["catatan"] ?></td>
                                            <td>
                                                <button class="btn my-primary text-white btn-sm editBtn" data-toggle="modal" data-target="#updateModal<?= $val["jenis"] ?>" data-id="<?= $val['id'] ?>"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger btn-sm deleteBtn" data-id="<?= $val['id'] ?>"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                    <?php
                            $res->free();
                        } else
                            echo "Gagal eksekusi SQL";
                    } else
                        echo "Gagal Koneksi";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModalpengeluaran" tabindex="-1" aria-labelledby="updateModalpengeluaranLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalpengeluaranLabel">Ubah Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ubahNominal">Nominal</label>
                            <input type="number" class="form-control" id="ubahNominal" placeholder="Contoh: 20000">
                        </div>
                        <div class="form-group">
                            <label for="ubahDate">Tanggal</label>
                            <input type="date" class="form-control" id="ubahDate">
                        </div>
                        <div class="form-group">
                            <label for="ubahCategory">Kategori</label>
                            <?php
                            if ($db->connect_errno == 0) {
                                $sql = "SELECT * FROM kategori WHERE tipe = 'pengeluaran'";
                                $res = $db->query($sql);
                                if ($res) {
                            ?>
                                    <select class="form-control" id="ubahCategory">
                                        <option>Pilih kategori...</option>
                                        <?php
                                        $data = $res->fetch_all(MYSQLI_ASSOC);
                                        foreach ($data as $val) {
                                        ?>
                                            <option value="<?= $val["id"] ?>"><?= $val["nama_kategori"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                            <?php
                                    $res->free();
                                } else
                                    echo "Gagal eksekusi SQL";
                            } else
                                echo "Gagal Koneksi";
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="ubahCatatan">Catatan</label>
                            <textarea class="form-control" id="ubahCatatan" rows="3" placeholder="Contoh: Makan nasi padang"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" id="ubah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateModalpemasukan" tabindex="-1" aria-labelledby="updateModalpemasukanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalpemasukanLabel">Ubah Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ubahNominalPemasukan">Nominal</label>
                            <input type="number" class="form-control" id="ubahNominalPemasukan" placeholder="Contoh: 20000">
                        </div>
                        <div class="form-group">
                            <label for="ubahDatePemasukan">Tanggal</label>
                            <input type="date" class="form-control" id="ubahDatePemasukan">
                        </div>
                        <div class="form-group">
                            <label for="ubahCategoryPemasukan">Kategori</label>
                            <?php
                            if ($db->connect_errno == 0) {
                                $sql = "SELECT * FROM kategori WHERE tipe = 'pemasukan'";
                                $res = $db->query($sql);
                                if ($res) {
                            ?>
                                    <select class="form-control" id="ubahCategoryPemasukan">
                                        <option>Pilih kategori...</option>
                                        <?php
                                        $data = $res->fetch_all(MYSQLI_ASSOC);
                                        foreach ($data as $val) {
                                        ?>
                                            <option value="<?= $val["id"] ?>"><?= $val["nama_kategori"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                            <?php
                                    $res->free();
                                } else
                                    echo "Gagal eksekusi SQL";
                            } else
                                echo "Gagal Koneksi";
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="ubahCatatanPemasukan">Catatan</label>
                            <textarea class="form-control" id="ubahCatatanPemasukan" rows="3" placeholder="Contoh: Makan nasi padang"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" id="ubahPemasukan" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        let namaPengguna = '<?= $_SESSION["nama"] ?>';
        let idPengguna = '<?= $_SESSION["idPengguna"] ?>';
    </script>
    <script src="../assets/app.js"></script>

    <script>
        $(document).ready(function() {
            let currentId
            $('#table_id').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true
            });
        });

        function deleteAction(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "../controllers/pengeluaran.php",
                        type: 'post',
                        data: {
                            id,
                            type: 'delete'
                        },
                        success: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Deleted!',
                                'Your data has been deleted.',
                                'success'
                            );
                            $('.item' + id).fadeOut(1500, function() {
                                $(this).remove();
                            });
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 1600);
                        },
                        error: function(data) {
                            swalWithBootstrapButtons.fire(
                                'Gagal!',
                                'Failed to delete your data.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        $(".deleteBtn").on("click", function() {
            deleteAction($(this).data("id"));
        })

        $("#simpanOutcome").on("click", function(e) {
            e.preventDefault()
            let nominal = $("#nominal").val()
            let tanggal = $("#date").val()
            let id_kategori = $("#category").val()
            let catatan = $("#catatan").val()
            let id_user = <?= $_SESSION["idPengguna"]; ?>;
            if (nominal == '' || tanggal == '' || id_kategori === 'Pilih kategori...') {
                Swal.fire(
                    "Warning!",
                    'Pastikan Semua Data sudah terisi',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "../controllers/pengeluaran.php",
                    type: "post",
                    data: {
                        type: "create",
                        nominal,
                        tanggal,
                        id_kategori,
                        catatan,
                        id_user
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1600);
                    },
                    error: function(data) {
                        swalWithBootstrapButtons.fire(
                            'Gagal!',
                            'Failed to add data',
                            'error'
                        );
                    }
                })
            }
        })

        function editAction(id) {
            $.ajax({
                url: "../controllers/pengeluaran.php",
                type: "post",
                data: {
                    id,
                    type: "edit"
                },
                success: function(val) {
                    let data = $.parseJSON(val);
                    $("#ubahNominal").val(data[0]["nominal"])
                    $("#ubahDate").val(data[0]["tanggal"])
                    $("#ubahCatatan").val(data[0]["catatan"])
                    $("#ubahCategory").val(data[0]["id_kategori"])
                    $("#ubahNominalPemasukan").val(data[0]["nominal"])
                    $("#ubahDatePemasukan").val(data[0]["tanggal"])
                    $("#ubahCatatanPemasukan").val(data[0]["catatan"])
                    $("#ubahCategoryPemasukan").val(data[0]["id_kategori"])
                },
                error: function(data) {
                    swalWithBootstrapButtons.fire(
                        'Gagal!',
                        'Failed to delete your file.',
                        'error'
                    );
                }
            })
        }

        $(".editBtn").on("click", function() {
            currentId = $(this).data("id")
            editAction(currentId)
        })

        function updateAction(data) {
            $.ajax({
                url: "../controllers/pengeluaran.php",
                type: "post",
                data,
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Update Success !',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1600);
                },
                error: function(data) {
                    swalWithBootstrapButtons.fire(
                        'Gagal!',
                        'Failed to delete your file.',
                        'error'
                    );
                }
            })
        }

        $("#ubah").on("click", function(e) {
            e.preventDefault()
            let data = {
                type: "update",
                id: currentId,
                nominal: $("#ubahNominal").val(),
                tanggal: $("#ubahDate").val(),
                catatan: $("#ubahCatatan").val(),
                id_kategori: $("#ubahCategory").val(),
            }
            updateAction(data)
        })

        $("#ubahPemasukan").on("click", function(e) {
            e.preventDefault()
            let data = {
                type: "update",
                id: currentId,
                nominal: $("#ubahNominalPemasukan").val(),
                tanggal: $("#ubahDatePemasukan").val(),
                catatan: $("#ubahCatatanPemasukan").val(),
                id_kategori: $("#ubahCategoryPemasukan").val(),
            }
            updateAction(data)
        })

        $("#simpanIncome").on("click", function(e) {
            e.preventDefault()
            let nominal = $("#nominalIncome").val()
            let tanggal = $("#dateIncome").val()
            let id_kategori = $("#categoryIncome").val()
            let catatan = $("#catatanIncome").val()
            let id_user = <?= $_SESSION["idPengguna"]; ?>;
            if (nominal == '' || tanggal == '' || id_kategori === 'Pilih kategori...') {
                Swal.fire(
                    "Warning!",
                    'Pastikan Semua Data sudah terisi',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "../controllers/pemasukan.php",
                    type: "post",
                    data: {
                        type: "create",
                        nominal,
                        tanggal,
                        id_kategori,
                        catatan,
                        id_user
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1600);
                    },
                    error: function(data) {
                        swalWithBootstrapButtons.fire(
                            'Gagal!',
                            'Failed to add data',
                            'error'
                        );
                    }
                })
            }
        })
    </script>
</body>

</html>
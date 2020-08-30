<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hutang dan Piutang</title>
    <link rel="icon" type="image/png" href="../assets/icon.png"/>
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
    <div class="container py-4">
        <?php
        include_once("../auth/functions.php");
        $db = dbConnect();
        $idPengguna = $_SESSION['idPengguna'];
        $month = date('m');
        $dateNow = date('Y-m-d');
        ?>
        <div class="row">
            <div class="col-12">
                <div class="p-3 rounded-lg shadow-lg">
                    <h3 class="mb-4">Hutang dan Piutang</h3>
                    <div class="mb-4">
                        <button type="button" class="btn btn-info" data-target="#expenseModal" data-toggle="modal">Tambah Hutang</button>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#incomeModal">Tambah Piutang</button>
                    </div>
                    <?php
                    if ($db->connect_errno == 0) {
                        $sql = "SELECT * FROM hutang_piutang WHERE id_user = '$idPengguna'";
                        $res = $db->query($sql);
                        if ($res) {
                    ?>
                            <table id="table_id" class="display nowrap" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nominal</th>
                                        <th>Jenis</th>
                                        <th>Dari/Kepada</th>
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
                                            <td><?= rupiah($val["nominal"]); ?></td>
                                            <td><?= $val["jenis"] ?></td>
                                            <td><?= $val["darike"] ?></td>
                                            <td><?= $val["catatan"] ?></td>
                                            <td>
                                                <button class="btn my-primary text-white btn-sm editBtn" data-toggle="modal" data-target="#updateModal<?= $val["jenis"] ?>" data-id="<?= $val['id'] ?>"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger btn-sm deleteBtn" data-id="<?= $val['id'] ?>"><i class="fa fa-trash"></i></button>
                                                <button class="btn btn-info btn-sm lunasBtn" data-id="<?= $val['id'] ?>"><i class="fa fa-check"></i></button>
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
    <div class="modal fade" id="expenseModal" tabindex="-1" aria-labelledby="expenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Hutang</h5>
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
                            <label for="darike">Kepada</label>
                            <input type="text" class="form-control" id="darike" placeholder="Contoh: Rizki atau Wildan">
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
                    <h5 class="modal-title" id="incomeModalLabel">Tambah Piutang</h5>
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
                            <label for="dariIncome">Dari</label>
                            <input type="text" class="form-control" id="dariIncome" placeholder="Contoh: Rizki atau Wildan">
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
    <div class="modal fade" id="updateModalhutang" tabindex="-1" aria-labelledby="updateModalhutangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalhutangLabel">Ubah Transaksi</h5>
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
                            <label for="ubahKepada">Kepada</label>
                            <input type="text" class="form-control" id="ubahKepada" placeholder="Contoh: 20000">
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
    <div class="modal fade" id="updateModalpiutang" tabindex="-1" aria-labelledby="updateModalpiutangLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalpiutangLabel">Ubah Transaksi</h5>
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
                            <label for="ubahDariPiutang">Dari</label>
                            <input type="text" class="form-control" id="ubahDariPiutang" placeholder="Contoh: 20000">
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
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "../controllers/hutang.php",
                        type: 'post',
                        data: {
                            id,
                            type: 'delete'
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('.item' + id).fadeOut(1500, function() {
                                $(this).remove();
                            });
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 1600);
                        },
                        error: function(data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Transaksi gagal dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            })
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
            let darike = $("#darike").val()
            let catatan = $("#catatan").val()
            const jenis = "hutang"
            let id_user = <?= $_SESSION["idPengguna"]; ?>;
            if (nominal == '' || tanggal == '' || darike == "") {
                Swal.fire(
                    "Peringatan!",
                    'Pastikan Semua Data sudah terisi',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "../controllers/hutang.php",
                    type: "post",
                    data: {
                        type: "create",
                        nominal,
                        tanggal,
                        catatan,
                        darike,
                        jenis,
                        id_user
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1600);
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal menyimpan transaksi',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
            }
        })

        function editAction(id) {
            $.ajax({
                url: "../controllers/hutang.php",
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
                    $("#ubahKepada").val(data[0]["darike"])
                    $("#ubahNominalPemasukan").val(data[0]["nominal"])
                    $("#ubahDatePemasukan").val(data[0]["tanggal"])
                    $("#ubahCatatanPemasukan").val(data[0]["catatan"])
                    $("#ubahDariPiutang").val(data[0]["darike"])
                },
                error: function(data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal mengambil data!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        }

        $(".editBtn").on("click", function() {
            currentId = $(this).data("id")
            editAction(currentId)
        })

        $(".lunasBtn").on("click", function() {
            currentId = $(this).data("id")
            Swal.fire({
                title: 'Lunas?',
                text: "Data yang lunas akan ditambahkan ke data transaksi!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lunas!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "../controllers/hutang.php",
                        type: "post",
                        data: {
                            id: currentId,
                            type: "lunas"
                        },
                        success: function(val) {
                            console.log(val);
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaksi telah lunas!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                window.location.reload(1);
                            }, 1600);
                        },
                        error: function(data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Transaksi gagal diproses!',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    })
                }
            });

        })

        function updateAction(data) {
            if (data.nominal == '' || data.tanggal == '' || data.darike == "") {
                Swal.fire(
                    "Peringatan!",
                    'Pastikan Semua Data sudah terisi',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "../controllers/hutang.php",
                    type: "post",
                    data,
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil mengubah data!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1600);
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal mengubah data!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
            }
        }

        $("#ubah").on("click", function(e) {
            e.preventDefault()
            let data = {
                type: "update",
                id: currentId,
                nominal: $("#ubahNominal").val(),
                tanggal: $("#ubahDate").val(),
                catatan: $("#ubahCatatan").val(),
                darike: $("#ubahKepada").val(),
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
                darike: $("#ubahDariPiutang").val(),
            }
            updateAction(data)
        })

        $("#simpanIncome").on("click", function(e) {
            e.preventDefault()
            let nominal = $("#nominalIncome").val()
            let tanggal = $("#dateIncome").val()
            let darike = $("#dariIncome").val()
            let catatan = $("#catatanIncome").val()
            const jenis = "piutang"
            let id_user = <?= $_SESSION["idPengguna"]; ?>;
            if (nominal == '' || tanggal == '' || darike == '') {
                Swal.fire(
                    "Peringatan!",
                    'Pastikan Semua Data sudah terisi!',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "../controllers/hutang.php",
                    type: "post",
                    data: {
                        type: "create",
                        nominal,
                        tanggal,
                        darike,
                        catatan,
                        jenis,
                        id_user
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Data berhasil disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(function() {
                            window.location.reload(1);
                        }, 1600);
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal menyimpan data!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
            }
        })
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body style="background-color: #F2F4FA;">
    <?php include_once("./components/navbar.php") ?>

    <div class="container py-4">
        <div class="row">
            <div class="col-12 col-md-5 col-lg-4 mb-4">
                <div class="p-3 rounded-lg shadow-lg">
                    <h3>Tambah Kategori</h3>
                    <form>
                        <div class="form-group">
                            <label for="nama">Nama kategori</label>
                            <input type="text" class="form-control" id="nama" required>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe" id="inlineRadio1" value="pengeluaran">
                            <label class="form-check-label" for="inlineRadio1">Pengeluaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe" id="inlineRadio2" value="pemasukan">
                            <label class="form-check-label" for="inlineRadio2">Pemasukan</label>
                        </div>
                        <button id="simpan" class="btn my-primary text-white btn-block mt-3">Simpan</button>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-7 col-lg-8">
                <div class="p-3 rounded-lg shadow-lg">
                    <h3 class="mb-4">Daftar Kategori</h3>
                    <?php
                    include_once("../auth/functions.php");
                    $db = dbConnect();
                    if ($db->connect_errno == 0) {
                        $sql = "SELECT * FROM kategori";
                        $res = $db->query($sql);
                        if ($res) {
                    ?>
                            <table id="table_id" class="display">
                                <thead>
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <th>Tipe</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $data = $res->fetch_all(MYSQLI_ASSOC);
                                    foreach ($data as $val) {
                                    ?>
                                        <tr class="item<?= $val['id'] ?>">
                                            <td><?php echo $val["nama_kategori"] ?></td>
                                            <td class="<?= $val['tipe'] == "pemasukan" ? "text-success" : "text-danger" ?>"><?php echo $val["tipe"] ?></td>
                                            <td>
                                                <button class="btn my-primary text-white btn-sm editBtn" data-toggle="modal" data-target="#updateModal" data-id="<?= $val['id'] ?>"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger btn-sm btn_delete" data-id="<?= $val['id'] ?>"><i class="fa fa-trash"></i></button>
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
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Ubah kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editNama">Nama kategori</label>
                            <input type="text" class="form-control" id="editNama" required>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="editTipe" id="radio1" value="pengeluaran">
                            <label class="form-check-label" for="radio1">Pengeluaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="editTipe" id="radio2" value="pemasukan">
                            <label class="form-check-label" for="radio2">Pemasukan</label>
                        </div>
                        <button id="ubah" class="btn my-primary text-white btn-block mt-3">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        let namaPengguna = '<?= $_SESSION["nama"] ?>';
        let idPengguna = '<?= $_SESSION["idPengguna"] ?>';
    </script>
    <script src="../assets/app.js"></script>
    <script>
        $(document).ready(function() {
            let currentId
            $('#table_id').DataTable();
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
                        url: "../controllers/kategori.php",
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

        $('.btn_delete').on('click', function() {
            deleteAction($(this).data('id'));
        });

        $('#simpan').on('click', function(e) {
            e.preventDefault()
            let nama_kategori = $('#nama').val()
            let tipe = $("input[name='tipe']:checked").val();
            if (nama_kategori == '' || tipe == undefined) {
                Swal.fire(
                    'Warning!',
                    'Pastikan Semua Data sudah terisi',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "../controllers/kategori.php",
                    type: "post",
                    data: {
                        type: "create",
                        nama_kategori,
                        tipe
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

        $(".editBtn").on('click', function() {
            currentId = $(this).data('id')
            editAction($(this).data('id'));
        })

        $("#ubah").on('click', function(e) {
            e.preventDefault()
            $.ajax({
                url: "../controllers/kategori.php",
                type: "post",
                data: {
                    type: "update",
                    id: currentId,
                    nama_kategori: $("#editNama").val(),
                    tipe: $("input[name='editTipe']:checked").val()
                },
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
        })

        function editAction(id) {
            $.ajax({
                url: "../controllers/kategori.php",
                type: "post",
                data: {
                    id,
                    type: "edit"
                },
                success: function(val) {
                    let data = $.parseJSON(val);
                    $("#editNama").val(data[0]["nama_kategori"])
                    data[0]["tipe"] == "pengeluaran" ? $("#radio1").prop("checked", true) : $("#radio2").prop("checked", true)
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
    </script>
</body>

</html>
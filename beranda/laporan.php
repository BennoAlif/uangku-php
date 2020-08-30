<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
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
        <div class="row">
            <?php
            include_once("../auth/functions.php");
            $db = dbConnect();
            $idPengguna = $_SESSION['idPengguna'];
            $month = date('m');
            $dateNow = date('Y-m-d');
            ?>
            <div class="col-12">
                <div class="p-3 rounded-lg shadow-lg">
                    <h3 class="mb-4">Detail Semua Transaksi</h3>
                    <div class="form-group" style="max-width: 240px;">
                        <label for="monthInput">Filter bulan</label>
                        <input type="month" class="form-control" id="monthInput">
                    </div>
                    <button type="button" class="btn btn-info mb-5 cetakLaporan">Cetak Laporan Per Bulan</button>
                    <?php
                    if ($db->connect_errno == 0) {
                        $sql = "SELECT transaksi.id, nominal, jenis, tanggal, catatan, nama_kategori, tipe FROM transaksi JOIN kategori ON transaksi.id_kategori = kategori.id WHERE id_user = '$idPengguna'";
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.9/jspdf.plugin.autotable.min.js" integrity="sha512-6oCyRRRdXAgfXITH/5iavIaxb2x6QO8diA4/VgWBlin77Z07IPjzJPyrQ4+22zyd58pE5q/ma/ogHtlG/2gdPg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" integrity="sha512-rmZcZsyhe0/MAjquhTgiUcb4d9knaFc7b5xAfju483gbEXTkeJRUMIPk6s3ySZMYUHEcjKbjLjyddGWMrNEvZg==" crossorigin="anonymous"></script>
    <script>
        let namaPengguna = '<?= $_SESSION["nama"] ?>';
        let idPengguna = '<?= $_SESSION["idPengguna"] ?>';
    </script>
    <script src="../assets/app.js"></script>

    <script>
        $(document).ready(function() {
            let currentId
            let month = $("#monthInput").val()

            const columns = [{
                    title: "Tanggal",
                    dataKey: "tanggal"
                },
                {
                    title: "Nominal (Rp.)",
                    dataKey: "nominal"
                },
                {
                    title: "Jenis",
                    dataKey: "jenis"
                },
                {
                    title: "Kategori",
                    dataKey: "nama_kategori"
                },
                {
                    title: "Catatan",
                    dataKey: "catatan"
                },
            ];
            $("#monthInput").change(function() {
                month = $("#monthInput").val()
            })
            let table = $('#table_id').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true
            });
            $('#monthInput').change(function() {
                table.search($(this).val()).draw();
            })

            $(".cetakLaporan").on("click", function() {
                !month ? month = '<?= date("Y-m") ?>' : month;
                $.ajax({
                    url: "../controllers/pengeluaran.php",
                    method: "post",
                    data: {
                        type: "getByMonth",
                        id: idPengguna,
                        month
                    },
                    success: function(data) {
                        let datas = JSON.parse(data)
                        let totalPemasukan = hitungTotalPemasukan(datas)
                        let totalPengeluaran = hitungTotalPengeluaran(datas)
                        let rupiahPemasukan = rupiahFormat(totalPemasukan)
                        let rupiahPengeluaran = rupiahFormat(totalPengeluaran)
                        const doc = new jsPDF("p", "pt");
                        doc.setDrawColor(0)
                        doc.setFillColor(148, 167, 219)
                        doc.rect(0, 0, 800, 56, 'F')
                        doc.setFontSize(24)
                        doc.setTextColor(255, 255, 255)
                        doc.text('UANGKU', 20, 30)
                        doc.setFontSize(10)
                        doc.text('Sistem Informasi Anda', 20, 45)
                        doc.setFontSize(24)
                        doc.setFontType('bold');
                        doc.setTextColor(0, 0, 0)
                        doc.text('Laporan Keuangan', 40, 90)
                        doc.setFontSize(11)
                        doc.setTextColor(100)
                        doc.setFontType('normal');
                        doc.text("Periode : " + moment(month).format('MMMM YYYY'), 40, 110)
                        doc.text("Pemilik : <?= $_SESSION["nama"] ?>", 40, 130)
                        doc.text("Email : <?= $_SESSION["email"] ?>", 40, 150)
                        doc.setTextColor(40, 170, 100)
                        doc.setFontType('bold');
                        doc.text("Total Pemasukan : " + rupiahPemasukan, 40, 170)
                        doc.setTextColor(231, 76, 60)
                        doc.text("Total Pengeluaran : " + rupiahPengeluaran, 40, 190)

                        doc.autoTable(columns, datas, {
                            didParseCell: function(data) {
                                if (data.cell.raw == "pemasukan") {
                                    data.cell.styles.fillColor = [40, 170, 100]
                                    data.cell.styles.textColor = [255, 255, 255]
                                } else if (data.cell.raw == "pengeluaran") {
                                    data.cell.styles.fillColor = [231, 76, 60]
                                    data.cell.styles.textColor = [255, 255, 255]
                                }
                            },
                            margin: {
                                top: 210
                            },
                        });
                        doc.save(`Laporan keuangan bulan ${moment(month).format('MMMM YYYY')}`)
                    }
                })
            })
        });

        function rupiahFormat(data) {
            const formatter = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                minimumFractionDigits: 2,
            });
            return formatter.format(data);
        }

        function hitungTotalPemasukan(data) {
            return filterDataPemasukan(data).reduce(function(prev, cur) {
                return prev + parseInt(cur.nominal);
            }, 0);
        }

        function hitungTotalPengeluaran(data) {
            return filterDataPengeluaran(data).reduce(function(prev, cur) {
                return prev + parseInt(cur.nominal);
            }, 0);
        }

        function filterDataPengeluaran(data) {
            return data.filter(function(e) {
                return e.jenis == "pengeluaran"
            })
        }

        function filterDataPemasukan(data) {
            return data.filter(function(e) {
                return e.jenis == "pemasukan"
            })
        }

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
                        url: "../controllers/pengeluaran.php",
                        type: 'post',
                        data: {
                            id,
                            type: 'delete'
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaksi berhasil dihapus',
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

        function updateAction(data) {
            if (data.nominal == '' || data.tanggal == '' || data.id_kategori === 'Pilih kategori...') {
                Swal.fire(
                    "Peringatan!",
                    'Pastikan Semua Data sudah terisi',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "../controllers/pengeluaran.php",
                    type: "post",
                    data,
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil mengubah transaksi!',
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
    </script>
</body>

</html>
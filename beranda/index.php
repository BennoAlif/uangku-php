<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body style="background-color: #F2F4FA;">
    <?php include_once("./components/navbar.php") ?>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 col-md-5 col-lg-4 mb-4">
                <div class="p-3 rounded-lg shadow-lg">
                    <h3 class="mb-4">Transaksi</h3>
                    <div class="row">
                        <div class="col-6">
                            <small>Pemasukan</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-right text-success">20.000</h4>
                        </div>
                        <div class="col-6">
                            <small>Pengeluaran</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-right my-text-danger">20.000</h4>
                        </div>
                    </div>
                    <hr />
                    <h3 class="text-right text-primary mb-4">40.000</h3>
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
                                            <select class="form-control" id="category">
                                                <option>Pilih kategori...</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="catatan">Catatan</label>
                                            <textarea class="form-control" id="catatan" rows="3" placeholder="Contoh: Makan nasi padang"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="button" class="btn btn-primary">Simpan</button>
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
                                            <select class="form-control" id="categoryIncome">
                                                <option>Pilih kategori...</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="catatanIncome">Catatan</label>
                                            <textarea class="form-control" id="catatanIncome" rows="3" placeholder="Contoh: Makan nasi padang"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7 col-lg-8">
                <div class="p-3 rounded-lg shadow-lg">
                    <h3 class="mb-4">Detail Transaksi Bulan Agustus 2020</h3>
                    <canvas id="myChart" class="mb-5 dashboard-chart"></canvas>
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
                            <tr>
                                <td>Row 1 Data 1</td>
                                <td>Row 1 Data 2</td>
                                <td>Row 1 Data 1</td>
                                <td>Row 1 Data 2</td>
                                <td>Row 1 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                                <td>Row 2 Data 1</td>
                                <td>Row 2 Data 2</td>
                                <td>Row 2 Data 2</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha512-s+xg36jbIujB2S2VKfpGmlC3T5V2TF3lY48DX7u2r9XzGzgPsa6wTpOQA7J9iffvdeBN0q9tKzRxVxw1JviZPg==" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true
            });
        });
    </script>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                        label: 'Pemasukan',
                        data: [11, 16, 7, 5, 1, 4],
                        backgroundColor: 'rgba(33, 139, 56, 0.2)',
                        borderColor: 'rgba(33, 139, 56, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                ]
            },
            options: {
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>
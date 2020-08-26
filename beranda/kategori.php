<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
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
                            <label for="name">Nama kategori</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="pengeluaran">
                            <label class="form-check-label" for="inlineRadio1">Pengeluaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="pemasukan">
                            <label class="form-check-label" for="inlineRadio2">Pemasukan</label>
                        </div>
                        <button type="submit" class="btn my-primary text-white btn-block mt-3">Simpan</button>
                    </form>
                </div>
            </div>
            <div class="col-12 col-md-7 col-lg-8">
                <div class="p-3 rounded-lg shadow-lg">
                    <h3 class="mb-4">Daftar Kategori</h3>
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th>Nama Kategori</th>
                                <th>Tipe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Row 1 Data 1</td>
                                <td>Row 1 Data 2</td>
                            </tr>
                            <tr>
                                <td>Row 2 Data 1</td>
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
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();
        });
    </script>
</body>

</html>
<?php
define("DEVELOPMENT", TRUE);

function dbConnect()
{
    $db = new mysqli("localhost", "root", "", "db_uangku_php");
    // $db = new mysqli("jatayu.dnsbit.net", "dystopia_uangku", "adminadmin", "dystopia_uangku");
    return $db;
}

function rupiah($angka)
{

    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function POST($input)
{
    return mysqli_real_escape_string(dbConnect(), htmlspecialchars(rtrim(ltrim($_POST[$input]))));
}

function showError($message)
{
?>
    <div class="alert alert-danger" role="alert">
        <?php echo $message; ?>
    </div>
<?php
}

?>
<?php
define("DEVELOPMENT", TRUE);

function dbConnect()
{
    $db = new mysqli("localhost", "root", "", "db_uangku_php");
    return $db;
}

function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
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
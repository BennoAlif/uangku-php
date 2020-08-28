<?php
include_once("../auth/functions.php");
$db = dbConnect();

$type = $_POST["type"];
$id = $_POST["id"];

if($type == "create"){
    $nominal = $_POST["nominal"];
    $tanggal = $_POST["tanggal"];
    $id_kategori = $_POST["id_kategori"];
    $catatan = $_POST["catatan"];
    $id_user = $_POST["id_user"];

    $sql = "INSERT INTO transaksi (nominal, jenis, tanggal, catatan, id_kategori, id_user) VALUES ('$nominal', 'pemasukan', '$tanggal', '$catatan', '$id_kategori', '$id_user')";
    $db->query($sql);
}
?>
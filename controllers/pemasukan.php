<?php
include_once("../auth/functions.php");
$db = dbConnect();

$type = $db->escape_string($_POST["type"]);
$id = $db->escape_string($_POST["id"]);

if($type == "create"){
    $nominal = $db->escape_string($_POST["nominal"]);
    $tanggal = $db->escape_string($_POST["tanggal"]);
    $id_kategori = $db->escape_string($_POST["id_kategori"]);
    $catatan = $db->escape_string($_POST["catatan"]);
    $id_user = $db->escape_string($_POST["id_user"]);

    $sql = "INSERT INTO transaksi (nominal, jenis, tanggal, catatan, id_kategori, id_user) VALUES ('$nominal', 'pemasukan', '$tanggal', '$catatan', '$id_kategori', '$id_user')";
    $db->query($sql);
}
?>
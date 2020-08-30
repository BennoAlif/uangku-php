<?php
include_once("../auth/functions.php");
$db = dbConnect();

$type = POST("type");
$id = POST("id");

if($type == "create"){
    $nominal = POST("nominal");
    $tanggal = POST("tanggal");
    $id_kategori = POST("id_kategori");
    $catatan = POST("catatan");
    $id_user = POST("id_user");

    $sql = "INSERT INTO transaksi (nominal, jenis, tanggal, catatan, id_kategori, id_user) VALUES ('$nominal', 'pemasukan', '$tanggal', '$catatan', '$id_kategori', '$id_user')";
    $db->query($sql);
}

<?php
include_once("../auth/functions.php");
$db = dbConnect();

$type = $db->escape_string($_POST["type"]);
$id = $db->escape_string($_POST["id"]);

if ($type == "delete") {
    $db->query("DELETE FROM kategori WHERE id = '$id'");
} else if ($type == "edit") {
    $res = $db->query("SELECT * FROM kategori WHERE id = '$id'");
    while ($row = $res->fetch_assoc()) {
        $output[] = array(
            "id" => $row["id"],
            "nama_kategori" => $row["nama_kategori"],
            "tipe" => $row["tipe"]
        );
    }
    echo json_encode($output);
} else if ($type == "update") {
    $id = $db->escape_string($_POST["id"]);
    $nama_kategori = $db->escape_string($_POST["nama_kategori"]);
    $tipe = $db->escape_string($_POST["tipe"]);
    $db->query("UPDATE kategori SET nama_kategori = '$nama_kategori', tipe = '$tipe' WHERE id = '$id'");
} else if ($type == "create") {
    $nama_kategori = $db->escape_string($_POST["nama_kategori"]);
    $tipe = $db->escape_string($_POST["tipe"]);
    $db->query("INSERT INTO kategori (nama_kategori, tipe) VALUES ('$nama_kategori', '$tipe')");
}

<?php
include_once("../auth/functions.php");
$db = dbConnect();

$type = $_POST["type"];
$id = $_POST["id"];

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
    $id = $_POST["id"];
    $nama_kategori = $_POST["nama_kategori"];
    $tipe = $_POST["tipe"];
    $db->query("UPDATE kategori SET nama_kategori = '$nama_kategori', tipe = '$tipe' WHERE id = '$id'");
} else if ($type == "create") {
    $nama_kategori = $_POST["nama_kategori"];
    $tipe = $_POST["tipe"];
    $db->query("INSERT into kategori (nama_kategori, tipe) VALUES ('$nama_kategori', '$tipe')");
}

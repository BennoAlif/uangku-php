<?php
include_once("../auth/functions.php");
$db = dbConnect();

$type = $_POST["type"];
$id = $_POST["id"];

if ($type == "delete") {
    $db->query("DELETE FROM transaksi WHERE id = '$id'");
} else if ($type == "edit") {
    $res = $db->query("SELECT * FROM transaksi WHERE id = '$id'");
    while ($row = $res->fetch_assoc()) {
        $output[] = array(
            "id" => $row["id"],
            "nominal" => $row["nominal"],
            "tanggal" => $row["tanggal"],
            "catatan" => $row["catatan"],
            "id_kategori" => $row["id_kategori"],
        );
    }
    echo json_encode($output);
} else if ($type == "update") {
    $id = $_POST["id"];
    $nominal = $_POST["nominal"];
    $tanggal = $_POST["tanggal"];
    $id_kategori = $_POST["id_kategori"];
    $catatan = $_POST["catatan"];
    $db->query("UPDATE transaksi SET nominal = '$nominal', tanggal = '$tanggal', id_kategori = '$id_kategori', catatan = '$catatan' WHERE id = '$id'");
} else if ($type == "create") {
    $nominal = $_POST["nominal"];
    $tanggal = $_POST["tanggal"];
    $id_kategori = $_POST["id_kategori"];
    $catatan = $_POST["catatan"];
    $id_user = $_POST["id_user"];

    $sql = "INSERT INTO transaksi (nominal, jenis, tanggal, catatan, id_kategori, id_user) VALUES ('$nominal', 'pengeluaran', '$tanggal', '$catatan', '$id_kategori', '$id_user')";
    $db->query($sql);
}
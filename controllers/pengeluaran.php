<?php
include_once("../auth/functions.php");
$db = dbConnect();

$type = POST("type");
$id = POST("id");

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
    $id = POST("id");
    $nominal = POST("nominal");
    $tanggal = POST("tanggal");
    $id_kategori = POST("id_kategori");
    $catatan = POST("catatan");
    $db->query("UPDATE transaksi SET nominal = '$nominal', tanggal = '$tanggal', id_kategori = '$id_kategori', catatan = '$catatan' WHERE id = '$id'");
} else if ($type == "create") {
    $nominal = POST("nominal");
    $tanggal = POST("tanggal");
    $id_kategori = POST("id_kategori");
    $catatan = POST("catatan");
    $id_user = POST("id_user");

    $sql = "INSERT INTO transaksi (nominal, jenis, tanggal, catatan, id_kategori, id_user) VALUES ('$nominal', 'pengeluaran', '$tanggal', '$catatan', '$id_kategori', '$id_user')";
    $db->query($sql);
} else if ($type == "getByMonth") {
    $month = $_POST["month"];
    $id = $_POST["id"];
    if ($db->connect_errno == 0) {
        $res = $db->query("SELECT transaksi.id, nominal, jenis, tanggal, catatan, nama_kategori, tipe FROM transaksi JOIN kategori ON transaksi.id_kategori = kategori.id WHERE id_user = '$id' AND tanggal LIKE '$month%'");
        if ($res) {
            $data = $res->fetch_all(MYSQLI_ASSOC);
            $res->free();
            echo json_encode($data);
        } else
            echo FALSE;
    } else
        echo FALSE;
}

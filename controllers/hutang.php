<?php
include_once("../auth/functions.php");
$db = dbConnect();

$type = POST("type");
$id = POST("id");

if ($type == "delete") {
    $db->query("DELETE FROM hutang_piutang WHERE id = '$id'");
} else if ($type == "lunas") {
    $res = $db->query("SELECT * FROM hutang_piutang WHERE id = '$id'");
    while ($row = $res->fetch_assoc()) {
        $output[] = array(
            "id" => $row["id"],
            "nominal" => $row["nominal"],
            "tanggal" => $row["tanggal"],
            "catatan" => $row["catatan"],
            "darike" => $row["darike"],
            "jenis" => $row["jenis"],
            "id_user" => $row["id_user"],
        );
    }

    $nominal = $output[0]["nominal"];
    $tanggal = $output[0]["tanggal"];
    $darike = $output[0]["darike"];
    $catatan = $output[0]["catatan"];
    $id_user = $output[0]["id_user"];
    $jenis = $output[0]["jenis"];
    $jenisTransaksi = $jenis == "hutang" ? "pengeluaran" : "pemasukan";
    $kategori = $jenis == "hutang" ? "7" : "8";
    $sambung = $jenis == "hutang" ? "kepada" : "dari";
    $sql = "INSERT INTO transaksi (nominal, jenis, tanggal, catatan, id_kategori, id_user) VALUES ('$nominal', '$jenisTransaksi', '$tanggal', '$jenis $sambung $darike. $catatan', '$kategori', '$id_user')";
    $db->query($sql);
    $db->query("DELETE FROM hutang_piutang WHERE id = '$id'");
} else if ($type == "edit") {
    $res = $db->query("SELECT * FROM hutang_piutang WHERE id = '$id'");
    while ($row = $res->fetch_assoc()) {
        $output[] = array(
            "id" => $row["id"],
            "nominal" => $row["nominal"],
            "tanggal" => $row["tanggal"],
            "catatan" => $row["catatan"],
            "darike" => $row["darike"],
        );
    }
    echo json_encode($output);
} else if ($type == "update") {
    $id = POST("id");
    $nominal = POST("nominal");
    $tanggal = POST("tanggal");
    $darike = POST("darike");
    $catatan = POST("catatan");
    $db->query("UPDATE hutang_piutang SET nominal = '$nominal', tanggal = '$tanggal', darike = '$darike', catatan = '$catatan' WHERE id = '$id'");
} else if ($type == "create") {
    $nominal = POST("nominal");
    $tanggal = POST("tanggal");
    $darike = POST("darike");
    $catatan = POST("catatan");
    $id_user = POST("id_user");
    $jenis = POST("jenis");

    $sql = "INSERT INTO hutang_piutang (nominal, jenis, tanggal, catatan, darike, id_user) VALUES ('$nominal', '$jenis', '$tanggal', '$catatan', '$darike', '$id_user')";
    $db->query($sql);
}

<?php
include_once("../auth/functions.php");
$db = dbConnect();

$type = POST("type");
$id = POST("id");

if ($type == "delete") {
    $res = $db->query("DELETE FROM kategori WHERE id = '$id'");
    if ($res) {
        $response_array['status'] = 'success';
    } else {
        $response_array['status'] = 'failed';
    }
    echo json_encode($response_array);
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
    $id = POST("id");
    $nama_kategori = POST("nama_kategori");
    $tipe = POST("tipe");
    $db->query("UPDATE kategori SET nama_kategori = '$nama_kategori', tipe = '$tipe' WHERE id = '$id'");
} else if ($type == "create") {
    $nama_kategori = POST("nama_kategori");
    $tipe = POST("tipe");
    $db->query("INSERT INTO kategori (nama_kategori, tipe) VALUES ('$nama_kategori', '$tipe')");
}

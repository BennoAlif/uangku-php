<?php
include_once("../auth/functions.php");
$db = dbConnect();
session_start();

$type = POST("type");
$id = POST("id");

if ($type == "delete") {
    $db->query("DELETE FROM pengguna WHERE id = '$id'");
    session_destroy();
    header("Location: ../index.php");
} else if ($type == "update") {
    $id = POST("id");
    $nama = POST("nama");
    $oldPassword = POST("oldPassword");
    $newPassword = POST("newPassword");
    if (empty($oldPassword) || empty($newPassword)) {
        $db->query("UPDATE pengguna SET nama = '$nama' WHERE id = '$id'");
        $response_array['status'] = 'success';
        $_SESSION["nama"] = $nama;
    } else {
        $res = $db->query("SELECT * FROM pengguna WHERE id = '$id'");
        $data = $res->fetch_assoc();
        if (md5($oldPassword) == $data["pass"]) {
            $db->query("UPDATE pengguna SET nama = '$nama', pass = MD5('$newPassword') WHERE id = '$id'");
            $_SESSION["nama"] = $nama;
            $response_array['status'] = 'success';
        } else {
            $response_array['status'] = 'error';
        }
    }
    header('Content-type: application/json');
    echo json_encode($response_array);
} else if ($type == "create") {
    $email = POST("email");
    $nama = POST("nama");
    $password = POST("password");
    $res = $db->query("SELECT * FROM pengguna WHERE email = '$email'");
    if ($res) {
        if ($res->num_rows == 1) {
            die(header("HTTP/1.0 409 Conflict"));
        } else
            $db->query("INSERT INTO pengguna (email, nama, pass) VALUES ('$email', '$nama', md5('$password'))");
    }
}

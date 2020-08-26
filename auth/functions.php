<?php
define("DEVELOPMENT", TRUE);

function dbConnect()
{
    $db = new mysqli("localhost", "root", "", "db_uangku_php");
    return $db;
}

// function getListKategori()
// {
//     $db = dbConnect();
//     if ($db->connect_errno == 0) {
//         $res = $db->query("SELECT  * FROM kategori ORDER BY IdKategori");
//         if ($res) {
//             $data = $res->fetch_all(MYSQLI_ASSOC);
//             $res->free();
//             return $data;
//         } else
//             return FALSE;
//     } else
//         return FALSE;
// }

function showError($message)
{
?>
    <div class="alert alert-danger" role="alert">
        <?php echo $message; ?>
    </div>
<?php
}

?>
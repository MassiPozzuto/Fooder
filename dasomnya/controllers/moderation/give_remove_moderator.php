<?php
require_once "../../server/config.php";

// Pregunto si es moderador
$sqlVerifyMod = "SELECT * FROM profiles WHERE role_id= 3 AND user_id = " . $_GET['User']. " ";
$resVerifyMod = mysqli_query($conn, $sqlVerifyMod);
if (!$resVerifyMod) {
   die('Error de Consulta ' . mysqli_error($conn));
}

if (mysqli_num_rows($resVerifyMod) == 0) {
    // Le doy moderador
    $sqlGiveMod = "UPDATE profiles SET role_id = 3 WHERE user_id ='" . $_GET['User']. "'";
    $resGiveMod = mysqli_query($conn, $sqlGiveMod);
    if (!$resGiveMod) {
       die('Error de Consulta ' . mysqli_error($conn));
    }
} else {
    // Le quito el moderador
    $sqlRemoveMod = "UPDATE profiles SET role_id = 2 WHERE user_id ='" . $_GET['User']. "'";
    $resRemoveMod = mysqli_query($conn, $sqlRemoveMod);
    if (!$resRemoveMod) {
       die('Error de Consulta ' . mysqli_error($conn));
    }
}

header("Location:" . $_SERVER['HTTP_REFERER']);

?>
<?php 
require_once "../../server/config.php";

$sqlDeleteUser = "UPDATE users SET desactivation_date=NOW() WHERE ID = '". $_GET['User'] . "'";

$resultDeleteUser = mysqli_query($conn, $sqlDeleteUser);

if(!$resultDeleteUser){
    die("Error de consulta: " . mysqli_error($conn));
} else{
    $sqlUpdateStatus = "UPDATE moderationlogusers SET moderationStatus_ID=2 WHERE Affected_User_ID = '". $_GET['User'] . "'";
    $resultUpdateStatus = mysqli_query($conn, $sqlUpdateStatus);
    if(!$resultUpdateStatus){
        die("Error de segunda consulta: " . mysqli_error($conn));
    }
    header("Location: ../../controllers/moderacion.php");
}
?>
<?php 
require_once "../../server/config.php";

$sqlDeleteUser = "UPDATE comments SET deleted_at=NOW() WHERE c_ID = '". $_GET['com'] . "'";

$resultDeleteUser = mysqli_query($conn, $sqlDeleteUser);

if(!$resultDeleteUser){
    die("Error de consulta: " . mysqli_error($conn));
} else{
    $sqlUpdateStatus = "UPDATE moderationlogcomment SET moderationStatus_ID = 2 WHERE MC_ID = '". $_GET['id'] . "'";
    $resultUpdateStatus = mysqli_query($conn, $sqlUpdateStatus);
    if(!$resultUpdateStatus){
        die("Error de segunda consulta: " . mysqli_error($conn));
    }
    header("Location: ../../controllers/moderacion.php");
}
?>
<?php 
require_once "../../server/config.php";


    $sqlUpdateStatus = "DELETE FROM moderationlogcomment WHERE MC_ID = '". $_GET['id'] . "'";
    $resultUpdateStatus = mysqli_query($conn, $sqlUpdateStatus);
    if(!$resultUpdateStatus){
        die("Error de segunda consulta: " . mysqli_error($conn));
    }
    header("Location: ../../controllers/moderacion.php");

?>
<?php
require_once "../../server/config.php";
if ($_GET['type'] == 'ban') {
    $sqlBanUser = "UPDATE users SET reactivation_at = DATE_ADD(NOW(), INTERVAL 7 DAY) WHERE ID = '" . $_GET['User'] . "'";
    $resultBanUser = mysqli_query($conn, $sqlBanUser);
    if (!$resultBanUser) {
        die("Error de consulta primera consulta: " . mysqli_errno($conn));
    }
    $sqlUpdateStatus = "UPDATE moderationlogusers SET moderationStatus_ID=2 WHERE Affected_User_ID = '" . $_GET['User'] . "'";
    $resultUpdateStatus = mysqli_query($conn, $sqlUpdateStatus);
    if (!$resultUpdateStatus) {
        die("Error de segunda consulta: " . mysqli_error($conn));
    }
}
if($_GET['type'] == 'reactivate'){
    $sqlReactivateUser ="UPDATE users SET desactivation_date = NULL, reactivation_at = NULL WHERE ID = '".$_GET['User'] . "'";
    $resultReactivateUser= mysqli_query($conn, $sqlReactivateUser);
    if(!$resultReactivateUser){
        die("Error de tercera consulta: " . mysqli_error($conn));
    }
}

header("Location:" . $_SERVER['HTTP_REFERER']);

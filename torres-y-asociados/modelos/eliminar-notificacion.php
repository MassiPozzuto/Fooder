<?php
    require_once "../includes/config.php";
    
    $notificacion = $_GET['id'];

    $sql = "UPDATE notificaciones SET fecha_baja = NOW() WHERE id = $notificacion";
    if(!mysqli_query($conn, $sql)){
        die(mysqli_error($conn));
    }
    echo 1;
?>
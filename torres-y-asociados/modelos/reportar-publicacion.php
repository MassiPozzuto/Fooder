<?php
    require_once "../includes/config.php";

    $publicacion = $_GET['id'];
    $user_report = $_GET['idU'];
    $desc = $_POST['desc'];

    $sql = "SELECT * FROM reportes_publicacion WHERE usuario_id = $user_report AND publicacion_id = $publicacion";
    $reporte = mysqli_query($conn, $sql);
    if(!$reporte){
        die(mysqli_error($conn));
    }

    if(mysqli_num_rows($reporte) == 1){
        $sql2 = "DELETE FROM reportes_publicacion WHERE usuario_id = $user_report AND publicacion_id = $publicacion";
        if(!mysqli_query($conn, $sql2)){
            die(mysqli_error($conn));
        }
    }

    if(mysqli_num_rows($reporte) == 0){
        $sql3 = "INSERT INTO reportes_publicacion VALUES (NULL, $user_report, $publicacion, '$desc', NOW())";
        if(!mysqli_query($conn, $sql3)){
            die(mysqli_error($conn));
        }
    }
?>
<?php
    require_once "../includes/config.php";

    $comentario = $_GET['id'];
    $user_report = $_GET['idU'];
    $desc = $_POST['desc'];

    $sql = "SELECT * FROM reportes_comentario WHERE usuario_id = $user_report AND comentario_id = $comentario";
    $reporte = mysqli_query($conn, $sql);
    if(!$reporte){
        die(mysqli_error($conn));
    }

    if(mysqli_num_rows($reporte) == 1){
        $sql2 = "DELETE FROM reportes_comentario WHERE usuario_id = $user_report AND comentario_id = $comentario";
        if(!mysqli_query($conn, $sql2)){
            die(mysqli_error($conn));
        }
    }

    if(mysqli_num_rows($reporte) == 0){
        $sql3 = "INSERT INTO reportes_comentario VALUES (NULL, $user_report, $comentario, '$desc', NOW())";
        if(!mysqli_query($conn, $sql3)){
            die(mysqli_error($conn));
        }
    }
?>
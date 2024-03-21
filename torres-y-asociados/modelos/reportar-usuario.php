<?php
    require_once "../includes/config.php";

    $reportado = $_GET['id'];
    $reportante = $_GET['idU'];
    $desc = $_POST['desc'];

    $sql = "SELECT * FROM reportes_usuario WHERE destinatario_id = $reportado AND usuario_id = $reportante";
    $reporte = mysqli_query($conn, $sql);
    if(!$reporte){
        die(mysqli_error($conn));
    }

    if(mysqli_num_rows($reporte) == 1){
        $sql2 = "DELETE FROM reportes_usuario WHERE destinatario_id = $reportado AND usuario_id = $reportante";
        if(!mysqli_query($conn, $sql2)){
            die(mysqli_error($conn));
        }
    }

    if(mysqli_num_rows($reporte) == 0){
        $sql3 = "INSERT INTO reportes_usuario VALUES (NULL, $reportado, $reportante, '$desc', NOW())";
        if(!mysqli_query($conn, $sql3)){
            die(mysqli_error($conn));
        }
    }
?>
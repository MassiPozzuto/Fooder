<?php
    session_start();

    require_once "../../includes/config.php";
    
    if (isset($_SESSION['usuario_id'])) {
        $consultaUsur = "SELECT * FROM usuarios WHERE id = " . $_SESSION['usuario_id'] . ";";
        $resultUsur = mysqli_query($conn, $consultaUsur);
        if(!$resultUsur){
            die(mysqli_error($conn));
        }

        if (mysqli_num_rows($resultUsur) > 0) {
            $usu_info = mysqli_fetch_assoc($resultUsur);
            $user = $usu_info;
        }
    }else{
        header("Location: login.php");
    }

    $sql_report = 'SELECT * FROM reportes_publicacion WHERE usuario_id = ' . $user['id'] . '';
    $res_report = mysqli_fetch_all(mysqli_query($conn, $sql_report), MYSQLI_ASSOC);

    echo json_encode($res_report);
?>
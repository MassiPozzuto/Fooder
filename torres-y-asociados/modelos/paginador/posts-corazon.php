<?php
    session_start();
    
    require_once "../../includes/config.php";
    
    //require_once "../../modelos/usuario-actual.php";

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

    $publicacionId = $_GET['postId'];
    $post_usuario = $_GET['usuId'];

    $post_id = "?idP=".$publicacionId . "&id=". $post_usuario;
    
    $query = "SELECT * FROM `publicaciones_likes` WHERE usuario_id = ".$user['id']." AND publicacion_id = " . $publicacionId;
    $result = mysqli_query($conn,$query);
    
    if(!$result){
        die('Error de Consulta' . mysqli_error($conn));
    }
    
    if(mysqli_num_rows($result) == 1){
        echo('<img src="'.RUTA.'/img/corazon.png" align="right" style="display: block;" id="'. $post_id .'">');
    }else{
        echo('<img src="'.RUTA.'/img/corazonvacio.png" align="right" style="display: block;" id="'. $post_id .'">');
    }
?>
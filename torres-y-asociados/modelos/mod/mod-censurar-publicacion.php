<?php
    require_once "../../includes/config.php";

    $publicacion = $_GET['id'];
    $censurar = $_GET['cens'];

    if($censurar == 'off'){
        // Publicaciones - Censurar Publicaciones
        $queryCensurarPublicaciones = "UPDATE publicaciones
        SET censura = 'on'
        WHERE id = '" . $publicacion . "'
        ";

        if(!mysqli_query($conn, $queryCensurarPublicaciones)){
            die(mysqli_error($conn));
        }
    }else{
        // Publicaciones - Descensurar Publicaciones
        $queryDescensurarPublicaciones = "UPDATE publicaciones
        SET censura = 'off'
        WHERE id = '" . $publicacion . "'
        ";

        if(!mysqli_query($conn, $queryDescensurarPublicaciones)){
            die(mysqli_error($conn));
        }
    }

    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
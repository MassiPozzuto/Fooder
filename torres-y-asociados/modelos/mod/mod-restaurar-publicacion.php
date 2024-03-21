<?php
    require_once "../../includes/config.php";

    $publicacion = $_GET['id'];

    // Publicaciones - Restaurar Publicaciones
    $queryRestaurarPublicaciones = "UPDATE publicaciones SET fecha_baja = null WHERE id = " . $publicacion;

    if(!mysqli_query($conn, $queryRestaurarPublicaciones)){
        die(mysqli_error($conn));
    }

    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
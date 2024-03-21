<?php
    require_once "../../includes/config.php";

    $publicacion = $_GET['id'];

    // Publicaciones - Eliminar Publicaciones
    $queryEliminarPublicaciones = "UPDATE publicaciones SET fecha_baja = NOW() WHERE id = " . $publicacion;

    if(!mysqli_query($conn, $queryEliminarPublicaciones)){
        die(mysqli_error($conn));
    }

    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
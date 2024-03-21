<?php
    require_once "../../includes/config.php";

    $comentario = $_GET['id'];

    // Comentarios - Eliminar Comentarios
    $queryEliminarComentarios = "UPDATE comentarios SET fecha_baja = NOW() WHERE id = " . $comentario;

    if(!mysqli_query($conn, $queryEliminarComentarios)){
        die(mysqli_error($conn));
    }

    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
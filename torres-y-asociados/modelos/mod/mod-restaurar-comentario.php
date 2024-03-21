<?php
    require_once "../../includes/config.php";

    $comentario = $_GET['id'];

    // Comentarios - Restaurar Comentarios
    $queryRestaurarComentarios = "UPDATE comentarios SET fecha_baja = null WHERE id = " . $comentario;

    if(!mysqli_query($conn, $queryRestaurarComentarios)){
        die(mysqli_error($conn));
    }

    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
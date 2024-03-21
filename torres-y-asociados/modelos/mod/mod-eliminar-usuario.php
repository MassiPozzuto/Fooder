<?php
    require_once "../../includes/config.php";

    $usuario = $_GET['id'];

    // Usuarios - Eliminar
    $queryEliminarUsu = "UPDATE usuarios
                        SET nombreUsuario = 'USUARIO ELIMINADO',
                            fotoPerfil = 'img/foto-perfil-user-deleted.jpg',
                            fecha_baja = NOW()
                        WHERE id = '" . $usuario . "'
    ";

    if(!mysqli_query($conn, $queryEliminarUsu)){
        die(mysqli_error($conn));
    }
    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
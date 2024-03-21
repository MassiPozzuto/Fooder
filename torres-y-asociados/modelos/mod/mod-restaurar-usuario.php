<?php
    require_once "../../includes/config.php";

    $usuario = $_GET['id'];

    $imgNum = random_int(1, 20);

    // Usuarios - Restaurar
    $queryRestaurarUsu="UPDATE usuarios
                        SET nombreUsuario = 'USUARIO DESBANEADO',
                            fotoPerfil = 'img/img-rand-perfil/$imgNum.png',
                            fecha_baja = null
                        WHERE id = '" . $usuario . "'
    ";

    if(!mysqli_query($conn, $queryRestaurarUsu)){
        die(mysqli_error($conn));
    }

    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
<?php
    require_once "../../includes/config.php";

    $usuario = $_GET['id'];

    // Usuarios - Censurar Descripcion
    $queryCensurarDescrip = "UPDATE usuarios
    SET descripcion = '<i>Descripcion Censurada</i>'
    WHERE id = '" . $usuario . "'
    ";

    if(!mysqli_query($conn, $queryCensurarDescrip)){
        die(mysqli_error($conn));
    }
    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);

?>
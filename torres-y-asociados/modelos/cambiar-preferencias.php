<?php
    require_once "../includes/config.php";
    require_once "usuario-actual.php";

    $temaSelect = $_POST['switch-cambiar-tema'] ?? 'light';
    if($temaSelect == 'on'){
        $temaSelect = 'dark';
    }

    $censMemeSelect = $_POST['switch-cens-meme'] ?? 'off';
    $censComentsSelect = $_POST['switch-cens-comentarios'] ?? 'off';
    $idiomaSelect = $_POST['select-language'];

    $sqlQuery = "UPDATE usuarios
                SET tema = '" . $temaSelect . "',
                    idioma = '" . $idiomaSelect . "',
                    censMemes = '" . $censMemeSelect . "',
                    censComentarios = '" . $censComentsSelect . "'
                WHERE id = '" . $user['id'] . "'
    ";

    if(!mysqli_query($conn, $sqlQuery)){
        die(mysqli_error($conn));
    }

    header("Location: ../preferencias.php");
?>
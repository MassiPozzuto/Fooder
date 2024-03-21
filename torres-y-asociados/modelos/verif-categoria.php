<?php
    session_start();

    require_once '../includes/config.php';

    $categoria = $_GET['categoria'];

    $validar_categ = mysqli_query($conn, "SELECT * FROM categorias WHERE categorias.nombre = '" . $categoria . "'");

    if(!$validar_categ){
        die('Error de Consulta: ' .  mysqli_error($conn));
    }

    if(mysqli_num_rows($validar_categ) == 0){
        echo false; // No existe la categoria
    }else{
        echo true; // Existe la cateoria
    }
?>
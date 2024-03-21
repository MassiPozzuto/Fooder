<?php
    require_once "includes/config.php";
    
    require_once "modelos/usuario-actual.php";

    //require_once "modelos/galeria-usuario.php";
    
    $id = $_GET['id'];

    $section = "galeria-usuario";
    
    require_once "views/layout.php";
?>
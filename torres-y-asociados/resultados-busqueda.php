<?php
    require_once "includes/config.php";
    
    require_once "modelos/usuario-actual.php";

    if(isset($_POST['busqueda'])){
        $categ_buscada = $_POST['busqueda'];
    }else if(isset($_GET['busqueda'])){
        $categ_buscada = $_GET['busqueda'];
    }

    //require_once "modelos/resultados-busqueda.php";

    $section = "resultados-busqueda";

    require_once "views/layout.php";
?>
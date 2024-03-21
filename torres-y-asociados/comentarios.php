<?php
    require_once("includes/config.php");

    require_once "modelos/usuario-actual.php";

    //require_once "modelos/comentarios.php";

    $from = $_GET['section'];

    if(isset($_GET['uId'])){
        $usuGaleryId = $_GET['uId'];
    }

    if(isset($_GET['categ'])){
        $categoria = $_GET['categ'];
    }
    if(isset($_GET['notifPubId'])){
        $notifPubId = $_GET['notifPubId'];
    }

    if($from == '0'){
        $goTo = 'feed-principal';
    }else if($from == '1'){
        $goTo = 'galeria-usuario';
    }else if($from == '2'){
        $goTo = 'resultados-busqueda';
    }else if($from == 3){
        $goTo = 'notificaciones-post';
    }

    $section = "comentarios";
    
    require_once("views/layout.php");
?>
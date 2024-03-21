<?php
    require_once "includes/config.php";
    
    require_once "modelos/usuario-actual.php";
    
    //require_once "modelos/notificaciones-post.php";

    $idPostNotif = $_GET['id'];

    $section = "notif-post";
    
    require_once "views/layout.php";
?>
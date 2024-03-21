<?php
    require_once "includes/config.php";

    require_once "modelos/usuario-actual.php";
    if(!isset($_GET["origen"])){
        header('Location: feed-principal.php');
    }
    
    foreach($rowRoles as $rowRol){
        if($rowRol['perfil_id'] == 1 || $rowRol['perfil_id'] == 2 ){
            break;
        }else{
            header('Location: no-permissions.php');
        }
    }
    require_once "modelos/lista-mod.php";
    $section = "lista-publicaciones";

    require_once "views/layout.php";

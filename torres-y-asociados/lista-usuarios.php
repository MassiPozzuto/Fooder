<?php
    require_once "includes/config.php";

    require_once "modelos/usuario-actual.php";
    if(!isset($_GET["origen"])){
        header('Location: feed-principal.php');
    }
    if($_GET["origen"] == "Admin"){
        foreach($rowRoles as $rowRol){
            if($rowRol['perfil_id'] == 1){
                require_once "modelos/lista-admin.php";
                break;
            }else{
                header('Location: no-permissions.php');
            }
        }
    }else if($_GET["origen"] == "Mod"){
        
    foreach($rowRoles as $rowRol){
        if($rowRol['perfil_id'] == 1 || $rowRol['perfil_id'] == 2){
            require_once "modelos/lista-mod.php";
            break;
        }else{
            header('Location: no-permissions.php');
        }
    }
    }else{
        header('Location: feed-principal.php');
    }


    $section = "lista-usuarios";

    require_once "views/layout.php";

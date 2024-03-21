<?php
    require_once "includes/config.php";

    require_once "modelos/usuario-actual.php";

    foreach($rowRoles as $rowRol){
        if($rowRol['perfil_id'] == 1 || $rowRol['perfil_id'] == 2){
            break;
        }else{
            header('Location: no-permissions.php');
        }
    }

    require_once "modelos/lista-admin.php";

    $section = "lista-moderadores";

    require_once "views/layout.php";
?>
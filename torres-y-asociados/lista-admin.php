<?php
    require_once "includes/config.php";

    require_once "modelos/usuario-actual.php";

    foreach($rowRoles as $rowRol){
        if($rowRol['perfil_id'] == 1){
            break;
        }else{
            header('Location: no-permissions.php');
        }
    }
    $section = "lista-admin";
    require_once "views/layout.php";
?>
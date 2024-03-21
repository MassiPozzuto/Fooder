<?php
    require_once "includes/config.php";

    require_once "modelos/usuario-actual.php";

    $num = rand(1, 2);

    if($num == 1){
        $img = "1.jpeg";
    }else{
        $img = "2.gif";
    }

    require_once "views/no-permissions.php";
?>
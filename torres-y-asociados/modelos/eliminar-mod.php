<?php
    require_once "../includes/config.php";

    //$query = "UPDATE usuarios SET privilegio_id = '3' WHERE usuarios.id =".$_GET["id"];
    $query="DELETE FROM roles WHERE roles.usuario_id = ".$_GET['id']." AND roles.perfil_id = 2";
    
    if(!mysqli_query($conn,$query)){
        die(mysqli_error($conn));
    }

    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
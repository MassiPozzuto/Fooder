<?php
    require_once "../includes/config.php";

    //$query = "UPDATE usuarios SET privilegio_id = '2' WHERE usuarios.id =".$_GET["id"];
    $query = "INSERT INTO roles VALUES(null, '".$_GET['id']."', 2)";
    
    if(!mysqli_query($conn,$query)){
        die(mysqli_error($conn));
    }
    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
<?php
    require_once "../includes/config.php";
    //require_once "lista-admin.php";

    //$query = "UPDATE usuarios SET privilegio_id = '1' WHERE usuarios.id =".$_GET["id"];
    $query = "INSERT INTO roles VALUES(null, '".$_GET['id']."', 1)";

    $queryUsu = "SELECT * FROM roles WHERE usuario_id = " . $_GET['id'];
    $result = mysqli_query($conn, $queryUsu);
    $rowRoles = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $isMod = false;

    foreach($rowRoles as $rowRol){
        if($rowRol['perfil_id'] == 2){
            $isMod = true;
        }
    }

    if(!$isMod){
        if(!mysqli_query($conn, "INSERT INTO roles VALUES(null, '".$_GET['id']."', 2)")){
            die(mysqli_error($conn));
        }
    }

    if(!mysqli_query($conn, $query)){
        die(mysqli_error($conn));
    }
    
    header("Location: ".RUTA."/lista-".$_GET["lista"].".php?origen=".$_GET["origen"]);
?>
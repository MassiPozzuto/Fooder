<?php
    require_once "../includes/config.php";

    $id_usuario = $_GET['id'];
    $parentezco = $_GET['idF'];

    $nick_query = "SELECT nombreUsuario FROM usuarios WHERE id = $id_usuario";
    $nick = mysqli_query($conn, $nick_query);

    if(!$nick){
        die(mysqli_error($conn));
    }
    
    $nickname = mysqli_fetch_assoc($nick);

    $result['nombre'] = $nickname['nombreUsuario'];
    $result['idF'] = $parentezco;

    echo json_encode($result);
?>
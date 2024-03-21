<?php
    session_start();
    
    require_once "../includes/config.php";

    $nombreUsuario = $_POST['nombreUsuario'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $genero_id = $_POST['genero_id'];
    $email = $_POST['email'];
    $clave = sha1($_POST['clave']);
    /*$descripcion = "Ingrese una descripcion";*/
    $numRand = mt_rand(1, 20);
    $fotoPerfil = "img/img-rand-perfil/".$numRand.".png";

    if (!empty($_POST)) {
        $sql = "INSERT INTO usuarios VALUES (
            null,
            '$genero_id',
            '$nombreUsuario',
            '$fechaNacimiento',
            '$email',
            '$clave',
            null,
            '$fotoPerfil',
            'on',
            'on',
            'light',
            'spanish',
            NOW(),
            null)";
        if (mysqli_query($conn, $sql)) {
            $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE email = '$email'");
            
            if(!$result){
                die(mysqli_error($conn));
            }
            
            $actUser = mysqli_fetch_assoc($result);
            $_SESSION['usuario_id'] = $actUser['id'];
            
            if(!mysqli_query($conn, "INSERT INTO roles VALUES(null, '".$actUser['id']."', 3)")){
                die(mysqli_error($conn));
            }

            header("Location: ../feed-principal.php");
        } else {
            die('Error de Consulta' . mysqli_error($conn));
        }
    }
?>
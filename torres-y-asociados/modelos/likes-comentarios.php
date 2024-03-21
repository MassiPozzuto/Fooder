<?php 
    session_start();

    require_once "../includes/config.php";


    $destinatario_id = $_GET['idD'];

    $comentario_like = $_GET['id'];
    
    $like_usuario = $_SESSION['usuario_id'];


    $consulta1 = "SELECT * FROM comentarios_likes WHERE usuario_id = $like_usuario AND comentario_id = $comentario_like";
    $validar_like = mysqli_query($conn, $consulta1);
    if(!$validar_like){
        die(mysqli_error($conn));
    }

    if(mysqli_num_rows($validar_like) == 1){
        $borrar_like = "DELETE FROM comentarios_likes WHERE comentario_id = $comentario_like AND usuario_id = $like_usuario";
        if(!mysqli_query($conn, $borrar_like)){
            die(mysqli_error($conn));
        }
        echo 'blanco';

        /* Eliminar notificacion comentarios */
        $delete_notif = "DELETE FROM notificaciones WHERE comentario_id = $comentario_like AND usuario_id = $like_usuario";
        if(!mysqli_query($conn, $delete_notif)){
            die(mysqli_error($conn));
        }
    }

    else if (mysqli_num_rows($validar_like) == 0){

        $consulta2 = "INSERT INTO comentarios_likes (usuario_id, comentario_id) VALUES ($like_usuario, $comentario_like)";
        if(!mysqli_query($conn, $consulta2)){
            die(mysqli_error($conn));
        }
        echo 'rojo';

        /*  Notificaciones comentarios  */
        $consulta3 = "INSERT INTO notificaciones VALUES (null, $comentario_like, $destinatario_id, null, 2, $like_usuario, NOW(), null)";
        $query = mysqli_query($conn, $consulta3);
        if(!$query){
            die(mysqli_error($conn));
        }
    }
?>
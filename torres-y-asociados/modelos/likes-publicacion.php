<?php 
    session_start();

    require_once "../includes/config.php";

    $publicacion_like = $_GET['idP'];
    $destinatario = $_GET['id'];
    $like_usuario = $_SESSION['usuario_id'];

    $sql = "SELECT * FROM publicaciones_likes WHERE usuario_id = $like_usuario AND publicacion_id = $publicacion_like";
    $validar_like = mysqli_query($conn, $sql);
    if(!$validar_like){
        die(mysqli_error($conn));
    }

    if(mysqli_num_rows($validar_like) == 1){
        $delete_like = "DELETE FROM publicaciones_likes WHERE publicacion_id = $publicacion_like AND usuario_id = $like_usuario";
        if(!mysqli_query($conn, $delete_like)){
            die(mysqli_error($conn));
        }
        echo "blanco";
        /*  Eliminar notificacion */
        $delete_notif = "DELETE FROM notificaciones WHERE publicacion_id = $publicacion_like AND usuario_id = $like_usuario";
        if(!mysqli_query($conn, $delete_notif)){
            die(mysqli_error($conn));
        }
    }

    else if (mysqli_num_rows($validar_like) == 0){

        $sql2 = "INSERT INTO publicaciones_likes VALUES (null, $like_usuario, $publicacion_like)";
        if(!mysqli_query($conn, $sql2)){
            die(mysqli_error($conn));
        }
        echo "rojo";
        /*  Notificaciones de likes por publicacion  */
        $sql3 = "INSERT INTO notificaciones VALUES (null, null, $destinatario, $publicacion_like, 1, $like_usuario, NOW(), null)";
        if(!mysqli_query($conn, $sql3)){
            die(mysqli_error($conn));
        }
    }
?>
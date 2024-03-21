<?php
    require_once "../../includes/config.php";

    $page = $_GET['page'];
    $cantPosts = $_GET['cantPosts'];

    $sql = 'SELECT *, publicaciones.id as "publicacion_id" 
            FROM usuarios 
            INNER JOIN publicaciones 
                ON usuarios.id=publicaciones.usuario_id 
            WHERE publicaciones.fecha_baja IS NULL 
            ORDER BY publicaciones.id DESC
            LIMIT '.($page - 1)*$cantPosts.', '.$cantPosts .'
    ';

    $res = mysqli_query($conn, $sql);

    if(!$res){
        die('Error de Consulta' . mysqli_error($conn));
    }

    $publicaciones = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($publicaciones);
?>
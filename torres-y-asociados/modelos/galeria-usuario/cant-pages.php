<?php
    require_once "../../includes/config.php";

    $cantPostsToShow = $_GET['cantPosts'];
    $id = $_GET['id'];

    $sql = "SELECT *, publicaciones.id AS 'publicacion_id'
            FROM usuarios
            INNER JOIN publicaciones
                ON usuarios.id=publicaciones.usuario_id
            WHERE publicaciones.fecha_baja IS NULL AND usuarios.id = '$id'
            ORDER BY publicaciones.id DESC
    ";

    $res = mysqli_query($conn, $sql);

    if(!$res){
        die('Error de Consulta' . mysqli_error($conn));
    }

    $cantPosts = ceil(mysqli_num_rows($res) / $cantPostsToShow);

    echo $cantPosts;
?>
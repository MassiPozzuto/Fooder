<?php 
    require_once "../../includes/config.php";

    $id = $_GET['idNP'];
    $page = $_GET['page'];
    $cantPosts = $_GET['cantPosts'];

    $sql = 'SELECT *, publicaciones.id as "publicacion_id"
            FROM usuarios 
            INNER JOIN publicaciones 
                ON usuarios.id=publicaciones.usuario_id 
            WHERE publicaciones.fecha_baja IS NULL AND publicaciones.id = '. $id . '
            LIMIT '.($page - 1)*$cantPosts.', '.$cantPosts
    ;

    $result = mysqli_query($conn,$sql);

    $publicaciones = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode($publicaciones);
?>

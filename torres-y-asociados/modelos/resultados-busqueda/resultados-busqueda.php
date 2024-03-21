<?php
    require_once "../../includes/config.php";

    $page = $_GET['page'];
    $cantPosts = $_GET['cantPosts'];
    $categ_buscada = $_GET['categ'];

    $sql = 'SELECT usuarios.id AS "usuario_id",
                    usuarios.nombreUsuario,
                    usuarios.fotoPerfil,
                    publicaciones.*,
                    publicaciones.id AS "publicacion_id",
                    publicaciones.rutaImagen,
                    publicaciones.censura,
                    categorias.nombre AS "categoria"
            FROM usuarios
            INNER JOIN publicaciones
            ON usuarios.id = publicaciones.usuario_id
            INNER JOIN publicaciones_categorias
            ON publicaciones.id = publicaciones_categorias.publicacion_id
            INNER JOIN categorias
            ON publicaciones_categorias.categoria_id = categorias.id
            WHERE categorias.nombre = "' . $categ_buscada . '"
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
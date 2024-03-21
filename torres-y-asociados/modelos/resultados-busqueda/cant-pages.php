<?php
    require_once "../../includes/config.php";

    $cantPostsToShow = $_GET['cantPosts'];
    $categ_buscada = $_GET['categ'];

    $sql = "SELECT usuarios.id AS 'usuario_id',
                   usuarios.nombreUsuario,
                   usuarios.fotoPerfil,
                   publicaciones.*,
                   publicaciones.id AS 'publicacion_id',
                   publicaciones.rutaImagen,
                   publicaciones.censura,
                   categorias.nombre AS 'categoria'
            FROM usuarios
            INNER JOIN publicaciones
                ON usuarios.id = publicaciones.usuario_id
            INNER JOIN publicaciones_categorias
                ON publicaciones.id = publicaciones_categorias.publicacion_id
            INNER JOIN categorias
                ON publicaciones_categorias.categoria_id = categorias.id
            WHERE categorias.nombre = '" . $categ_buscada . "'
    ";

    $res = mysqli_query($conn, $sql);

    if (!$res) {
    die('Error de Consulta' . mysqli_error($conn));
    }

    $cantPosts = ceil(mysqli_num_rows($res) / $cantPostsToShow);

    echo $cantPosts;
?>
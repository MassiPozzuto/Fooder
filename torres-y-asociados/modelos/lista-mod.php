<?php
    // Usuarios
    $queryUsuarios="SELECT usuarios.id,
                    usuarios.fotoPerfil,
                    usuarios.nombreUsuario,
                    usuarios.descripcion,
                    perfiles.id AS 'rolId',
                    perfiles.nombre AS 'rolNombre',
                    usuarios.fecha_baja
            FROM usuarios
            INNER JOIN roles
                ON roles.usuario_id = usuarios.id
            INNER JOIN perfiles
                ON perfiles.id = roles.perfil_id
            ORDER BY usuarios.id, roles.perfil_id
    ";

    $resultUsuarios = mysqli_query($conn, $queryUsuarios);

    $rowUsuarios = mysqli_fetch_all($resultUsuarios, MYSQLI_NUM);

    for($i=0;$i<count($rowUsuarios);$i++){
        $reportes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(reportes_usuario.destinatario_id) AS cantR FROM reportes_usuario WHERE destinatario_id = ".$rowUsuarios[$i][0]));
        $rowUsuarios[$i][7] = $reportes['cantR'];
    }

    // Publicaciones
    $queryPublicaciones = "SELECT publicaciones.*, COUNT(reportes_publicacion.publicacion_id) AS cantR FROM publicaciones INNER JOIN reportes_publicacion ON reportes_publicacion.publicacion_id = publicaciones.id GROUP BY publicaciones.id";
    $resultPublicaciones = mysqli_query($conn, $queryPublicaciones);
    $rowPublicaciones = mysqli_fetch_all($resultPublicaciones, MYSQLI_ASSOC);

    // Publicaciones -- Categorias
    $queryPubliCategs = "SELECT * FROM publicaciones_categorias INNER JOIN categorias ON publicaciones_categorias.categoria_id = categorias.id";
    $resultPubliCategs = mysqli_query($conn, $queryPubliCategs);
    $rowPubliCategs = mysqli_fetch_all($resultPubliCategs, MYSQLI_ASSOC);

    // Comentarios
    $queryComentarios = "SELECT comentarios.*, publicaciones.rutaImagen, COUNT(reportes_comentario.comentario_id) AS cantR FROM comentarios INNER JOIN publicaciones ON comentarios.publicacion_id = publicaciones.id INNER JOIN reportes_comentario ON reportes_comentario.comentario_id = comentarios.id GROUP BY comentarios.id";
    $resultComentarios = mysqli_query($conn, $queryComentarios);
    $rowComentarios = mysqli_fetch_all($resultComentarios, MYSQLI_ASSOC);

?>
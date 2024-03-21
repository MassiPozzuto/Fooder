<?php
    $queryPosts="SELECT COUNT(publicaciones_likes.publicacion_id) AS 'likesPosts', usuarios.fotoPerfil, usuarios.nombreUsuario, usuarios.id
                    FROM publicaciones_likes
                    LEFT JOIN publicaciones
                        ON publicaciones_likes.publicacion_id = publicaciones.id
                    RIGHT JOIN usuarios
                        ON publicaciones.usuario_id = usuarios.id
                    WHERE usuarios.fecha_baja IS NULL
                    GROUP BY usuarios.nombreUsuario
                    ORDER BY usuarios.nombreUsuario ASC
                    LIMIT 10;
    ";

    $queryComments="SELECT COUNT(comentarios_likes.comentario_id) AS 'likesComments', usuarios.fotoPerfil, usuarios.nombreUsuario, usuarios.id
                    FROM comentarios_likes
                    LEFT JOIN comentarios
                        ON comentarios_likes.comentario_id = comentarios.id
                    RIGHT JOIN usuarios
                        ON comentarios.usuario_id = usuarios.id
                    WHERE usuarios.fecha_baja IS NULL
                    GROUP BY usuarios.nombreUsuario
                    ORDER BY usuarios.nombreUsuario ASC
                    LIMIT 10;
    ";
    
    $resultPosts = mysqli_query($conn, $queryPosts);
    $resultComments = mysqli_query($conn, $queryComments);
    
    if(!$resultPosts || !$resultComments){
        die(mysqli_error($conn));
    }

    $likesPosts = mysqli_fetch_all($resultPosts, MYSQLI_NUM);
    $likesComments = mysqli_fetch_all($resultComments,  MYSQLI_NUM);

    $likesTotales = null;
    $j = 0;

    for($i = 0; $i < count($likesPosts); $i++){
        $likesTotales[$i][0] = $likesPosts[$i][0] + $likesComments[$j][0];
        $likesTotales[$i][1] = $likesPosts[$i][1];
        $likesTotales[$i][2] = $likesPosts[$i][2];
        $likesTotales[$i][3] = $likesPosts[$i][3];
        $j++;
    }

    array_multisort(array_column($likesTotales, 0), SORT_DESC, $likesTotales);
?>
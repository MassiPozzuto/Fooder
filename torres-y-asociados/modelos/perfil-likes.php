<?php
    $multiquery = "SELECT COUNT(*) FROM publicaciones_likes LEFT JOIN publicaciones ON publicaciones.id = publicaciones_likes.publicacion_id WHERE publicaciones.usuario_id = ". $user['id'] .";";
    $multiquery .= "SELECT COUNT(*) FROM comentarios_likes LEFT JOIN comentarios ON comentarios.id = comentarios_likes.comentario_id WHERE comentarios.usuario_id = ". $user['id'] .";";
    $likes = 0;
    if (mysqli_multi_query($conn, $multiquery)) {
        do {
            if ($resultLik = mysqli_store_result($conn)) {
                while ($row = mysqli_fetch_row($resultLik)) {
                $likes = $likes + $row[0];     
                }
            }
        } while (mysqli_next_result($conn));
    }
?>

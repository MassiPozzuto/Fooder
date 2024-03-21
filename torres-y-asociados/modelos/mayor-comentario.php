<?php
$sqlCom = "SELECT COUNT(comentario_id) AS cantLikesC, comentario_id 
            AS idCom, comentarios.contenido, usuarios.nombreUsuario,comentarios.usuario_id,usuarios.fotoPerfil,comentarios.publicacion_id 
            FROM comentarios_likes INNER JOIN comentarios ON comentarios_likes.comentario_id = comentarios.id 
            INNER JOIN usuarios ON comentarios.usuario_id = usuarios.id GROUP BY comentario_id ORDER BY COUNT(comentario_id) DESC LIMIT 3;";
$res = mysqli_query($conn, $sqlCom);

if(!$res){
    die('error de consulta');
}

$mayorCom = mysqli_fetch_all($res, MYSQLI_ASSOC);

?>
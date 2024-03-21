<?php
/*MEGA CONSULTA :OO Made by P4ULXD*/
$sql = "SELECT COUNT(publicacion_id) AS cantLikes, publicacion_id AS idPub,publicaciones.rutaImagen, usuarios.nombreUsuario FROM publicaciones_likes INNER JOIN publicaciones ON publicaciones_likes.publicacion_id = publicaciones.id INNER JOIN usuarios ON publicaciones.usuario_id = usuarios.id GROUP BY publicacion_id ORDER BY COUNT(publicacion_id) DESC LIMIT 3";
$res = mysqli_query($conn, $sql);

if(!$res){
    die('error de consulta');
}

$mayorPub = mysqli_fetch_all($res, MYSQLI_ASSOC);

?>
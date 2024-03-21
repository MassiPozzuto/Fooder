<?php
    session_start();

    require_once "../../includes/config.php";

    $page = $_GET['page'];
    $cantComments = $_GET['cantComments'];

    $publicacion = $_GET["id"];
    //SELECT * FROM comentarios LEFT JOIN comentarios as res ON comentarios.id = res.padre_id WHERE comentarios.padre_id = 0 OR res.padre_id != 0 GROUP BY comentarios.id;
    $current_user = $_SESSION['usuario_id'];
    $query="SELECT comentarios.id as com_id,
                comentarios.*,
                usuarios.nombreUsuario AS resNick,
                comUser.nombreUsuario,
                comUser.fotoPerfil,
                COUNT(comentarios_likes.comentario_id) AS cantidad_likes,
                IF(color.id IS NOT NULL, 'img/corazon.png', 'img/corazonvacio.png') AS color,
                IF(reportes_comentario.id IS NOT NULL, 'style=color:red;', 'noexistis') AS reporte,
                IF(res.id IS NOT NULL, 'si', 'no') AS espadre
            FROM comentarios 
            LEFT JOIN comentarios as com
                ON comentarios.padre_id = com.id 
            LEFT JOIN usuarios
                ON com.usuario_id = usuarios.id 
            INNER JOIN usuarios as comUser
                ON comUser.id = comentarios.usuario_id AND comentarios.publicacion_id = $publicacion 
            LEFT JOIN comentarios_likes as color
                ON color.comentario_id = comentarios.id AND color.usuario_id = $current_user 
            LEFT JOIN reportes_comentario
                ON reportes_comentario.comentario_id = comentarios.id AND reportes_comentario.usuario_id = $current_user 
            LEFT JOIN comentarios_likes
                ON comentarios_likes.comentario_id = comentarios.id
            LEFT JOIN comentarios AS res 
                ON res.padre_id = comentarios.id
            WHERE comentarios.publicacion_id = $publicacion AND comentarios.fecha_baja IS NULL 
            GROUP BY comentarios.id
            LIMIT ".($page - 1)*$cantComments.", ".$cantComments ."
    ";

    $result = mysqli_query($conn, $query);

    if(!$result){
        die('Error de Consulta' . mysqli_error($conn));
    }

    $user_comentarios = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode($user_comentarios);
?>
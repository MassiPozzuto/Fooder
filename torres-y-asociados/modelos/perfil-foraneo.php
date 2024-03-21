<?php
    // Usuario al que queremos seleccionar para ver su perfil
    $id = $_GET["id"];
    $query="SELECT * FROM usuarios WHERE id =" .$id;
    $result = mysqli_query($conn,$query);

    if(!$result){
        die(mysqli_error($conn));
    }

    $userFor = mysqli_fetch_assoc($result);

    // Rol del Usuario

    $queryRol = "SELECT usuarios.id AS 'userId', usuarios.nombreUsuario, roles.perfil_id, perfiles.nombre AS 'perfilNombre'
                FROM usuarios
                INNER JOIN roles
                    ON roles.usuario_id = usuarios.id
                INNER JOIN perfiles
                    ON perfiles.id = roles.perfil_id
                WHERE roles.usuario_id = '$id'
                ORDER BY roles.perfil_id ASC
    ";

    $resultQueryRol = mysqli_query($conn, $queryRol);
    $rolesRow = mysqli_fetch_all($resultQueryRol, MYSQLI_ASSOC);

    // Cantidad de publicaciones del usuario
    $query2 = "SELECT * FROM publicaciones WHERE usuario_id = ". $id ." ORDER BY id DESC LIMIT 6";
    $result2 = mysqli_query($conn,$query2);

    if(!$result2){
        die(mysqli_error($conn));
    }
    
    $publicaciones = mysqli_fetch_assoc($result2);
    $cantPublicaciones = mysqli_num_rows($result2);

    // Cantidad de likes del usuario

    $multiquery = "SELECT COUNT(*) FROM publicaciones_likes LEFT JOIN publicaciones ON publicaciones.id = publicaciones_likes.publicacion_id WHERE publicaciones.usuario_id = ". $_GET['id'] .";";
    $multiquery .= "SELECT COUNT(*) FROM comentarios_likes LEFT JOIN comentarios ON comentarios.id = comentarios_likes.comentario_id WHERE comentarios.usuario_id = ". $_GET['id'] .";";
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

    //  REPORTES PERFIL //
    $user_id = $user['id'];
    $sql_report_usuario = "SELECT * FROM reportes_usuario WHERE usuario_id = $user_id";
    $res_report_usuario = mysqli_fetch_all(mysqli_query($conn, $sql_report_usuario), MYSQLI_ASSOC);
    /////////////////////
?>

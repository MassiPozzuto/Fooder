<?php
    $query="SELECT usuarios.id,
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

    $result = mysqli_query($conn,$query);

    $rowUsuarios = mysqli_fetch_all($result, MYSQLI_NUM);
    
    for($i=0;$i<count($rowUsuarios);$i++){
        $reportes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(reportes_usuario.destinatario_id) AS cantR FROM reportes_usuario WHERE destinatario_id = ".$rowUsuarios[$i][0]));
        $rowUsuarios[$i][7] = $reportes['cantR'];
    }
?>
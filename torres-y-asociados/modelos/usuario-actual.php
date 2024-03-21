<?php
    session_start();

    $conn = mysqli_connect('localhost', 'root', '', 'memingos');

    if (isset($_SESSION['usuario_id'])) {
        $consultaUsur = "SELECT * FROM usuarios WHERE id = " . $_SESSION['usuario_id'] . ";";
        $resultUsur = mysqli_query($conn, $consultaUsur);
        if(!$resultUsur){
            die(mysqli_error($conn));
        }

        if (mysqli_num_rows($resultUsur) > 0) {
            $usu_info = mysqli_fetch_assoc($resultUsur);
            $user = $usu_info;
        }

        $qryBan = mysqli_query($conn, "SELECT * FROM notificaciones WHERE tipo_notificacion_id = 4 AND destinatario_id = ".$user['id']);
        if(!$qryBan){
            die(mysqli_error($conn));
        }

        if(mysqli_num_rows($qryBan) == 3){
            mysqli_query($conn, "UPDATE usuarios SET fecha_baja = NOW() WHERE usuarios.id = ".$user['id']);
            header("Location: login.php");
        } 

    }else{
        header("Location: login.php");
    }


    /* -- Rol-Perfil -- */

    $rolQuery = "SELECT usuarios.id AS 'userId', usuarios.nombreUsuario, roles.perfil_id, perfiles.nombre AS 'perfilNombre'
                FROM usuarios
                INNER JOIN roles
                    ON roles.usuario_id = usuarios.id
                INNER JOIN perfiles
                    ON perfiles.id = roles.perfil_id
                WHERE roles.usuario_id = '". $user['id'] . "'
                ORDER BY roles.perfil_id ASC
    ";

    $resultRolQuery = mysqli_query($conn, $rolQuery);
    $rowRoles = mysqli_fetch_all($resultRolQuery, MYSQLI_ASSOC);


    /* --Notificaciones-- */
    
    $sqlU = 'SELECT notificaciones.*, notificaciones.id AS id_N, notificaciones.publicacion_id AS pub_id,comentarios.id AS com_id,
            comentarios.publicacion_id, usuarios.fotoPerfil
            FROM `notificaciones` 
                INNER JOIN usuarios 
                    ON usuarios.id = notificaciones.usuario_id 
                        AND destinatario_id = ' . $user['id'] .' 
                LEFT JOIN comentarios 
                    ON comentarios.id = notificaciones.comentario_id 
                WHERE notificaciones.fecha_baja IS NULL ORDER BY id_N DESC';

    $queryU = mysqli_query($conn, $sqlU);
    if(!$queryU){
        die(mysqli_error($conn));
    }

    while($rows_notif = mysqli_fetch_assoc($queryU)){  
        // Establezco fecha de notificacion
        $send_date = $rows_notif['fecha_alta'];
        $current_date = date('Y-m-d'); 
        $datetime1U = date_create($send_date);
        $datetime2U = date_create($current_date);
        $counter = date_diff($datetime1U, $datetime2U);
        $differenceFormatU = '%a';
        $actual_date = $counter->format($differenceFormatU);
        $rows_notif['fecha_actual'] = 'Hace ' . $actual_date . ' dias';
        $notificaciones[] = $rows_notif;
    }

    /* --Preferencias-- */

    //$sqlPreferencias = "SELECT * FROM preferencias INNER JOIN usuarios ON usuarios.preferencias_id = preferencias.id WHERE usuarios.id ='" . $user['id'] . "'";
    $sqlPreferencias = "SELECT censMemes, censComentarios, tema, idioma
                        FROM usuarios
                        WHERE id='" . $user['id'] . "'
    ";

    $resultPreferencias = mysqli_query($conn, $sqlPreferencias);
    if(!$resultPreferencias){
        die(mysqli_error($conn));
    }

    $preferences = mysqli_fetch_all($resultPreferencias, MYSQLI_ASSOC);

    foreach($preferences as $preference){
        if($preference['tema'] == 'dark'){
            $clase = "dark"; // Tema Oscuro
        }else{
            $clase = ""; // Tema Claro
        }

        if($preference['censComentarios'] == 'off'){
            $censuraComent = false; // No Censurar Coments
        }else{
            $censuraComent = true; // Censurar Coments
        }

        if($preference['idioma'] == 'english'){
            $lang = 'english'; // Ingles
        }else{
            $lang = 'spanish'; // Espanol
        }

        if($preference['censMemes'] == 'off'){
            $censuraMeme = false; // No censurar Memes
        }else{
            $censuraMeme = true; // Censurar Memes
        }
    }

    // PREFERENCIAS - Language
    $language = parse_ini_file("languages/$lang.ini", true);

?>
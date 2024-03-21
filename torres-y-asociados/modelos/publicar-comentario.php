<?php
    session_start();

    include "../includes/config.php";

    $comentario = $_POST['comentar'];
    $publicacion = $_POST['idP'];
    $parentezco = $_POST['idF'];
    
    /* el id del usuario fue declarado en el archivo 'usuario-actual.php'*/
    $query = "INSERT INTO comentarios
              VALUES (null, '" .$_SESSION['usuario_id'] . "', '$publicacion', '$parentezco', '$comentario', NOW(), null)
             ";
    
    if(!mysqli_query($conn, $query)){
        die(mysqli_error($conn));
    }

    $current_id = mysqli_insert_id($conn);

    $query2 = "SELECT comentarios.*, comentarios.id as com_id, usuarios.nombreUsuario, usuarios.fotoPerfil, usu.nombreUsuario as dest_nick FROM comentarios INNER JOIN usuarios ON usuarios.id = comentarios.usuario_id LEFT JOIN comentarios as com ON comentarios.padre_id = com.id LEFT JOIN usuarios as usu ON com.usuario_id = usu.id WHERE comentarios.id = $current_id";
    $save = mysqli_query($conn, $query2);

    if(!$save){
        die(mysqli_error($conn));
    }

    $user_comentario = mysqli_fetch_assoc($save);
    
    if($user_comentario['padre_id'] == 0){
        $array[0] = '<div class="comentario" id="'.$user_comentario['com_id'].'">
                        <a href="perfil-foraneo.php?id='.$user_comentario['usuario_id'].'" class="link-perfil"><img src="'.$user_comentario['fotoPerfil'].'" class="img-usuario-comentarios"></a>
                        <p class="text-comentario">
                            <a href="perfil-foraneo.php?id='.$user_comentario['usuario_id'].'" class="link-nombre-perfil">'.$user_comentario['nombreUsuario'].'</a>
                            '.$user_comentario['contenido'].'
                        </p>

                        <p class="dia-comentario">Hoy</p>
                        <p class="cant-likes" id="?id='.$user_comentario["com_id"].'">0&nbsp;Me gusta</p>
                        <a href="javascript:nick_com(&apos;?id='.$user_comentario['usuario_id'].'&idF='.$user_comentario['com_id'].'&apos;)" class="boton-responder-comentario">Responder</a>    
                        <a href="javascript:like_com(&apos;?id='.$user_comentario['com_id'].'&idD='.$user_comentario['usuario_id'].'&apos;)" class="like-comentario"><img src="img/corazonvacio.png" id="?id='.$user_comentario["com_id"].'&idD='.$user_comentario["usuario_id"].'" class="img-like-comentario"></a>
                        <button class="boton-in rep-comentario"><abbr title="reportar" style="cursor: pointer;"><i onclick="reports(&apos;?id='.$user_comentario["com_id"].'&idU='.$_SESSION['usuario_id'].'&apos;, reportar_comentario)" class="fas fa-flag" id="?id='.$user_comentario["com_id"].'&idU='.$_SESSION['usuario_id'].'"></i></abbr></button>
                        </div>';
        
        $array[1] = 'com';
        $array[2] = $user_comentario['com_id'];
        echo json_encode($array);
    }
    
    else if($user_comentario['padre_id'] != 0){
        $array[0] = '<div class="conteiner-respuestas" id="res-'.$user_comentario['com_id'].'">
                        <div class="respuestas">
                            <a href="perfil-foraneo.php?id='.$user_comentario['usuario_id'].' class="link-perfil"><img src="'.$user_comentario['fotoPerfil'].'" class="img-usuario-comentarios"></a>
                            <p class="text-comentario">
                                <a href="perfil-foraneo.php?id='.$user_comentario["usuario_id"].'" class="link-nombre-perfil">'.$user_comentario['nombreUsuario'].'</a>
                                <a href="#" class="tag-user-res">@'.$user_comentario['dest_nick'].'</a>
                                '.$user_comentario['contenido'].'
                            </p>    
                            <p class="dia-comentario">Hoy</p>
                            <p class="cant-likes cant-likes-res" id="?id='.$user_comentario['com_id'].'">0&nbsp;Me gusta</p>
                            <a href="javascript:nick_com(&apos;?id='.$user_comentario['usuario_id'].'&idF='.$user_comentario['com_id'].'&apos;)" class="btn-responder-comentario">Responder</a>
                            <a href="javascript:like_com(&apos;?id='.$user_comentario['com_id'].'&idD='.$user_comentario['usuario_id'].'&apos;)" class="like-comentario"><img src="img/corazonvacio.png" id="?id='.$user_comentario['com_id'].'&idD='.$user_comentario['usuario_id'].'" class="img-like-comentario"></a>
                            <button class="boton-in rep-comentario"><abbr title="reportar" style="cursor: pointer;"><i onclick="reports(&apos;?id='.$user_comentario['com_id'].'&idU='.$_SESSION['usuario_id'].'&apos;, reportar_comentario)" class="fas fa-flag" id="?id='.$user_comentario['com_id'].'&idU='.$_SESSION['usuario_id'].'"></i></abbr></button>
                        </div>
                    </div>';

        $array[1] = $user_comentario['padre_id'];
        $array[2] = $user_comentario['com_id'];        
        echo json_encode($array);
    }
?>
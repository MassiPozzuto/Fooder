<?php
    require_once "../../includes/config.php";

    $com_id = $_GET['id'];

    $sql="SELECT 
    com1.id, com1.usuario_id, com1.publicacion_id, com1.padre_id, com1.contenido, com1.fecha_alta, usu1.nombreUsuario, usu1.fotoPerfil, IF(COUNT(like1.id)=0, NULL, COUNT(like1.id)), IF(rep1.id IS NOT NULL, 'style=color:red;', NULL), IF(color1.id IS NOT NULL, 'img/corazon.png', NULL), IF(tend1.id IS NOT NULL, 'fin', NULL),
    com2.id, com2.usuario_id, com2.publicacion_id, com2.padre_id, com2.contenido, com2.fecha_alta, usu2.nombreUsuario, usu2.fotoPerfil, IF(COUNT(like2.id)=0, NULL, COUNT(like2.id)), IF(rep2.id IS NOT NULL, 'style=color:red;', NULL), IF(color2.id IS NOT NULL, 'img/corazon.png', NULL), IF(tend2.id IS NOT NULL, 'fin', NULL),
    com3.id, com3.usuario_id, com3.publicacion_id, com3.padre_id, com3.contenido, com3.fecha_alta, usu3.nombreUsuario, usu3.fotoPerfil, IF(COUNT(like3.id)=0, NULL, COUNT(like3.id)), IF(rep3.id IS NOT NULL, 'style=color:red;', NULL), IF(color3.id IS NOT NULL, 'img/corazon.png', NULL), IF(tend3.id IS NOT NULL, 'fin', NULL),
    com4.id, com4.usuario_id, com4.publicacion_id, com4.padre_id, com4.contenido, com4.fecha_alta, usu4.nombreUsuario, usu4.fotoPerfil, IF(COUNT(like4.id)=0, NULL, COUNT(like4.id)), IF(rep4.id IS NOT NULL, 'style=color:red;', NULL), IF(color4.id IS NOT NULL, 'img/corazon.png', NULL), IF(tend4.id IS NOT NULL, 'fin', NULL),
    com5.id, com5.usuario_id, com5.publicacion_id, com5.padre_id, com5.contenido, com5.fecha_alta, usu5.nombreUsuario, usu5.fotoPerfil, IF(COUNT(like5.id)=0, NULL, COUNT(like5.id)), IF(rep5.id IS NOT NULL, 'style=color:red;', NULL), IF(color5.id IS NOT NULL, 'img/corazon.png', NULL), IF(tend5.id IS NOT NULL, 'fin', NULL),
    com6.id, com6.usuario_id, com6.publicacion_id, com6.padre_id, com6.contenido, com6.fecha_alta, usu6.nombreUsuario, usu6.fotoPerfil, IF(COUNT(like6.id)=0, NULL, COUNT(like6.id)), IF(rep6.id IS NOT NULL, 'style=color:red;', NULL), IF(color6.id IS NOT NULL, 'img/corazon.png', NULL), IF(tend6.id IS NOT NULL, 'fin', NULL),
    com7.id, com7.usuario_id, com7.publicacion_id, com7.padre_id, com7.contenido, com7.fecha_alta, usu7.nombreUsuario, usu7.fotoPerfil, IF(COUNT(like7.id)=0, NULL, COUNT(like7.id)), IF(rep7.id IS NOT NULL, 'style=color:red;', NULL), IF(color7.id IS NOT NULL, 'img/corazon.png', NULL), IF(tend7.id IS NOT NULL, 'fin', NULL),
    com8.id, com8.usuario_id, com8.publicacion_id, com8.padre_id, com8.contenido, com8.fecha_alta, usu8.nombreUsuario,
    usu8.fotoPerfil, IF(COUNT(like8.id)=0, NULL, COUNT(like8.id)), IF(rep8.id IS NOT NULL, 'style=color:red;', NULL), IF(color8.id IS NOT NULL, 'img/corazon.png', NULL), IF(tend8.id IS NOT NULL, 'fin', NULL)
    FROM comentarios 
                LEFT JOIN comentarios as com1 ON comentarios.id = com1.padre_id 
                    LEFT JOIN usuarios as usu1 ON com1.usuario_id = usu1.id
                        LEFT JOIN comentarios_likes as like1 ON like1.comentario_id = com1.id
                            LEFT JOIN reportes_comentario as rep1 ON rep1.comentario_id = com1.id
                                LEFT JOIN comentarios_likes as color1 ON color1.comentario_id = com1.id
                                    LEFT JOIN comentarios as tend1 ON tend1.id = com1.id
                        
                LEFT JOIN comentarios as com2 ON com1.id = com2.padre_id
                    LEFT JOIN usuarios as usu2 ON com2.usuario_id = usu2.id
                        LEFT JOIN comentarios_likes as like2 ON like2.comentario_id = com2.id
                            LEFT JOIN reportes_comentario as rep2 ON rep2.comentario_id = com2.id
                                LEFT JOIN comentarios_likes as color2 ON color2.comentario_id = com2.id
                                    LEFT JOIN comentarios as tend2 ON tend2.id = com2.id
                        
                LEFT JOIN comentarios as com3 ON com2.id = com3.padre_id
                    LEFT JOIN usuarios as usu3 ON com3.usuario_id = usu3.id
                        LEFT JOIN comentarios_likes as like3 ON like3.comentario_id = com3.id
                            LEFT JOIN reportes_comentario as rep3 ON rep3.comentario_id = com3.id
                                LEFT JOIN comentarios_likes as color3 ON color3.comentario_id = com3.id
                                    LEFT JOIN comentarios as tend3 ON tend3.id = com3.id
                        
                LEFT JOIN comentarios as com4 ON com3.id = com4.padre_id
                    LEFT JOIN usuarios as usu4 ON com4.usuario_id = usu4.id
                        LEFT JOIN comentarios_likes as like4 ON like4.comentario_id = com4.id
                            LEFT JOIN reportes_comentario as rep4 ON rep4.comentario_id = com4.id
                                LEFT JOIN comentarios_likes as color4 ON color4.comentario_id = com4.id
                                    LEFT JOIN comentarios as tend4 ON tend4.id = com4.id
                        
                LEFT JOIN comentarios as com5 ON com4.id = com5.padre_id
                    LEFT JOIN usuarios as usu5 ON com5.usuario_id = usu5.id
                        LEFT JOIN comentarios_likes as like5 ON like5.comentario_id = com5.id
                            LEFT JOIN reportes_comentario as rep5 ON rep5.comentario_id = com5.id
                                LEFT JOIN comentarios_likes as color5 ON color5.comentario_id = com5.id
                                    LEFT JOIN comentarios as tend5 ON tend5.id = com5.id
                        
                LEFT JOIN comentarios as com6 ON com5.id = com6.padre_id
                    LEFT JOIN usuarios as usu6 ON com6.usuario_id = usu6.id
                        LEFT JOIN comentarios_likes as like6 ON like6.comentario_id = com6.id 
                            LEFT JOIN reportes_comentario as rep6 ON rep6.comentario_id = com6.id
                                LEFT JOIN comentarios_likes as color6 ON color6.comentario_id = com6.id
                                    LEFT JOIN comentarios as tend6 ON tend6.id = com6.id
                        
                LEFT JOIN comentarios as com7 ON com6.id = com7.padre_id
                    LEFT JOIN usuarios as usu7 ON com7.usuario_id = usu7.id
                        LEFT JOIN comentarios_likes as like7 ON like7.comentario_id = com7.id 
                            LEFT JOIN reportes_comentario as rep7 ON rep7.comentario_id = com7.id
                                LEFT JOIN comentarios_likes as color7 ON color7.comentario_id = com7.id
                                    LEFT JOIN comentarios as tend7 ON tend7.id = com7.id
                        
                LEFT JOIN comentarios as com8 ON com7.id = com8.padre_id
                    LEFT JOIN usuarios as usu8 ON com8.usuario_id = usu8.id
                        LEFT JOIN comentarios_likes as like8 ON like8.comentario_id = com8.id 
                            LEFT JOIN reportes_comentario as rep8 ON rep8.comentario_id = com8.id
                                LEFT JOIN comentarios_likes as color8 ON color8.comentario_id = com8.id
                                    LEFT JOIN comentarios as tend8 ON tend8.id = com8.id
                        
            WHERE comentarios.id = $com_id
            GROUP BY comentarios.id, com1.id, com2.id, com3.id, com4.id, com5.id, com6.id, com7.id, com8.id;";
    
    $qry = mysqli_query($conn, $sql);
    if(!$qry){
        die(mysqli_error($conn));
    }

    echo json_encode(mysqli_fetch_all($qry, MYSQLI_NUM));
?>
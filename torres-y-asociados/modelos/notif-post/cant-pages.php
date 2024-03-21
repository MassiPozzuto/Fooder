<?php
    require_once "../../includes/config.php";
    //require_once "../usuario-actual.php";
    
    $id = $_GET['id'];
    $cantPostsToShow = $_GET['cantPosts'];

    $query='SELECT *
            FROM usuarios 
            INNER JOIN publicaciones 
                ON usuarios.id=publicaciones.usuario_id 
            WHERE publicaciones.fecha_baja IS NULL AND publicaciones.id = '. $id
    ;

    $res = mysqli_query($conn, $query);

    if(!$res){
        die('Error de Consulta');
    }

    $cantPosts = ceil(mysqli_num_rows($res) / $cantPostsToShow);

    echo $cantPosts;
?>
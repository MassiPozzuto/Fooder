<?php
    require_once "../../includes/config.php";
    require_once "../../modelos/usuario-actual.php";

    $language = parse_ini_file("../../languages/$lang.ini", true);

    $publicacionId = $_GET['publicacionId'];

    $query = "SELECT COUNT(publicacion_id) FROM publicaciones_likes WHERE publicacion_id = '". $publicacionId ."'";
    $likes_amount = mysqli_query($conn, $query);

    if(!$likes_amount){
        die(mysqli_error($conn));
    }

    if($likes = mysqli_fetch_assoc($likes_amount)){
        foreach ($likes as $like_publicacion){
            if($like_publicacion == 0){
                echo $language['feed-principal']['like'];
            }
            else{
                echo $like_publicacion;
            }
        }
    }
?>
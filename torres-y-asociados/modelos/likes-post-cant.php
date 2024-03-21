<?php
    require_once "../includes/config.php";

    $post_id = $_GET['idP'];

    $query = "SELECT COUNT(publicacion_id) AS cantidad FROM publicaciones_likes WHERE publicacion_id = $post_id";
    $likes_amount = mysqli_query($conn, $query);
    if(!$likes_amount){
        die(mysqli_error($conn));
    }
    $likes = mysqli_fetch_assoc($likes_amount);

    $result['likes'] = $likes['cantidad'];
    if($result['likes'] == 0){
        $result['likes']="LIKE";
    }
    echo json_encode($result); 
?>
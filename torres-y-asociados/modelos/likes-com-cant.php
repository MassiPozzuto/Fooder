<?php
    require_once "../includes/config.php";

    $com_id = $_GET['id'];

    $query = "SELECT COUNT(comentario_id) AS cantidad FROM comentarios_likes WHERE comentario_id = $com_id";
    $likes_amount = mysqli_query($conn, $query);
    if(!$likes_amount){
        die(mysqli_error($conn));
    }
    $likes = mysqli_fetch_assoc($likes_amount);

    $result['likes'] = $likes['cantidad'];

    echo json_encode($result);
?>
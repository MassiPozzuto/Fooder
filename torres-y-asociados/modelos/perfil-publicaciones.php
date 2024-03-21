<?php
    $query = "SELECT * FROM publicaciones WHERE usuario_id = ". $user['id'] ." ORDER BY id DESC LIMIT 6";
    $result = mysqli_query($conn,$query);

    if(!$result){
        die(mysqli_error($conn));
    }
    
    $publicaciones = mysqli_fetch_assoc($result);
    $cantPublicaciones = mysqli_num_rows($result);
?>

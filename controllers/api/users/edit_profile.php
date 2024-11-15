<?php

require_once "../../../includes/config.php";

//Actualizo variable $_SESSION['user']
if (isset($_SESSION['user'])) {
    $sqlUserLogged = "SELECT users.*, users_roles.role_id FROM users 
                      LEFT JOIN users_roles 
                        ON users.id = users_roles.user_id
                      WHERE users.id = " . $_SESSION['user']['id'] . ";";
    $resultUserLogged = mysqli_query($conn, $sqlUserLogged);

    if (mysqli_num_rows($resultUserLogged) > 0) {
        $row = mysqli_fetch_assoc($resultUserLogged);
        $_SESSION['user'] = $row;
        $test['user'] = $row;

        $userFolder = "../../../images/profiles/" . $_SESSION['user']['id'] . "/";

        if (is_dir($userFolder)) {
            $files = scandir($userFolder);
            $files = array_diff($files, array('.', '..', 'default.jpg'));

            // Verifica si hay archivos en la carpeta
            if (!empty($files)) {
                $profileImage = array_values($files)[0]; // Primer archivo encontrado
                $test['profilePic'] = "../../images/profiles/" . $_SESSION['user']['id'] . "/" . $profileImage;
            }
        } else {
            $test['profilePic'] = 'default';
        }
        $test['status'] = "success";
        echo json_encode($test, JSON_UNESCAPED_SLASHES);
    }
} else {
    echo json_encode((["error" => "Sesión no activa"]));
    header('location: login.php');
}

<?php



require_once "../../includes/config.php";

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
    echo json_encode($test);
  }
} else {
  echo json_encode((["error" => "Sesión no activa"]));
  header('location: login.php');
}


$page = "Editar perfil";
$section = "edit_profile";
require_once "../../views/layout.php";

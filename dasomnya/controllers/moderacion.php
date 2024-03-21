<?php
require_once "../server/config.php";

require_once "../server/check_user_logged.php";
if (!isset($_SESSION['datos'])) {
  header("Location: login");
} else if ($_SESSION['datos']['role_id'] == 2) {
  header("Location: 405");
}
if (!isset($_GET['section'])) {
  header("Location: ?section=moderation");
}

if (!isset($_GET['page']) || isset($_GET['page']) == NULL || $_GET['page'] == '') {

  $page_number = 1;
} else {

  $page_number = $_GET['page'];
}
$limite = 6;

$initial_page = ($page_number - 1) * $limite;


if ($_GET['section'] == 'moderationusers') {

  $sqlget = "SELECT * 
  FROM users
  LEFT JOIN moderationlogusers
      ON users.ID = moderationlogusers.Affected_User_ID
  WHERE moderationlogusers.Affected_User_ID = users.ID AND moderationlogusers.moderationStatus_ID = 1;";
  $resultget = mysqli_query($conn, $sqlget);
  if (!$resultget) {
    die('Error de consulta de paginador: ' . mysqli_error($conn));
  }


  $sqlModerationUser = "SELECT * 
                    FROM users
                    LEFT JOIN moderationlogusers
                        ON users.ID = moderationlogusers.Affected_User_ID
                    WHERE moderationlogusers.Affected_User_ID = users.ID AND moderationlogusers.moderationStatus_ID = 1
                    LIMIT " . $initial_page . ',' . $limite .";" ;


  //$sqlModerationManga = "SELECT * FROM moderationlogmanga ;";

  $resultModerationUser = mysqli_query($conn, $sqlModerationUser);
  if (!$resultModerationUser) {
    die("Error de consulta " . mysqli_error($conn));
  }


  $numModerationUser = mysqli_num_rows($resultModerationUser);


  $rowModerationUser = mysqli_fetch_all($resultModerationUser, MYSQLI_ASSOC);
  $total_rows = mysqli_num_rows($resultget);
    $total_pages = ceil($total_rows / $limite);
}
if ($_GET['section'] == 'moderationcomments') {
  
  $sqlget = "SELECT * 
  FROM users
  LEFT JOIN moderationlogcomment
      ON users.ID = moderationlogcomment.af_user
  LEFT JOIN comments ON comments.c_ID = moderationlogcomment.comments_ID
  WHERE moderationlogcomment.af_user = users.ID AND moderationlogcomment.moderationStatus_ID = 1;";
  $resultget = mysqli_query($conn, $sqlget);
  if (!$resultget) {
    die('Error de consulta de paginador: ' . mysqli_error($conn));
  }
  
  
  $sqlModerationComment =  "SELECT * 
    FROM users
    LEFT JOIN moderationlogcomment
        ON users.ID = moderationlogcomment.af_user
    LEFT JOIN comments ON comments.c_ID = moderationlogcomment.comments_ID
    WHERE moderationlogcomment.af_user = users.ID AND moderationlogcomment.moderationStatus_ID = 1
    LIMIT " . $initial_page . ',' . $limite .";" ;
    
    
  $resultModerationComment = mysqli_query($conn, $sqlModerationComment);
  if (!$resultModerationComment) {
    die("Error de consulta " . mysqli_error($conn));
  }
  $numModerationComment = mysqli_num_rows($resultModerationComment);
  $rowModerationComment = mysqli_fetch_all($resultModerationComment, MYSQLI_ASSOC);

  $total_rows = mysqli_num_rows($resultget);
  $total_pages = ceil($total_rows / $limite);
}

//Administracion de usuarios

if ($_GET['section'] == 'administration') {
  if ($_SESSION['datos']['role_id'] == 3) {
    header("Location: moderacion.php?section=moderation");
  }
  if (!isset($_GET['roles']) || ($_GET['roles'] == NULL)) {
    header("Location: moderacion.php?section=administration&roles=todos&page=1");
  }

  //Paginador


  if (!isset($_GET['page']) || isset($_GET['page']) == NULL || $_GET['page'] == '') {

    $page_number = 1;
  } else {

    $page_number = $_GET['page'];
  }
  $limite = 6;

  $initial_page = ($page_number - 1) * $limite;

  if ($_GET['roles'] === 'todos') {
    $sqlget = "SELECT users.*, profiles.role_id, roles.name
    FROM users
    LEFT JOIN profiles
        ON users.ID = profiles.user_id
    LEFT JOIN roles
        ON profiles.role_id = roles.id";
    $resultget = mysqli_query($conn, $sqlget);
    if (!$resultget) {
      die('Error de consulta de paginador: ' . mysqli_error($conn));
    }

    $sqlAdministration = "SELECT users.*, profiles.role_id, roles.name
                            FROM users
                            LEFT JOIN profiles
                                ON users.ID = profiles.user_id
                            LEFT JOIN roles
                                ON profiles.role_id = roles.id
                                LIMIT " . $initial_page . ',' . $limite . ";";

    $resultAdministration = mysqli_query($conn, $sqlAdministration);
    if (!$resultAdministration) {
      die("Error de consulta: " . mysqli_error($conn));
    }
    $rowAdministration = mysqli_fetch_all($resultAdministration, MYSQLI_ASSOC);

    $total_rows = mysqli_num_rows($resultget);
    $total_pages = ceil($total_rows / $limite);

    //El rol es usuario
  } else if ($_GET['roles'] === 'usuarios') {
    
    $sqlget = "SELECT users.*, profiles.role_id, roles.name
    FROM users
    LEFT JOIN profiles
        ON users.ID = profiles.user_id
    LEFT JOIN roles
        ON profiles.role_id = roles.id
    WHERE roles.name = 'Usuario'";
    $resultget = mysqli_query($conn, $sqlget);
    if (!$resultget) {
      die('Error de consulta de paginador: ' . mysqli_error($conn));
    }

    $sqlAdministration = "SELECT users.*, profiles.role_id, roles.name
    FROM users
    LEFT JOIN profiles
        ON users.ID = profiles.user_id
    LEFT JOIN roles
        ON profiles.role_id = roles.id
    WHERE roles.name =  'Usuario'  
    LIMIT " . $initial_page . ',' . $limite . ";";

    $resultAdministration = mysqli_query($conn, $sqlAdministration);
    if (!$resultAdministration) {
      die("Error de consulta: " . mysqli_error($conn));
    }
    $rowAdministration = mysqli_fetch_all($resultAdministration, MYSQLI_ASSOC);

    $total_rows = mysqli_num_rows($resultget);
    $total_pages = ceil($total_rows / $limite);
    //El rol es moderador
  } else if ($_GET['roles'] === 'moderadores') {
    $sqlget = "SELECT users.*, profiles.role_id, roles.name
    FROM users
    LEFT JOIN profiles
        ON users.ID = profiles.user_id
    LEFT JOIN roles
        ON profiles.role_id = roles.id
    WHERE roles.name = 'Moderador'";
    $resultget = mysqli_query($conn, $sqlget);
    if (!$resultget) {
      die('Error de consulta de paginador: ' . mysqli_error($conn));
    }

    $sqlAdministration = "SELECT users.*, profiles.role_id, roles.name
    FROM users
    LEFT JOIN profiles
        ON users.ID = profiles.user_id
    LEFT JOIN roles
        ON profiles.role_id = roles.id
    WHERE roles.name =  'Moderador'  
    LIMIT " . $initial_page . ',' . $limite . ";";   

    $resultAdministration = mysqli_query($conn, $sqlAdministration);
    if (!$resultAdministration) {
      die("Error de consulta: " . mysqli_error($conn));
    }
    $rowAdministration = mysqli_fetch_all($resultAdministration, MYSQLI_ASSOC);

    $total_rows = mysqli_num_rows($resultget);
    $total_pages = ceil($total_rows / $limite);
    // El rol es administrador
  } else if ($_GET['roles'] === 'administradores') {
    $sqlget = "SELECT users.*, profiles.role_id, roles.name
    FROM users
    LEFT JOIN profiles
        ON users.ID = profiles.user_id
    LEFT JOIN roles
        ON profiles.role_id = roles.id
    WHERE roles.name = 'Administrador'";
    $resultget = mysqli_query($conn, $sqlget);
    if (!$resultget) {
      die('Error de consulta de paginador: ' . mysqli_error($conn));
    }

    $sqlAdministration = "SELECT users.*, profiles.role_id, roles.name
    FROM users
    LEFT JOIN profiles
        ON users.ID = profiles.user_id
    LEFT JOIN roles
        ON profiles.role_id = roles.id
    WHERE roles.name =  'Administrador'  
    LIMIT " . $initial_page . ',' . $limite . ";";   

    $resultAdministration = mysqli_query($conn, $sqlAdministration);
    if (!$resultAdministration) {
      die("Error de consulta: " . mysqli_error($conn));
    }
    $rowAdministration = mysqli_fetch_all($resultAdministration, MYSQLI_ASSOC);

    $total_rows = mysqli_num_rows($resultget);
    $total_pages = ceil($total_rows / $limite);
  }
}



/* Codigo para la moderacion futura, por ahora solo es de usuarios y comentarios
$resultModerationComment= mysqli_query($conn, $sqlModerationComment);
if(!$resultModerationComment){
    die("Error de consulta " . mysqli_error($conn));
}

$rowModerationComment = mysqli_fetch_all($resultModerationComment);

$resultModerationManga = mysqli_query($conn, $sqlModerationManga);
if(!$resultModerationManga){
    die("Error de consulta" . mysqli_error($conn));
}
$rowModerationManga = mysqli_fetch_all($resultModerationManga);
*/
$view = "moderacion";
require_once "../views/layout.php";

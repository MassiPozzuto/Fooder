<?php



require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

$page = (isset($_POST['page'])) ? $_POST['page'] : 1;
$message = ["status" => "error"];
if ($_POST['for'] == 'searches') {
  $search = trim($_POST['search']);
  if (isset($_SESSION['user'])) {
    //Datos de los usuarios buscado. También verifica si el usuario logueado sigue a la cuenta buscada
    $sqlAccounts = "SELECT users.*, tbl_verify_follow.verify_follow FROM users 
                    LEFT JOIN (SELECT followed_id, COUNT(id) as verify_follow 
                              FROM follows
                              WHERE follower_id = '" . $_SESSION['user']['id'] . "'
                              GROUP BY followed_id) AS tbl_verify_follow
                          ON users.id = tbl_verify_follow.followed_id
                    WHERE users.username LIKE '%" . $search . "%' AND users.deleted_at IS NULL ";
  } else {
    //Datos de los usuarios buscado. NO hay usuario logueado
    $sqlAccounts = "SELECT * FROM users WHERE username LIKE '%" . $search . "%' AND deleted_at IS NULL ";
  }
} else if ($_POST['for'] == 'users_followeds') {
  if (isset($_SESSION['user'])) {
    ////Datos de los usuarios followeds. Tambien verfica si el usuario logueado sigue a los followeds
    $sqlAccounts = "SELECT users.id, users.username,  users.biography, tbl_verify_follow.verify_follow 
                            FROM users 
                            INNER JOIN follows ON users.id = follows.followed_id 
                            LEFT JOIN (SELECT followed_id, COUNT(id) as verify_follow 
                                    FROM follows
                                    WHERE follower_id = '" . $_SESSION['user']['id'] . "'
                                    GROUP BY followed_id) AS tbl_verify_follow
                                ON users.id = tbl_verify_follow.followed_id
                            WHERE follows.follower_id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL";
  } else {
    //Datos de los usuarios followeds. NO hay usuario logueado
    $sqlAccounts = "SELECT users.id, users.username,  users.biography  
                            FROM users 
                            INNER JOIN follows ON users.id = follows.followed_id 
                            WHERE follows.follower_id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL";
  }
} else if ($_POST['for'] == 'users_followers') {
  if (isset($_SESSION['user'])) {
    //Datos de los usuarios followers. Tambien verfica si el usuario logueado sigue a los followers
    $sqlAccounts = "SELECT users.id, users.username,  users.biography, tbl_verify_follow.verify_follow
                            FROM users 
                            INNER JOIN follows ON users.id = follows.follower_id 
                            LEFT JOIN (SELECT followed_id, COUNT(id) as verify_follow 
                                    FROM follows
                                    WHERE follower_id = '" . $_SESSION['user']['id'] . "'
                                    GROUP BY followed_id) AS tbl_verify_follow
                                ON users.id = tbl_verify_follow.followed_id
                            WHERE follows.followed_id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL";
  } else {
    //Datos de los usuarios follower_ids. NO hay usuario logueado
    $sqlAccounts = "SELECT users.id, users.username,  users.biography  
                            FROM users 
                            INNER JOIN follows ON users.id = follows.follower_id 
                            WHERE follows.followed_id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL";
  }
} else if ($_POST['for'] == 'accounts_reported_mod') {
  if ($_SESSION['user']['role_id'] != 1) {
    //Para cuentas reportadas
    $sqlAccounts = "SELECT users.*, users_roles.role_id FROM users 
                    INNER JOIN users_roles ON users.id = users_roles.user_id
                    INNER JOIN reports ON users.id = reports.reported_user_id
                    WHERE users.deleted_at IS NULL AND reports.reported_user_id IS NOT NULL AND reports.resolved_at IS NULL
                    GROUP BY users.id";
  }
} else if ($_POST['for'] == 'accounts_all') {
  if ($_SESSION['user']['role_id'] != 1) {
    //Para todas las cuentas 
    $sqlAccounts = "SELECT users.*, tbl_accounts_reports.amt_reports AS amt_reports, users_roles.role_id  FROM users
                    INNER JOIN users_roles ON users.id = users_roles.user_id
                    LEFT JOIN (SELECT reported_user_id, COUNT(id) AS amt_reports FROM reports 
                               	WHERE resolved_at IS NULL
                              	GROUP BY reported_user_id) AS tbl_accounts_reports  
                      ON users.id = tbl_accounts_reports.reported_user_id
                    WHERE users.deleted_at IS NULL
                    GROUP BY users.id
                    ORDER BY users.username ASC";
  }
} else if ($_POST['for'] == 'accounts_banned_mod') {
  if ($_SESSION['user']['role_id'] != 1) {
    //para cuentas baneadas
    $sqlAccounts = "SELECT users.*, bans.id AS ban_id, bans.start_at AS ban_start, bans.end_at AS ban_end, users_roles.role_id FROM users 
                    INNER JOIN users_roles ON users.id = users_roles.user_id
                    INNER JOIN bans ON users.id = bans.user_id
                    WHERE users.deleted_at IS NULL AND (bans.end_at > now() OR bans.permaban IS NOT NULL)";
  }
} else if ($_POST['for'] == 'accounts_rol_mod') {
  if ($_SESSION['user']['role_id'] != 1) {
    //para cuentas mod
    $sqlAccounts = "SELECT users.*, tbl_accounts_reports.amt_reports AS amt_reports, users_roles.role_id  FROM users
                    INNER JOIN users_roles ON users.id = users_roles.user_id
                    LEFT JOIN (SELECT reported_user_id, COUNT(id) AS amt_reports FROM reports 
                               	WHERE resolved_at IS NULL
                              	GROUP BY reported_user_id) AS tbl_accounts_reports  
                      ON users.id = tbl_accounts_reports.reported_user_id
                    WHERE users.deleted_at IS NULL AND users_roles.role_id = " . $_POST['rol_sekeer'] .
      " GROUP BY users.id
                    ORDER BY users.username ASC";
  }
} else if($_POST['for'] == 'profile_mobile'){
  if (isset($_SESSION['user'])) {
    // Para los datos del usuario, cant. de recetas, cant. de followers, cant. de followeds. También verifica si el usuario logueado lo sigue. RECORDAT1ORIO QUE ME RECUERDA UNA COSA A RECORDAR
    $sqlAccounts = "SELECT users.*, COUNT(recipes.id) AS cant_recipes, tbl_cant_followers.cant_followers, tbl_cant_followeds.cant_followeds, tbl_verify_follow.verify_follow 
                      FROM users 
                      LEFT JOIN recipes ON users.id = recipes.user_id 
                      LEFT JOIN 
                          (SELECT followed_id, COUNT(followed_id) AS cant_followers FROM follows 
                          INNER JOIN users
                          ON follows.follower_id = users.id
                          WHERE followed_id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL) AS tbl_cant_followers
                          ON users.id = tbl_cant_followers.followed_id
                      LEFT JOIN 
                          (SELECT follower_id, COUNT(follower_id) AS cant_followeds FROM follows 
                          INNER JOIN users
                          ON follows.followed_id = users.id
                          WHERE follower_id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL) AS tbl_cant_followeds
                          ON users.id = tbl_cant_followeds.follower_id
                      LEFT JOIN (SELECT followed_id, COUNT(id) as verify_follow 
                              FROM follows
                              WHERE follower_id = '" . $_SESSION['user']['id'] . "'
                              GROUP BY followed_id) AS tbl_verify_follow
                          ON users.id = tbl_verify_follow.followed_id
                      WHERE users.id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL AND recipes.deleted_at IS NULL";
  } else {
    // Para los datos del usuario, cant. de recetas, cant. de followers, cant. de followeds. NO verifica si el user logueado lo sigue (no esta logueado)
    $sqlAccounts = "SELECT users.*, COUNT(recipes.id) AS cant_recipes, tbl_cant_followers.cant_followers, tbl_cant_followeds.cant_followeds FROM users 
                      LEFT JOIN recipes ON users.id = recipes.user_id 
                      LEFT JOIN 
                          (SELECT followed_id, COUNT(followed_id) AS cant_followers FROM follows 
                          INNER JOIN users
                          ON follows.follower_id = users.id
                          WHERE followed_id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL) AS tbl_cant_followers
                          ON users.id = tbl_cant_followers.followed_id
                      LEFT JOIN 
                          (SELECT follower_id, COUNT(follower_id) AS cant_followeds FROM follows 
                          INNER JOIN users
                          ON follows.followed_id = users.id
                          WHERE follower_id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL) AS tbl_cant_followeds
                          ON users.id = tbl_cant_followeds.follower_id
                      WHERE users.id = '" . $_POST['profile_id'] . "' AND users.deleted_at IS NULL";
  }
}

$resultAccounts = mysqli_query($conn, $sqlAccounts);
if (!$resultAccounts) {
  die('Error de Consulta' . mysqli_error($conn));
}

if($_POST['for'] == 'profile_mobile'){
  $account = mysqli_fetch_assoc($resultAccounts);

  $account['profile_pic'] = profile_image($_POST['profile_id']);
  $account['username'] = htmlspecialchars($account['username']);
  $account['name'] = htmlspecialchars($account['name']);
  $account['biography'] = htmlspecialchars($account['biography']);

  $message = [
    'message' => "Hecho",
    'status' => "success",
    'user_logged_id' => (isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : null,
    'accountData' => $account,
  ];


} else {
  $amt_total_reg = mysqli_num_rows($resultAccounts);
  $amt_accounts_page = ceil(mysqli_num_rows($resultAccounts) / CANT_REG_PAG);
  
  $sqlAccounts .= " LIMIT " . CANT_REG_PAG * ($page - 1) . ", " . CANT_REG_PAG;
  $resultAccounts = mysqli_query($conn, $sqlAccounts);
  if (!$resultAccounts) {
    die('Error de Consulta' . mysqli_error($conn));
  }
  $rowAccounts = mysqli_fetch_all($resultAccounts, MYSQLI_ASSOC);
  
  foreach ($rowAccounts as $key => $value) {
    $rowAccounts[$key]['profile_pic'] = profile_image($value['id']);
  
    $rowAccounts[$key]['username'] = htmlspecialchars($rowAccounts[$key]['username']);
    $rowAccounts[$key]['name'] = htmlspecialchars($rowAccounts[$key]['name']);
    $rowAccounts[$key]['biography'] = htmlspecialchars($rowAccounts[$key]['biography']);
  }
  
  $message = [
    'message' => "Hecho",
    'status' => "success",
    'user_logged_id' => (isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : null,
    'user_logged_role_id' => (isset($_SESSION['user']['role_id'])) ? $_SESSION['user']['role_id'] : null,
    'accounts' => $rowAccounts,
    'amt_accounts_page' => $amt_accounts_page,
    'amt_total_reg' => $amt_total_reg
  ];
}



header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));

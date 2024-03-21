<?php
session_start();
require_once "../server/config.php";

if (isset($_SESSION['datos'])) {
    $sqlUserLogged = "SELECT * 
    FROM users 
    LEFT JOIN profiles
        ON users.ID = profiles.user_id
    WHERE users.ID = '" . $_SESSION['datos']['ID'] ."'";
    $resultUserLogged = mysqli_query($conn, $sqlUserLogged);


    if (mysqli_num_rows($resultUserLogged) > 0) {
        $row = mysqli_fetch_assoc($resultUserLogged);
        $_SESSION['datos'] = $row;
    }
} else {
    header('location: login');
    
}

$sqlPreferences = "SELECT * FROM userprofile WHERE User_ID ='".$_SESSION['datos']['ID']. "'";
$resultPreferences = mysqli_query ($conn, $sqlPreferences);
if(!$resultPreferences){
    die ("Error de consulta: " . mysqli_error($conn));
}else{
    $rowPreferences = mysqli_fetch_array($resultPreferences, MYSQLI_ASSOC);
    
}


if(!empty($_POST)){
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $biography = mysqli_real_escape_string($conn, $_POST['biography']);
    $newpassword = $_POST['newpassword'];
    $newpassword2 = $_POST['newpassword2'];
    $favourite = $_POST['favourite'];
    $likes = $_POST['likes'];

    

    if((!empty($newpassword) && !empty($newpassword2)) && ($newpassword === $newpassword2)){
        $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
        $newpassword2 = password_hash($newpassword2, PASSWORD_DEFAULT);


        $sqlChangePassword = "UPDATE users SET Password = '$newpassword' WHERE ID= '". $_SESSION['datos']['ID'] ."'   ";
        $resultChangePassword = mysqli_query($conn, $sqlChangePassword);
        if(!$resultChangePassword){
            die("Error de consulta de contraseña: " . mysqli_error($conn));
        }else if($resultChangePassword){
            header("Location: configuracion_perfil.php?error=none");
        }

    }

    $sqlCheckEmail = "SELECT * FROM users WHERE Email='$email' AND Email != '" . $_SESSION['datos']['Email'] . "'";
    $resultCheckEmail = mysqli_query($conn, $sqlCheckEmail);
    if ((!mysqli_num_rows($resultCheckEmail) > 0) && ($username != null && strlen($username) < 21) && ($email != null && strlen($email) < 65) && (preg_match('/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/', $email)) && (strlen($biography) < 129)) {
        $sqlEdit = "UPDATE users SET name = '$username', Email = '$email' WHERE ID= '" . $_SESSION['datos']['ID'] . "'";
        $resultEdit = mysqli_query($conn, $sqlEdit);
       if(!$resultEdit){
        die ("Error de consulta: " . mysqli_error($conn));
       }else{
        $sqlEditPreferences = "UPDATE userprofile SET show_favourite = '$favourite', show_likes = '$likes', description = '$biography' WHERE User_ID = '" . $_SESSION['datos']['ID']."'";
        $resultEditPreferences = mysqli_query($conn, $sqlEditPreferences);
        if(!$resultEditPreferences){
            die ("Error de consulta 2: " . mysqli_error($conn));
        }else if ($resultEdit && $resultEditPreferences     ){
            header("Location: configuracion_perfil.php?error=none");
        }
    }
    }else{
         // Ya existe una cuenta con ese email
         if (mysqli_num_rows($resultCheckEmail)) $errormessage_email = "El correo electronico ya esta en uso.";
        
         // Maximo de caracteres
         if (strlen($username) > 21) $errormessage_username = "El nombre de usuario es demasiado largo";
         if (strlen($email) > 64) $errormessage_email = "El correo electronico es demasiado largo";
         if (strlen($biography) > 128) $errormessage_email = "La biografia demasiado larga";
         if (!preg_match('/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/', $email)) $errormessage_email = "Ingrese un correo electronico valido";

        // Campos vacios
        if (!$email) $errormessage_email = "Por favor ingrese un correo electronico";
        if (!$username) $errormessage_username =  "Por favor ingrese un nombre de usuario";
    }


}



$view = "configuracion_perfil";
require_once "../views/layout.php";
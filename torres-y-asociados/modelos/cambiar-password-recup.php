<?php
    require_once "../includes/config.php";
    session_start();
    $correoUsur = $_SESSION['correoUsur'];

    if (!empty($_POST)) {
        $new_pass = sha1($_POST['password']);

        $sql = "UPDATE usuarios SET clave = '$new_pass' WHERE email='$correoUsur'";
        if (mysqli_query($conn, $sql)) {
            session_unset();
            session_destroy();
            header("Location: ../login.php");
        } else {
            die('Error de Consulta' . mysqli_error($conn));
        }
    }
?>
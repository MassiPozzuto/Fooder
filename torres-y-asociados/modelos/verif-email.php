<?php
session_start();

require_once '../includes/config.php';
if(isset($_POST['email'])){
    /* Registro */
    $email = $_POST['email'];

    $validar_email = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuarios.email = '" . $email . "'");
    
    if (!$validar_email) {
        die(mysqli_error($conn));
    }
    
    if (mysqli_num_rows($validar_email) == 0) {
        echo (true);
    } else {
        echo (false);
    }
}else if(isset($_POST['emailVerif_log'])){
    /* Login */
    $email = $_POST['emailVerif_log'];
    $validar_email = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuarios.email = '" . $email . "'");
    if (!$validar_email) {
        die(mysqli_error($conn));
    }
    if (mysqli_num_rows($validar_email) == 1) {
        echo (true);
    } else {
        echo (false);
    }
}else if(isset($_POST['email_recup'])){
    /* Recuperacion de Cuentas */
    $email = $_POST['email_recup'];
    $validar_email = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuarios.email = '" . $email . "'");
    if (!$validar_email) {
        die(mysqli_error($conn));
    }
    if (mysqli_num_rows($validar_email) >= 1) {
        echo (true);
    } else {
        echo (false);
    }
}
?>
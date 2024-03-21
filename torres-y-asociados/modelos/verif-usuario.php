<?php
session_start();

require_once '../includes/config.php';
if(!isset($_POST['emailVerif_log'])){
    /* Registro */
    $nombreUsu = $_POST['nombreUsuario'];
    $validar_usu = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuarios.nombreUsuario = '" . $nombreUsu . "'");
    if (!$validar_usu) {
        die(mysqli_error($conn));
    }
    if (mysqli_num_rows($validar_usu) == 0) {
        echo (true);
    } else {
        echo (false);
    }
}
?>
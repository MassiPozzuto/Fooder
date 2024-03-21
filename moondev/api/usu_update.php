<?php

require_once("mysqli_connector.php");
createConnection();
$response = new stdClass();

//$response -> state=true;
$id_usu = $_POST['id_usu'];
$usuario_usu = $_POST['usuario_usu'];
$mail_usu = $_POST['mail_usu'];
$clave_usu = $_POST['clave_usu'];
$monedas_usu = $_POST['monedas_usu'];
$personaje_id = $_POST['personaje_id'];


if ($usuario_usu == "") {
    $response->state = false;
    $response->detail = "Falta el usuario";
} else {
    if ($mail_usu == "") {
        $response->state = false;
        $response->detail = "Falta el mail";
    } else {
        if ($clave_usu == "") {
            $response->state = false;
            $response->detail = "Falta la contraseña";
        } else {
            if ($monedas_usu == "") {
                $response->state = false;
                $response->detail = "Las monedas no estan definidas";
            } else {
                if (isset($personaje_id)) {
                    $sql = "UPDATE usuarios SET usuario = '$usuario_usu', mail = '$mail_usu', clave = '$clave_usu', monedas = '$monedas_usu' , personaje_id = '$personaje_id' WHERE id = '$id_usu'";
                    $result = mysqli_query($GLOBALS["mysqli"], $sql);
                    if ($result) {
                        $response->state = true;
                    } else {
                        $response->state = false;
                        $response->detail = "No se pudo actualizar el usuario";
                    }
                }
            }
        }
    }
}
mysqli_close($GLOBALS["mysqli"]);
echo json_encode($response);

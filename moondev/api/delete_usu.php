<?php

require_once("mysqli_connector.php");
createConnection();

$response = new stdClass();

$id_usu = $_POST['id_usu'];
$sql = "UPDATE usuarios SET deleted_at = NOW() WHERE id=" . $id_usu . ";";

$result = mysqli_query($GLOBALS["mysqli"], $sql);

if ($result) {
    $response->state = true;
    $response->eeee = $sql;
} else {
    $response->state = false;
    $response->detail = "No se pudo eliminar el objeto";
}
mysqli_close($GLOBALS["mysqli"]);
echo json_encode($response);

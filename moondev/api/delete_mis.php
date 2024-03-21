<?php

require_once("mysqli_connector.php");
createConnection();

$response = new stdClass();

$id_mis = $_POST['id_mis'];
$sql = "DELETE FROM misiones WHERE id=$id_mis";

$result = mysqli_query($GLOBALS["mysqli"], $sql);

if ($result) {
    $response->state = true;
} else {
    $response->state = false;
    $response->detail = "No se pudo eliminar el objeto";
}

mysqli_close($GLOBALS["mysqli"]);
echo json_encode($response);

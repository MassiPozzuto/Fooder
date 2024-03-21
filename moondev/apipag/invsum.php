<?php
session_start();
require_once("../api/mysqli_connector.php");
createConnection();
$response = new stdClass();
$datos = [];
$i = 0;
$userid = $_SESSION['userid'];
$sql = "SELECT objetos.* FROM objetos INNER JOIN inventarios ON inventarios.objeto_id = objetos.id INNER JOIN usuarios ON inventarios.usuario_id = usuarios.id WHERE usuarios.id = $userid;";
$result = mysqli_query($GLOBALS["mysqli"], $sql);
while ($row = mysqli_fetch_array($result)) {
     $obj = new stdClass();
     $obj->timered = $row['timered'];
     $obj->droprate = $row['droprate'];
     $obj->goldaum = $row['goldaum'];
     $obj->winrate = $row['winrate'];
     $datos[$i] = $obj;
     $i++;
}

$response->datos = $datos;

mysqli_close($GLOBALS["mysqli"]);
header('Content-Type: application/json');
echo json_encode($response);

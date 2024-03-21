<?php
session_start();
require_once("../api/mysqli_connector.php");
createConnection();
$response = new stdClass();
$datos = [];
$i = 0;
$userid = $_SESSION['userid'];
$sql = "SELECT objetos.* FROM objetos INNER JOIN inventarios ON inventarios.objeto_id = objetos.id INNER JOIN usuarios ON inventarios.usuario_id = usuarios.id WHERE usuarios.id = $userid AND inventarios.equiped = '0';";
$result = mysqli_query($GLOBALS["mysqli"], $sql);
while ($row = mysqli_fetch_array($result)) {
     $obj = new stdClass();
     $obj->id = $row['id'];
     $obj->nombreobj = $row['nombre'];
     $obj->descripcion = $row['descripcion'];
     $obj->precio = $row['precio'];
     $obj->ruta_img = $row['img'];
     $obj->parte = $row['part'];
     $datos[$i] = $obj;
     $i++;
}

$response->datos = $datos;

mysqli_close($GLOBALS["mysqli"]);
header('Content-Type: application/json');
echo json_encode($response);

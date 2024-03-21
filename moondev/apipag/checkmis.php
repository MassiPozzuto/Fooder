<?php
session_start();
date_default_timezone_set("America/Argentina/Buenos_Aires");

require_once("../api/mysqli_connector.php");
createConnection();


$i = 0;
$response = new stdClass();
$obj = new stdClass();
$userid = $_SESSION['userid'];


$sql = "SELECT * FROM misiones INNER JOIN misiones_en_curso ON misiones.id = misiones_en_curso.id_mision WHERE usuario_id = $userid AND showed = 0 ORDER BY misiones.id LIMIT 1 ";
$result = mysqli_query($GLOBALS["mysqli"], $sql);
$row = mysqli_fetch_array($result);
if (isset($row)){
$sql3 = "SELECT * FROM misiones_en_curso WHERE usuario_id = $userid ORDER BY id DESC LIMIT 1";
$result12 = mysqli_query($GLOBALS["mysqli"], $sql3);
$row2 = mysqli_fetch_array($result12);
if (isset($row2)){
    $obj->idmec = $row['id'];
    $idmec = $obj->idmec;
}
    $obj->expiration = $row['expiration'];
    $obj->result = $row['result'];
    $obj->id = $row['id'];
    $obj->descripcion = $row['descripcion'];
    $obj->titulo = $row['titulo'];
    $obj->img = $row['nombre_img'];
    $expira = $obj->expiration;
$sql34 = "SELECT * FROM tiradas WHERE id_mec = $idmec;";
$result9 = mysqli_query($GLOBALS["mysqli"], $sql34);
if (!($result9)) {
    $response->error = mysqli_error($GLOBALS["mysqli"]);
    echo (json_encode($response));
}
while ($row7 = mysqli_fetch_array($result9)) {
    $obj->resultiradas[$i] = $row7['result'];
    $obj->datiradas[$i] = $row7['rolldate'];
    $datos[$i] = $obj;
    $i++;
}
}else{
    $obj->expiration = null;
    $expira = $obj->expiration;
}

$datos=$obj;
$response->datos = $datos;
mysqli_close($GLOBALS["mysqli"]);
header('Content-Type: application/json; charset=utf-8');
echo (json_encode($response));                      

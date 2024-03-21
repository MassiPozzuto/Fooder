<?php
session_start();
require_once("../api/mysqli_connector.php");
createConnection();
$response = new stdClass;

$userid = $_SESSION['userid'];
$codpro = $_POST['id'];
$part = $_POST['parte'];

/*
$userid = 1;
$codpro = 4;
$part = "Cabeza";
*/
$sql = "SELECT * FROM objetos INNER JOIN inventarios ON inventarios.objeto_id = objetos.id INNER JOIN usuarios ON inventarios.usuario_id = usuarios.id WHERE usuarios.id = $userid AND objetos.part = '$part' ;";
//$sql = "SELECT inventarios.* FROM objetos INNER JOIN inventarios ON inventarios.objeto_id = objetos.id INNER JOIN usuarios ON inventarios.usuario_id = usuarios.id WHERE usuarios.id = $userid AND inventarios.objeto_id = $codpro;";
$result = mysqli_query($GLOBALS["mysqli"], $sql);
$row = mysqli_fetch_array($result);
if (isset($row['equiped'])) {
   //$sql1 = UPDATE inventarios INNER JOIN (SELECT id FROM objetos WHERE part = "Arma") AS oid ON inventarios.usuario_id = 1 AND inventarios.objeto_id = oid.id SET equiped = "0"; 
   // https://stackoverflow.com/questions/51977955/update-table-using-a-select-query
   $sql1 = 'UPDATE inventarios INNER JOIN (SELECT id FROM objetos WHERE part = "' . $part . '") AS oid ON inventarios.usuario_id = ' . $_SESSION["userid"] . ' AND inventarios.objeto_id = oid.id SET equiped = "0" ;';
   $res = mysqli_query($GLOBALS["mysqli"], $sql1);
   $sql2 = "UPDATE inventarios SET equiped = '1' WHERE usuario_id = " . $_SESSION["userid"] . " AND objeto_id = $codpro LIMIT 1;";
   $res1 = mysqli_query($GLOBALS["mysqli"], $sql2);
}
mysqli_close($GLOBALS["mysqli"]);
header('Content-Type: application/json; charset=utf-8');
echo (json_encode($response));
//echo ($sql1 . "||||" . $sql2);

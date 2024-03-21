<?php
session_start();
require_once("../api/mysqli_connector.php");
createConnection();
$timenowx = time();
$userid = $_SESSION['userid'];
$response = new stdClass();
$datos = new stdClass();
$droprateobj = intval($_POST['droprate']);
$orocook = intval($_POST['oro']);
$random = rand(1, 100);
$monedascurr = intval($_SESSION["coins"]);
$monedastot = $monedascurr + $orocook;
$sql3 = "UPDATE usuarios SET monedas = $monedastot WHERE id = $userid";
$result4 = mysqli_query($GLOBALS["mysqli"], $sql3);
if ($random <= $droprateobj) {
    $sql1 = "SELECT COUNT(id) FROM objetos";
    $result1 = mysqli_query($GLOBALS["mysqli"], $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $objrand = $row1['COUNT(id)'];
    $random = rand(1, $objrand);
    $sql2 = "INSERT INTO inventarios (objeto_id, usuario_id, cantidad, created) VALUES ('$random', '$userid', 1, NOW())";
    $response->detail = mysqli_real_query($GLOBALS["mysqli"], $sql2);
    $sql3 = "SELECT img FROM objetos WHERE id= $random ";
    $result = mysqli_query($GLOBALS["mysqli"], $sql3);
    $datos->img = $result->fetch_assoc()["img"];
    $response->datos = $datos;
} else {
    $datos = 'undefined';
    $response->datos = $datos;
}
mysqli_close($GLOBALS["mysqli"]);
header('Content-Type: application/json');
echo json_encode($response);

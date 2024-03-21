<?php
session_start();
require_once("../api/mysqli_connector.php");
createConnection();
$timenowx = time();
$userid = $_SESSION['userid'];
$response = new stdClass();
$sql3 = "SELECT recompensa FROM usuarios WHERE id = $userid;";
$result2 = mysqli_query($GLOBALS["mysqli"], $sql3);
$row2 = mysqli_fetch_assoc($result2);
$epoch = strtotime($row2["recompensa"]);

if (($timenowx >= ($epoch + 86400)) || ($epoch == null)) {
    $sql4 = "UPDATE usuarios SET recompensa = NOW() WHERE id = $userid;";
    $response2 = mysqli_query($GLOBALS["mysqli"], $sql4);
    $sql1 = "SELECT max(id) as max_objeto, min(id) AS min_objeto FROM objetos";
    $result1 = mysqli_query($GLOBALS["mysqli"], $sql1);
    $row1 = mysqli_fetch_assoc($result1);
    $objrand = $row1['max_objeto'];
    $random = rand($row1["min_objeto"], $row1["max_objeto"]);
    $sql2 = "INSERT INTO inventarios (objeto_id, usuario_id, cantidad, created)
VALUES ('$random', '$userid', 1, NOW())";
    $response->detail = mysqli_real_query($GLOBALS["mysqli"], $sql2);
    $sql3 = "SELECT img, nombre FROM objetos WHERE id=" . $random;
    $result = mysqli_query($GLOBALS["mysqli"], $sql3);
    $final_info = $result->fetch_assoc();
    $response->nombre = $final_info["nombre"];
    $response->img = $final_info["img"];
} else {
    $response->detail = false;
    //echo "<button class='abrir' onclick='abrir()' disabled>Abrir</button>";
}

mysqli_close($GLOBALS["mysqli"]);
header('Content-Type: application/json');
echo json_encode($response);

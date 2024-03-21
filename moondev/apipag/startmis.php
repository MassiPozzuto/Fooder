<?php
date_default_timezone_set("America/Argentina/Buenos_Aires");
session_start();
require_once("../api/mysqli_connector.php");
createConnection();
$response = new stdClass();
$datos = [];
$i = 0;
$userid = $_SESSION['userid'];
$idmis = intval($_POST['id']);
$winrateobj = intval($_POST['winrateobj']);
$droprateobj = intval($_POST['droprateobj']);
$timeredobj = intval($_POST['timeredobj']);
$goldaumobj = intval($_POST['goldaumobj']);
$obj = new stdClass();
$mis = new stdClass();
$obj3 = new stdClass();
$sql = "SELECT * FROM misiones WHERE id = $idmis";
$result = mysqli_query($GLOBALS["mysqli"], $sql);

if (!($result)) {
    $response->error = mysqli_error($GLOBALS["mysqli"]);
    echo (json_encode($response));
}
$row = mysqli_fetch_array($result);
$obj->winrate = $row['winrate'];
$obj->gold = $row['oro'];
$obj->time = $row['tiempo'];
$obj->droprate = $row['droprate'];
$datos[$i] = $obj;


$winratemis = $obj->winrate;
$goldmis = $obj->gold;
$timemis = $obj->time;
$dropratemis = $obj->droprate;

$winratef = $winrateobj + $winratemis;
$dropratef = $dropratemis + $droprateobj;
$obj->dropratef = $dropratef;
if ($goldaumobj > 100) {
    $goldf = $goldmis * 2;
    $obj->goldf = $goldf;
} else {
    $multi = $goldaumobj / 100 + 1;
    $goldf = $goldmis * $multi;
    $obj->goldf = $goldf;
}

if ($timeredobj > 100) {
    $timef = $timemis / 2;
} else {
    $timeredperc = ($timeredobj / 100);
    $timef = $timemis - ($timemis * $timeredperc);
}

$horactual = time();

$date = $timef + $horactual;

$fechaexp = date('Y-m-d H:i:s', $date);
$fechainicio = date('Y-m-d H:i:s', $horactual);

$sql1 = "INSERT INTO misiones_en_curso (usuario_id, id_mision, expiration, inicio) VALUES ($userid, $idmis, '$fechaexp', '$fechainicio');";
$result = mysqli_query($GLOBALS["mysqli"], $sql1);

//$sql2 = "SELECT * FROM misiones_en_curso WHERE usuario_id = $userid AND id_mision = $idmis";
//$result2 = mysqli_query($GLOBALS["mysqli"], $sql2);

//if (!($result2)) {
//   $response2->error = mysqli_error($GLOBALS["mysqli"]);
//   echo (json_encode($response2));
//}

//$row2 = mysqli_fetch_array($result2);
$mis->start = $fechainicio;
$mis->exp = $fechaexp;
$mis->id = mysqli_insert_id($GLOBALS["mysqli"]);
$misdat[$i] = $mis;


$inicio = $mis->start;
$fin = $mis->exp;
$idmec = $mis->id;

$obj->idmec = $idmec;

$tiradafirst = rand(1, 100);

if ($tiradafirst <= $winratef) {
    $firstresult = 1;
} else {
    $firstresult = 0;
}

$start = time();
$fechaini = date('Y-m-d H:i:s', $start);

$sql3 = "INSERT INTO tiradas (id_mec, rolldate, result) VALUES ($idmec, '$fechaini', $firstresult);";
$result3 = mysqli_query($GLOBALS["mysqli"], $sql3);

$cantroll = round($timef / 900);

$roll = 1;

while ($roll <= $cantroll) {

    $tirada = rand(1, 100);

    if ($tirada <= $winratef) {
        $result = 1;
    } else {
        $result = 0;
    }

    $rolldate = $start + 900 * $roll;

    $fecharoll = date('Y-m-d H:i:s', $rolldate);

    $sql4 = "INSERT INTO tiradas (id_mec, rolldate, result) VALUES ($idmec, '$fecharoll', $result);";
    $result4 = mysqli_query($GLOBALS["mysqli"], $sql4);

    $roll++;
}

$sql4 = "SELECT AVG(result) FROM tiradas WHERE id_mec = $idmec;";
$result4 = mysqli_query($GLOBALS["mysqli"], $sql4);
$row3 = mysqli_fetch_array($result4);
$obj3->avg = $row3['AVG(result)'];
$datos[$i] = $obj3;

$average = $obj3->avg;

if ($average > 0.51) {
    $resultmec = 1;
} else {
    $resultmec = 0;
}

$sql5 = "UPDATE misiones_en_curso SET result = $resultmec WHERE id = $idmec;";
$result = mysqli_query($GLOBALS["mysqli"], $sql5);


$datos = $obj;
$response->datos = $datos;

mysqli_close($GLOBALS["mysqli"]);
header('Content-Type: application/json; charset=utf-8');
echo (json_encode($response));

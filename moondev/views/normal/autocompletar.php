<?php
session_start();
require_once("../../api/mysqli_connector.php");
createConnection();

$html = '';
$key = $_POST['key'];
/*
    $seccion = $_GET['seccion'];
    $from = (isset($_GET['from'])) ? $_GET['from'] : '';

    if($seccion == 'online'){
        $query = "SELECT objetos.nombre AS objeto_nombre FROM objetos_venta ov INNER JOIN objetos ON ov.objeto_id = objetos.id AND objetos.se_vende = 'Si' AND ov.usuario_id !=" . $_SESSION["userid"] . " INNER JOIN username_history uh ON uh.usuario_id = ov.usuario_id AND uh.deleted_at IS NULL WHERE objetos.nombre LIKE '%" .$key."%' ORDER BY nombre ASC LIMIT 0, 5";
    }else if($seccion == 'mercado'){
        $query = 'SELECT *, objetos.nombre AS objeto_nombre FROM objetos WHERE objetos.nombre LIKE "%' .$key.'%" ORDER BY nombre ASC LIMIT 0, 5';
    }else{
        if($from == 'online'){
            $query = "SELECT objetos.nombre AS objeto_nombre FROM objetos_venta ov INNER JOIN objetos ON ov.objeto_id = objetos.id AND objetos.se_vende = 'Si' AND ov.usuario_id !=" . $_SESSION["userid"] . " INNER JOIN username_history uh ON uh.usuario_id = ov.usuario_id AND uh.deleted_at IS NULL WHERE objetos.nombre LIKE '%" .$key."%' ORDER BY nombre ASC LIMIT 0, 5";
        }else{
            $query = 'SELECT *, objetos.nombre AS objeto_nombre FROM objetos WHERE objetos.nombre LIKE "%' .$key.'%" ORDER BY nombre ASC LIMIT 0, 5';
        }
    }
*/

$query = 'SELECT * FROM objetos WHERE objetos.nombre LIKE "%' . $key . '%" ORDER BY nombre ASC LIMIT 0, 5';
$result = mysqli_query($GLOBALS["mysqli"], $query);

if (!$result) {
    die("error de consulta: " . mysqli_error($GLOBALS["mysqli"]));
}

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<div><a class="resultado_elemento" href="index.php?seccion=busqueda&object_name=' . trim($row['nombre']) . '">' . $row['nombre'] . '</a></div>';
    }
} else if (mysqli_num_rows($result) == 0) {
    $html = "No se encontro ningun objeto.";
}

echo $html;

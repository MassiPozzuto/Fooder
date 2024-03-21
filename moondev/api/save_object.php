<?php

require_once("mysqli_connector.php");
createConnection();

$response = new stdClass();

//$response -> state=true;
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$rareza = $_POST['rareza'];
$enventa = $_POST['enventa'];
$parte = $_POST['parte'];
if ($nombre == "") {
    $response->state = false;
    $response->detail = "Falta el nombre";
} else {
    if ($descripcion == "") {
        $response->state = false;
        $response->detail = "Falta la descripcion";
    } else {
        if ($precio == "") {
            $response->state = false;
            $response->detail = "Falta el precio";
        } else {
            if ($rareza == "") {
                $response->state = false;
                $response->detail = "Falta La rareza";
            } else 
            if ($parte == "") {
                $response->state = false;
                $response->detail = "Falta La parte";
            } else {
                if (isset($_FILES['imagen'])) {
                    $nombre_imagen = date("YmdHis") . ".jpg";
                    $sql = "INSERT INTO objetos (nombre, descripcion, precio, rareza, img, se_vende, part)
                     VALUES ('$nombre', '$descripcion', $precio, $rareza, '$nombre_imagen', $enventa, '$parte')";
                    $result = mysqli_query($GLOBALS["mysqli"], $sql);
                    if ($result) {
                        if (move_uploaded_file($_FILES['imagen']['tmp_name'], "../img/objetos/" . $nombre_imagen)) {
                            $response->state = true;
                        } else {
                            $response->state = false;
                            $response->detail = "Error al cargar la imagen";
                        }
                    } else {
                        $response->state = false;
                        $response->detail = "No se pudo crear el objeto";
                    }
                } else {
                    $response->state = false;
                    $response->detail = "Falta la imagen";
                }
            }
        }
    }
}
mysqli_close($GLOBALS["mysqli"]);
echo json_encode($response);

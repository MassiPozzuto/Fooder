<?php

require_once("mysqli_connector.php");
createConnection();

$response = new stdClass();

//$response -> state=true;
$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$rareza = $_POST['rareza'];
$enventa = $_POST['enventa'];
$rutimgobj = $_POST['rutimgobj'];
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
            } else {
                if ($parte == "") {
                    $response->state = false;
                    $response->detail = "Falta la parte";
                } else {
                    if (isset($_FILES['imagen'])) {
                        $nombre_imagen = date("YmdHis") . ".jpg";
                        $sql = "UPDATE objetos SET nombre = '$nombre', descripcion = '$descripcion', precio = $precio, rareza = $rareza, se_vende = $enventa, img = '$nombre_imagen', part = '$parte' WHERE id = '$codigo'";
                        $result = mysqli_query($GLOBALS["mysqli"], $sql);
                        if ($result) {
                            if (move_uploaded_file($_FILES['imagen']['tmp_name'], "../img/objetos/" . $nombre_imagen)) {
                                $response->state = true;
                                // Siempre antes de modificar un archivo o objeto, verificar que el mismo exista.
                                if (file_exists("/../img/objetos/" . $rutimgobj)) {
                                    unlink("/../img/objetos/" . $rutimgobj);
                                }
                            } else {
                                $response->state = false;
                                $response->detail = "Error al cargar la imagen";
                            }
                        } else {
                            $response->state = false;
                            $response->detail = "No se pudo actualizar el objeto";
                        }
                    } else {
                        $sql = "UPDATE objetos SET nombre = '$nombre', descripcion = '$descripcion', precio = $precio, rareza = $rareza, se_vende = $enventa, part = '$parte' WHERE id = '$codigo'";
                        $result = mysqli_query($GLOBALS["mysqli"], $sql);
                        if ($result) {
                            $response->state = true;
                        } else {
                            $response->state = false;
                            $response->detail = "No se pudo actualizar el objeto";
                        }
                    }
                }
            }
        }
    }
}
mysqli_close($GLOBALS["mysqli"]);
echo json_encode($response);

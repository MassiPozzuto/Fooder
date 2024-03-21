<?php

require_once("mysqli_connector.php");
createConnection();

$response = new stdClass();

//$response -> state=true;
$id_mis = $_POST['id_mis'];
$titulo_mis = $_POST['titulo_mis'];
$descripcion_mis = $_POST['descripcion_mis'];
$oro_mis = $_POST['oro_mis'];
$winrate_mis = $_POST['winrate_mis'];
$droprate_mis = $_POST['droprate_mis'];
$rutimgmis = $_POST['mis_rutaimg'];
$tiempo_mis = $_POST['tiempo_mis'];

if ($titulo_mis == "") {
    $response->state = false;
    $response->detail = "Falta el Titulo";
} else {
    if ($descripcion_mis == "") {
        $response->state = false;
        $response->detail = "Falta la descripcion";
    } else {
        if ($oro_mis == "") {
            $response->state = false;
            $response->detail = "Falta la recompensa";
        } else {
            if ($winrate_mis == "") {
                $response->state = false;
                $response->detail = "Falta el winrate";
            } else {
                if ($droprate_mis == "") {
                    $response->state = false;
                    $response->detail = "Falta el droprate";
                } else {
                    if (isset($_FILES['mis_rutaimg'])) {
                        $nombre_imagen = date("YmdHis") . ".jpg";
                        $sql = "UPDATE misiones SET titulo = '$titulo_mis', descripcion = '$descripcion_mis', tiempo = $tiempo_mis, oro = $oro_mis, winrate = $winrate_mis, droprate = $droprate_mis, rutaimg = '$nombre_imagen' WHERE id = '$id_mis'";
                        $result = mysqli_query($GLOBALS["mysqli"], $sql);
                        if ($result) {
                            if (move_uploaded_file($_FILES['mis_rutaimg']['tmp_name'], "../img/" . $nombre_imagen)) {
                                $response->state = true;
                                unlink("../img/" . $rutimgmis);
                            } else {
                                $response->state = false;
                                $response->detail = "Error al cargar la imagen";
                            }
                        } else {
                            $response->state = false;
                            $response->detail = "No se pudo actualizar la mision";
                        }
                    } else {
                        $sql = "UPDATE misiones SET titulo = '$titulo_mis', descripcion = '$descripcion_mis', tiempo = $tiempo_mis, oro = $oro_mis, winrate = $winrate_mis, droprate = $droprate_mis WHERE id = '$id_mis'";
                        $result = mysqli_query($GLOBALS["mysqli"], $sql);
                        if ($result) {
                            $response->state = true;
                        } else {
                            $response->state = false;
                            $response->detail = "No se pudo actualizar la mision";
                        }
                    }
                }
            }
        }
    }
}
mysqli_close($GLOBALS["mysqli"]);
echo json_encode($response);

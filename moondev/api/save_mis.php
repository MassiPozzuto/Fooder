<?php

require_once("mysqli_connector.php");
createConnection();

$response = new stdClass();

//$response -> state=true;
$titulo_mis = $_POST['titulo_mis'];
$descripcion_mis = $_POST['descripcion_mis'];
$oro_mis = $_POST['oro_mis'];
$winrate_mis = $_POST['winrate_mis'];
$droprate_mis = $_POST['droprate_mis'];
$tiempo_mis = $_POST['tiempo_mis'];

if ($titulo_mis == "") {
    $response->state = false;
    $response->detail = "Falta el titulo";
} else {
    if ($descripcion_mis == "") {
        $response->state = false;
        $response->detail = "Falta la descripcion";
    } else {
        if ($oro_mis == "") {
            $response->state = false;
            $response->detail = "Falta la recompensa";
        } else {
            if ($tiempo_mis == "") {
                $response->state = false;
                $response->detail = "Falta la duracion";
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
                            $sql = "INSERT INTO misiones (titulo, descripcion, tiempo, oro, winrate, nombre_img, droprate)
                     VALUES ('$titulo_mis', '$descripcion_mis', $tiempo_mis, $oro_mis, $winrate_mis, '$nombre_imagen', $droprate_mis)";
                            $result = mysqli_query($GLOBALS["mysqli"], $sql);
                            if ($result) {
                                if (move_uploaded_file($_FILES['mis_rutaimg']['tmp_name'], "../img/" . $nombre_imagen)) {
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
    }
}
mysqli_close($GLOBALS["mysqli"]);
echo json_encode($response);

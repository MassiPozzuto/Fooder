<?php

declare(strict_types=1);

namespace moondev\get_database;

use stdClass;
use systemException;
use autoLogin;

$GLOBALS['response'] = new stdClass;

require_once('system_handler.php');

/*
Este sistema recibe 4 parametros
authority int (0, 1). Indica si es de gestion pagina o de una pagina normal
getInformation. Indica que queremos obtener, objetos, misiones, etc.
getInfoID. int, parametro opcional. si lo ingresamos nos agregara un WHERE
        que obtendra solo la fila que contenga esa id, en caso de no ingresarlo
        obtendra todo con un * sin especificar.
selectedPage int. Indica la pagina seleccionada actualmente en el paginador,
        Arranca desde el numero uno.

Como enviar los parametros (POST Obligatorio, por GET u otros tirara error):
information = new FormData;
information.append("authority", "0") (OBLIGATORIO)
inf0rmation.append("getInformation, "objetos"; (OBLIGATORIO)
information.append("getInfoID", "22") (OPCIONAL) (Si no se desea seleccionar uno solo no poner este append) 
information.append("selectedPage", (pagina)); (OPCIONAL) (si no se establece no se traera un LIMIT y se traera TODO)
xhttp.send(information);
*/

//throw new systemException("global.ErrorException", 500, "global_error");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Valido que las variables obligatorias esten establecidas, caso contrario tirar exepcion.
    require_once("auth/islogged.php");
    $GLOBALS["autoLogin"] = new autoLogin;
    if ($GLOBALS["autoLogin"]->isLogged() !== true) {
        throw new systemException("global.not_logged", 401, "global_error");
    }

    if (isset($_REQUEST['authority']) !== true) {
        throw new systemException('global.authority.unset', 400, "global_error");
    }
    if (isset($_REQUEST['getInformation']) !== true) {
        throw new systemException('global.getInformation.unset', 400, "global_error");
    }

    require_once "mysqli_connector.php";
    createClass();

    if (isset($_REQUEST["getInfoID"])) {
        if (is_numeric($_REQUEST["getInfoID"]) !== true) {
            throw new systemException("global.getInfoID.non_numeric", 400, "global_error");
        }
        $GLOBALS['response']->getInfoID = $_REQUEST['getInfoID'];
        $getInfoID = $_REQUEST["getInfoID"];
    } else if (isset($_REQUEST["getLikeTEXT"]) == true) {
        $GLOBALS["response"]->getLikeTEXT = $_REQUEST["getLikeTEXT"];
        $getLikeTEXT = $GLOBALS["mysqli"]->real_escape_string($_REQUEST["getLikeTEXT"]);
    }

    if (isset($_REQUEST['selectedPage'])) {
        if (is_numeric($_REQUEST["selectedPage"]) !== true) {
            throw new systemException("global.selectedPage.non_numeric", 400, "global_error");
        }
        $GLOBALS['response']->selectedPage = $_REQUEST['selectedPage'];
    } else {
        $GLOBALS['response']->selectedPage = 1;
    }
    $GLOBALS['response']->getInformation = $_REQUEST['getInformation'];
    $GLOBALS['response']->authority = $_REQUEST['authority'];
    define("PAGES", 10);
    function expired_items()
    {
        require_once("../apipag/buy_and_sell/restore_expired_items.php");
        restoreItems();
    }
    //Estos dos switch ambos contienen las querys que se van a ejecutar segun la pagina
    //Sin embargo hay dos switch, y su definicion es el que primero se entra si se establecio authority a 1
    //Y al segundo si se establecio authority a 0, la idea es que un usuario comun y corriente no pueda acceder
    //A las consultas de administracion. Al establecer authority a 1 se valida si $_SESSION["systemRights"]
    //esta fijado a 1, osea rol de administrador.
    if ($_POST['authority'] === '1') {
        if ($GLOBALS["autoLogin"]->adminRights() !== true) {
            throw new systemException("global.non_administrator", 401, "global_error");
        } else {
            //Switch de administracion
            switch ($_REQUEST['getInformation']) {
                case "usuariosadm":
                    $query = "SELECT u.id, eh.mail, ui.username AS username, u.clave, u.personaje_id, u.monedas, p.id AS systemRights, u.created_at, u.deleted_at, u.last_password_change, u.recompensa FROM usuarios u INNER JOIN roles r ON u.id = r.usuario_id INNER JOIN perfil p ON r.perfil_id = p.id INNER JOIN username_history ui ON u.id = ui.usuario_id AND ui.deleted_at IS NULL INNER JOIN email_history eh ON eh.usuario_id = u.id AND eh.deleted_at IS NULL";
                    $selector = "usuariosadm";
                    break;
                case "objetos":
                    $query = "SELECT * from objetos";
                    $selector = "objetos";
                    break;
                case "misionesadm":
                    $query = "SELECT * from misiones";
                    $selector = "misionesadm";
                    break;
                default:
                    throw new systemException('global.getInformation.unknow_selector', 400, "global_error");
                    break;
            }
        }
    } else {
        //Switch de usuarios
        switch ($_REQUEST['getInformation']) {
            case "misiones":
                $query = "SELECT * FROM misiones /*INNER JOIN misiones_en_curso ON misiones_en_curso.id_mision = misiones.id*/";
                $selector = "misiones";
                break;
            case "objetos":
                $query = "SELECT * from objetos";
                $selector = "objetos";
                break;
            //Aca podemos ver nuestros propios objetos a la venta
            case "online_seller":
                expired_items();
                $query = "
                SELECT ov.*, uh.username AS username, objetos.nombre AS objeto_nombre, objetos.descripcion AS objeto_descripcion, objetos.rareza AS objeto_rareza, objetos.se_vende
                AS objeto_se_vende, objetos.img as objeto_img, objetos.part AS objeto_part FROM objetos_venta ov 
                INNER JOIN objetos ON ov.objeto_id = objetos.id AND objetos.se_vende = 'Si' AND ov.usuario_id =" . $_SESSION["userid"] . " INNER JOIN username_history uh ON uh.usuario_id = ov.usuario_id AND uh.deleted_at IS NULL";
                $selector = "online";
                break;
            //Aca los de otra persona
            case "online":
                expired_items();
                $query = "
                SELECT ov.*, uh.username AS username, objetos.nombre AS objeto_nombre, objetos.descripcion AS objeto_descripcion, objetos.rareza AS objeto_rareza, objetos.se_vende
                AS objeto_se_vende, objetos.img as objeto_img, objetos.part AS objeto_part FROM objetos_venta ov 
                INNER JOIN objetos ON ov.objeto_id = objetos.id AND objetos.se_vende = 'Si' AND ov.usuario_id !=" . $_SESSION["userid"] . " INNER JOIN username_history uh ON uh.usuario_id = ov.usuario_id AND uh.deleted_at IS NULL";
                $selector = "online";
                break;
                //Aca es el vendedor el que vendio y mostramos el nombre del comprador
            case "purchase_history_seller":
                expired_items();
                $query = "SELECT ph.*, objetos.nombre AS objeto_nombre, uh.username AS user FROM purchase_history ph INNER JOIN objetos ON ph.objeto_id = objetos.id INNER JOIN username_history uh ON ph.usuario_id = uh.usuario_id AND uh.deleted_at IS NULL WHERE ph.seller_id =" . $_SESSION["userid"];
                $selector = "purchase_history_user";
                break;
                //Aca es el usuario el que compro y mostramos el nombre del vendedor
            case "purchase_history_buyer":
                expired_items();
                $query = "SELECT ph.*, objetos.nombre AS objeto_nombre, uh.username AS user FROM purchase_history ph INNER JOIN objetos ON ph.objeto_id = objetos.id LEFT JOIN username_history uh ON ph.seller_id = uh.usuario_id AND uh.deleted_at IS NULL WHERE ph.usuario_id =" . $_SESSION["userid"];
                $selector = "purchase_history_user";
                break;
            case "purchase_history_admin":
                expired_items();
                //$query = "SELECT phsub.*, uh.username AS Comprador, uh2.username AS Vendedor FROM username_history uh INNER JOIN (SELECT ph.*, objetos.nombre AS objeto_nombre, objetos.descripcion AS objeto_descripcion, objetos.rareza AS objeto_rareza, objetos.img AS objeto_img, objetos.part AS objeto_part FROM purchase_history ph INNER JOIN objetos ON ph.objeto_id = objeto_id) AS phsub ON phsub.usuario_id = uh.usuario_id AND uh.deleted_at IS NULL LEFT JOIN username_history uh2 ON phsub.seller_id = uh2.usuario_id AND uh2.deleted_at IS NULL";
                $query = "SELECT phsub.*, uh.username AS Comprador, uh2.username AS Vendedor FROM username_history uh INNER JOIN (SELECT ph.*, objetos.nombre AS objeto_nombre FROM purchase_history ph INNER JOIN objetos ON ph.objeto_id = objetos.id) AS phsub ON phsub.usuario_id = uh.usuario_id AND uh.deleted_at IS NULL LEFT JOIN username_history uh2 ON phsub.seller_id = uh2.usuario_id AND uh2.deleted_at IS NULL WHERE phsub.usuario_id=" . $_SESSION["userid"];
                $selector = "purchase_history";
                break;
            case "objetos_venta":
                $query = "SELECT * FROM objetos WHERE se_vende = 1";
                $selector = "objetos";
                break;
            case "inventario":
                expired_items();
                $query = "SELECT objetos.* FROM objetos INNER JOIN inventarios ON inventarios.objeto_id = objetos.id INNER JOIN usuarios ON inventarios.usuario_id = usuarios.id";
                $selector = "inventario";
                break;
            case "diary":
                $query = "SELECT recompensa FROM usuarios WHERE id=" . $_SESSION["userid"];
                $selector = "diary";
                break;
            case "user_info":
                $query = 'SELECT u.id as "userid", uh.username AS "Nombre de Usuario", uh.created_at AS "Ultimo cambio de nombre", u.created_at AS "Fecha de Activacion", u.last_password_change AS "Ultimo cambio de credencial", u.monedas AS "Monedas", eh.mail AS "Email", eh.created_at AS "Ultimo cambio de Email" FROM usuarios u INNER JOIN email_history eh ON eh.usuario_id = u.id AND eh.deleted_at IS NULL INNER JOIN username_history uh ON u.id = uh.usuario_id AND uh.deleted_at IS NULL WHERE u.id=' . $_SESSION["userid"];
                $selector = "user_info";
                break;
            case "email_history":
                $query = "SELECT mail AS email, created_at AS 'Fecha de creacion', deleted_at AS 'Fecha de eliminacion' FROM email_history WHERE usuario_id=" . $_SESSION["userid"];
                $selector = "history";
                break;
            case "username_history":
                $query = "SELECT username AS 'Nombre de usuario', created_at AS 'Fecha de creacion', deleted_at AS 'Fecha de eliminacion' FROM username_history WHERE usuario_id=" . $_SESSION["userid"];
                $selector = "history";
                break;
            default:
                throw new systemException('global.getInformation.unknow_selector', 400, "global_error");
                break;
        }
    }
    //Si esta seteado getInfoID, se le agregara un WHERE a la consulta, esto sirve para indicarle al sistema
    //si desea seleccionar un ID especifico de una columna en toda la query.
    if (isset($getInfoID)) {
        $query .= " WHERE ";
        //Este switch indica que columna en especifico es la que llevara el WHERE, por defecto y casi siempre es id,
        //pero en otros casos puede no ser esa o columna, o ser esa columna y otras mas, por lo que hay otras
        //opciones en el switch en caso de que sea requerido.
        switch ($selector) {
            case "online":
                $query .= "ov.id=";
                break;
            case "inventario":
                $query .= "usuarios.id = " . $_SESSION['userid'] . " AND objetos.id=";
                break;
            case "user_info":
                $query = "u.id=";
                break;
            case "usuariosadm":
                $query .= " p.id=";
                break;
            default:
                $query .= "id=";
                break;
        }
        $query .= intval($getInfoID);
    } else if (isset($getLikeTEXT)) {
        switch ($selector) {
            case "objetos":
                $query .= " AND nombre";
                break;
            case "online":
                $query .= " WHERE objetos.nombre";
                break;
        }
        $query .= " LIKE ";
        $query .= "'%" . $getLikeTEXT . "%'";
    }
    //Aca ordenaremos y agrupamos si es requerido
    switch ($selector) {
        case "usuariosadm":
        case "usuarios":
            $query .= " ORDER BY id DESC";
            break;
        case "purchase_history_user":
            $query .= " ORDER BY created_at DESC";
            break;
        case "purchase_history_admin":
            $query .= " ORDER BY phsub.created_at DESC";
            break;
        case "misionesadm":
        case "objetos":
            $query .= " ORDER BY id ASC";
            break;
        case "online":
            $query .= " ORDER BY ov.id DESC";
            break;
        case "history":
            $query .= " ORDER BY 'Fecha de creacion' DESC";
            break;
        case "inventario":
            $query .= " ORDER BY created DESC";
            break;
    }
    if (isset($GLOBALS["mysqli"]) !== true) {
        createClass();
    }
    //Si se establecio una pagina en concreto, significa que el paginador esta activado para esta consulta
    //Por lo que creo una variable nueva con la misma consulta, a la original le agrego el LIMIT
    //y a la nueva la dejo como antes para ejecutarla y obtener el maximo de registros existentes en la base
    //de datos para consulta en ese momento dado.
    if (isset($_REQUEST["selectedPage"])) {
        $query_not_limiter = $query . ";";
        $query .= " LIMIT " . (PAGES * ($_REQUEST["selectedPage"] - 1)) . ", " . PAGES;
        $result = $GLOBALS["mClass"]->execute_sql($query_not_limiter, "global.query_failed.limiter", 500, "global_error");
        $GLOBALS["response"]->pages = ceil(($result->num_rows) / PAGES);
        unset($result);
    }
    $query .= ";";
    $GLOBALS["response"]->query_preview = $query;
    //Ejecuto la consulta final
    if ($result = $GLOBALS["mClass"]->execute_sql($query, "global.query_failed.final", 500, "global_error")) {
        //Si todo fue un exito, agregar los resultados a la respuesta en forma de arrays asociativos
        //y ejecutar la funcion de exito
        $GLOBALS['response']->result = $result->fetch_all(MYSQLI_ASSOC);
        query_success();
    }
} else {
    throw new systemException('global.invalid_request_method', 405, "global_error");
}

<?php
declare(strict_types=1);

$GLOBALS["response"] = new stdClass;
require_once("../system_handler.php");
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once("../auth/islogged.php");
    $GLOBALS["autoLogin"] = new autoLogin;
    if ($GLOBALS["autoLogin"]->islogged() !== true) {
        header("Location: ../../index.php");
        die;
    } else if ($GLOBALS["autoLogin"]->adminRights() !== true) {
        throw new systemException("global.non_administrator", 403, "global_error");
    }
    if (isset($_REQUEST["id"]) === true) {
        if ((is_numeric($_REQUEST["id"])) && ($_REQUEST["id"] > 0)) {
            $object_id = intval($_REQUEST["id"]);
        } else {
            throw new systemException("global.validateInfo.non_numeric", 400, "global_error");
        }
    } else {
        throw new systemException("global.validateInfo.not_set", 400, "global_error");
    }
    require_once("../mysqli_connector.php");
    createClass();
    $GLOBALS["mysqli"]->begin_transaction();
    try {
        //Borramos el objeto de todas las tablas
        $stmt = $GLOBALS["mysqli"]->prepare("DELETE FROM objetos_bonificaciones WHERE objeto_id=?;");
        $stmt->bind_param('i', $object_id);
        $stmt->execute();
        $stmt = $GLOBALS["mysqli"]->prepare("DELETE FROM purchase_history WHERE objeto_id=?;");
        $stmt->bind_param('i', $object_id);
        $stmt->execute();
        $stmt = $GLOBALS["mysqli"]->prepare("DELETE FROM objetos_venta WHERE objeto_id=?;");
        $stmt->bind_param('i', $object_id);
        $stmt->execute();
        $stmt = $GLOBALS["mysqli"]->prepare("DELETE FROM objetos_equipados WHERE objeto_id=?;");
        $stmt->bind_param('i', $object_id);
        $stmt->execute();
        $stmt = $GLOBALS["mysqli"]->prepare("DELETE FROM inventarios WHERE objeto_id=?;");
        $stmt->bind_param('i', $object_id);
        $stmt->execute();
        // Aca selecciono la img para borrarla*/
        $query = "SELECT img FROM objetos WHERE id=" . $object_id . ";";
        $result = $GLOBALS["mClass"]->execute_sql($query, "global.query_failed.selectObject", 500, "global_error");
        $GLOBALS["mClass"]->numRowIsNotZero('global.query_failed.RowImg', $result, 500, "global_error");
        $img_name = $result->fetch_assoc()["img"];
        $img_route = "../../img/objetos/" . $img_name;
        //Borramos el objeto de la database
        $stmt = $GLOBALS["mysqli"]->prepare("DELETE FROM objetos WHERE id=?;");
        $stmt->bind_param('i', $object_id);
        $stmt->execute();
        // Borramos la Img del archivo
        $GLOBALS["response"]->eeeeeee = $img_route;
        if (file_exists($img_route) === true) {
            unlink($img_route);
        } else {
            throw new systemException("global.query_failed.deleteObjectImg", 500, "global_error");
        }  
        //Si todo fue un exito commiteamos
        $GLOBALS["mysqli"]->commit();
        //AGREGAR SYSTEM EXCEPTION POR SEPARADO
    } catch (mysqli_sql_exception $e) {
        $GLOBALS["mysqli"]->rollback();
        $GLOBALS["response"]->errstr = $e->getMessage();
        throw new systemException("global.query_failed.delete_object", 500, "global_error");
    } catch (systemException $e) {
        $GLOBALS["mysqli"]->rollback();
        throw new systemException($e->getMessage(), $e->getCode(), $e->getInput());
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
    }
    query_success();
} else {
    throw new systemException("global.invalid_request_method", 405, "global_error");
}

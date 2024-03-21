<?php

declare(strict_types=1);

namespace moondev\apipag\buy_and_sell\delete_sell;

use mysqli_sql_exception;
use stdClass;
use Exception;
use systemException;
use autoLogin;

$GLOBALS['response'] = new stdClass;

require_once('../../api/system_handler.php');

if ($_SERVER['REQUEST_METHOD'] ===  'POST') {
    require_once("../../api/mysqli_connector.php");
    require_once("../../api/auth/islogged.php");
    class delete_sell
    {
        final public function __construct()
        {
            $this->AuthChecker();
            $this->validateInfo();
            createClass();
            require_once("../update_user_coins.php");
            getUserCoins();
            $this->deleteAndPublish();
        }
        public function validateInfo(): bool
        {
            if (isset($_REQUEST["object_id"]) !== true) {
                throw new systemException("global.validateInfo.not_set", 400, null);
            } else if (is_numeric($_REQUEST["object_id"]) !== true) {
                throw new systemException("global.validateInfo.non_numeric", 400, null);
            } else {
                $this->object_code = $_REQUEST["object_id"];
            }
            return true;
        }
        private function AuthChecker(): bool
        {
            $GLOBALS["autoLogin"] = new autoLogin;
            if ($GLOBALS["autoLogin"]->isLogged() !== true) {
                header("Location: ../index.php?seccion=homepage");
                die;
            }
            return true;
        }
        private function deleteAndPublish()
        {
            $GLOBALS["mysqli"]->begin_transaction();
            try {
                //Obtenemos el objeto a quitar la venta
                $result = $GLOBALS["mysqli"]->query("SELECT * FROM objetos_venta WHERE id= " . $this->object_code . " AND usuario_id=" . $_SESSION["userid"] . ";");
                $GLOBALS["mClass"]->numRowIsNotZero("global.sale_not_found", $result, 500, null);
                $fetched_sale = $result->fetch_assoc();
                //Lo quitamos de la venta
                $stmt = $GLOBALS["mysqli"]->prepare("DELETE FROM objetos_venta WHERE usuario_id=? AND id=?;");
                $stmt->bind_param('ii', $_SESSION["userid"], $fetched_sale["id"]);
                $stmt->execute();
                //Si no se borro nada tirar excepcion
                if ($stmt->affected_rows == 0) {
                    throw new systemException("global.could_not_delete", 500, null);
                }
                //Lo retornamos al inventario
                $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO inventarios (objeto_id, usuario_id, created, deleted, equiped) VALUES (?, ?, NOW(), NULL, '0');");
                $stmt->bind_param('ii', $fetched_sale["objeto_id"], $fetched_sale["usuario_id"]);
                $stmt->execute();
                $GLOBALS["mysqli"]->commit();
            } catch (mysqli_sql_exception $e) {
                $GLOBALS["mysqli"]->rollback();
                $GLOBALS["response"]->errstr = $e->getMessage();
                throw new systemException("global.query_failed.delete_sale", 500, null);
            } catch (systemException $e) {
                $GLOBALS["mysqli"]->rollback();
                throw new systemException($e->getMessage(), $e->getCode(), $e->getInput());
            } finally {
                if (isset($stmt) === true) {
                    $stmt->close();
                }
            }
            query_success();
        }
    }
    $sell_class_var = new delete_sell;
} else {
    throw new systemException("global.invalid_request_method", 405, null);
}

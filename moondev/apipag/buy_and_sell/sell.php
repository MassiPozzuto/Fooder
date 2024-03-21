<?php

declare(strict_types=1);

namespace moondev\apipag\buy_and_sell\sell;

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
    class sell
    {
        final public function __construct()
        {
            $this->AuthChecker();
            $this->validateInfo();
            createClass();
            require_once("../update_user_coins.php");
            getUserCoins();
            $this->checkMaxCoins();
            $this->deleteAndPublish();
        }
        public function validateInfo(): bool
        {
            if (isset($_POST["object_id"]) !== true) {
                throw new systemException("global.validateInfo.not_set", 400, null);
            } else if (is_numeric($_REQUEST["object_id"]) !== true) {
                throw new systemException("global.validateInfo.non_numeric", 400, null);
            } else {
                $this->object_code = $_REQUEST["object_id"];
            }
            if (isset($_POST["sell_price"]) !== true) {
                throw new systemException("denied.sell_price.not_Set", 400, null);
            } else if (is_numeric($_REQUEST["sell_price"]) !== true) {
                throw new systemException("denied.sell_price.non_numeric", 400, null);
            } else if (($_REQUEST["sell_price"] < 10) || ($_REQUEST["sell_price"] > 999999)) {
                throw new systemException("denied.invalid_price", 400, null);
            } else {
                $this->price = $_REQUEST["sell_price"];
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
        private function checkMaxCoins(): bool
        {
            if (($_SESSION["coins"] + $this->price) > 999999) {
                throw new systemException("denied.too_many_coins", 403, null);
            }
            return true;
        }
        private function deleteAndPublish()
        {
            $GLOBALS["mysqli"]->begin_transaction();
            try {
                $stmt = $GLOBALS["mysqli"]->prepare("DELETE FROM inventarios WHERE usuario_id = ? AND objeto_id = ? LIMIT 1;");
                $stmt->bind_param('ii', $_SESSION["userid"], $this->object_code);
                $stmt->execute();
                if ($stmt->affected_rows == 0) {
                    throw new systemException("global.could_not_delete", 500, null);
                }
                $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO objetos_venta (usuario_id, objeto_id, created_at, expiration_date, price) VALUES (?, ?, NOW(), NOW() + INTERVAL 7 DAY, ?);");
                $stmt->bind_param('iii', $_SESSION["userid"], $this->object_code, $this->price);
                $stmt->execute();
                $GLOBALS["mysqli"]->commit();
            } catch (mysqli_sql_exception $e) {
                $GLOBALS["mysqli"]->rollback();
                $GLOBALS["response"]->errstr = $e->getMessage();
                throw new systemException("global.query_failed.deleteAndPublish", 500, null);
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
    $sell_class_var = new sell;
} else {
    throw new systemException("global.invalid_request_method", 405, null);
}

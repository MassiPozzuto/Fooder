<?php

declare(strict_types=1);

namespace moondev\apipag\buy_and_sell\buy;

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
    class buyObject
    {
        final public function __construct()
        {
            $this->AuthChecker();
            $this->validateInfo();
            createClass();
            require_once("../update_user_coins.php");
            getUserCoins();
            ($_REQUEST["selector"] == "mercado") ? $this->getObjectCoins() : $this->getObjectOnlineCoins(); 
            $this->checkAndUpdate();
        }
        public function validateInfo(): bool
        {
            if (isset($_REQUEST["id"]) !== true) {
                throw new systemException("global.validateInfo.not_set", 400, null);
            } else if (is_numeric($_POST["id"]) !== true) {
                throw new systemException("global.validateInfo.non_numeric", 400, null);
            } else {
                $this->code = $_REQUEST["id"];
            }
            if (isset($_REQUEST["selector"])) {
                if ($_REQUEST["selector"] != "mercado" && $_REQUEST["selector"] != "online") {
                    throw new systemException("global.vlaidateInfo.invalid_selector", 400, null);
                } else {
                    $this->selector = $_REQUEST["selector"];
                }
            } else {
                throw new systemException("global.validateInfo.unknow_selector", 400, null);
            }
            return true;
        }
        private function AuthChecker(): bool
        {
            $autologin = new autoLogin;
            if ($autologin->isLogged() !== true) {
                header("Location: ../index.php?seccion=homepage");
                die;
            }
            return true;
        }
        public function getObjectCoins(): bool
        {
            $query = "SELECT * FROM objetos WHERE id=" . $this->code . ";";
            $result = $GLOBALS["mClass"]->execute_sql($query, "global.query_failed.getObject", 500, null);
            $GLOBALS["mClass"]->numRowIsNotZero("global.sale_not_found", $result, 500, null);
            $information = $result->fetch_assoc();
            $this->price = $information["precio"];
            $this->object_code = $information["id"];
            if ($information["se_vende"] != "si") {
                throw new systemException("denied.not_in_sale", 403, null);
            }
            return true;
        }
        
        public function getObjectOnlineCoins(): bool
        {
            $query = "SELECT * FROM objetos_venta WHERE id=" . $this->code . ";";
            $result = $GLOBALS["mClass"]->execute_sql($query, "global.query_failed.getObject", 500, null);
            $GLOBALS["mClass"]->numRowIsNotZero("global.sale_not_found", $result, 500, null);
            $information = $result->fetch_assoc();
            $this->seller_id = $information["usuario_id"];
            $this->price = $information["price"];
            $this->id = $information["id"];
            $this->object_code = $information["objeto_id"];
            return true;
        }
        public  function checkAndUpdate(): void
        {
            $total = intval($_SESSION["coins"] - $this->price);
            if ($total >= 0) {
                $GLOBALS["mysqli"]->begin_transaction();
                try {
                    $stmt = $GLOBALS["mysqli"]->prepare("UPDATE usuarios SET monedas = ? WHERE id = ?;");
                    $stmt->bind_param('ii', $total, $_SESSION["userid"]);
                    $stmt->execute();
                    $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO inventarios (objeto_id, usuario_id, cantidad, created) VALUES (?, ?, 1, NOW());");
                    $stmt->bind_param('ii', $this->object_code, $_SESSION["userid"]);
                    $stmt->execute();
                    $stmt_history = $GLOBALS["mysqli"]->prepare("INSERT INTO purchase_history(usuario_id, objeto_id, price, seller_id, created_at, deleted_at) VALUES (?, ?, ?, ?, NOW(), NOW() + INTERVAL 7 DAY);");
                    if ($this->selector === "online") {
                        $stmt_history->bind_param('iiii', $_SESSION["userid"], $this->object_code, $this->price, $this->seller_id);
                        $stmt_history->execute();
                        $stmt = $GLOBALS["mysqli"]->prepare("DELETE FROM objetos_venta WHERE id=?;");
                        $stmt->bind_param('i', $this->id);
                        $stmt->execute();
                        $stmt = $GLOBALS["mysqli"]->prepare("UPDATE usuarios SET monedas = monedas+? WHERE id = ?;");
                        $stmt->bind_param('ii', $this->price, $this->seller_id);
                        $stmt->execute();
                    } else {
                        $this->seller_id = null;
                        $stmt_history->bind_param('iiii', $_SESSION["userid"], $this->object_code, $this->price, $this->seller_id);
                        $stmt_history->execute();
                    }
                    $GLOBALS["mysqli"]->commit();
                } catch (mysqli_sql_exception $e) {
                    $GLOBALS["mysqli"]->rollback();
                    $GLOBALS["response"]->errstr = $e->getMessage();
                    throw new systemException("global.query_failed.checkAndUpdate", 500, null);
                } finally {
                    if (isset($stmt) === true) {
                        $stmt->close();
                    }
                }
                $_SESSION["coins"] = $total;
                query_success();
            } else {
                throw new systemException("denied.not_enought_coins", 403, null);
            }
        }
    }
    $buy_class_var = new buyObject;
} else {
    throw new systemException("global.invalid_request_method", 405, null);
}

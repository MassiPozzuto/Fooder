<?php

namespace moondev\api\auth\update;

use stdClass;
use Exception;
use autoLogin;
use systemException;
use mysqli_sql_exception;
use moondev\api\auth\validator\checking;

$GLOBALS['response'] = new stdClass;

require_once('../system_handler.php');

if ($_SERVER['REQUEST_METHOD'] ===  'POST') {
    require_once('user_module.php');
    require_once("../mysqli_connector.php");
    require_once("islogged.php");
    $GLOBALS["autoLogin"] = new autoLogin;
    if ($GLOBALS["autoLogin"]->isLogged() !== true) {
        throw new systemException("global.non_logged", 401, "global_error");
    } else if ($GLOBALS["autoLogin"]->adminRights() !== true) {
        throw new systemException("global.access_denied", 401, "global_error");
    }
    class validateData
    {
        public function __construct()
        {
            $this->validateDataSuccess = false;
            $this->getData();
            $this->validateData();
            $this->validateDataSuccess = true;
        }
        protected function getData(): bool
        {
            $this->userid = checking::dataExists('userid', 'userid.empty', 'userid.non_string', 'userid.slash', false, "userid_error");
            $this->email = checking::dataExists('email1', 'email.empty', 'email.non_string', 'email.slash', true, "email1_error");
            $this->username = checking::dataExists('username1', 'username.empty', 'username.non_string', 'username.slash', true, "username1_error");
            $this->coins =  checking::dataExists('coins', "coins.empty", "coins.non_string", "coins.slash", true, "coins_error");
            $this->personaje_id = checking::dataExists('personaje_id', 'personaje_id.empty', 'personaje_id.non_string', 'personaje_id.slash', true, "personaje_id_error");
            $this->roles = checking::dataExists('roles', 'roles_error.empty', 'roles_error.non_string', 'roles_error.slash', true, "roles_error");
            return true;
        }
        protected function selectAll(int $userid)
        {
            $query = GET_USER_QUERY . " WHERE u.id=" . intval($userid) . ";";
            $result = $GLOBALS["mClass"]->execute_sql($query, "global.query_failed.selectAll", 500, "global_error");
            $GLOBALS["mClass"]->numRowIsNotZero('global.selectAll.unknow_selectAll', $result, 500, "global_error");
            return $result->fetch_assoc();
        }
        protected function validateData(): bool
        {
            checking::validateInt($this->userid, "userid.invalid", "userid_error");
            checking::validateEmail($this->email, "1", true, null);
            checking::validateUsername($this->username, "1", true, false, null);
            checking::validateInt($this->coins, "coins.invalid", "coins_error");
            checking::validatePersonajeID($this->personaje_id, "personaje_id.invalid", "personaje_id_error");
            checking::validateRoles($this->roles, "roles.invalid", "roles_error");
            return true;
        }
    }
    class modifyUser extends validateData
    {
        public function __construct()
        {
            parent::__construct();
            if ($this->validateDataSuccess === true) {
                createClass();
                $this->user_information = $this->selectAll($this->userid);
                //Aca validamos si el email esta en uso o si el usuario ha sido eliminado.
                try {
                    checking::doesUserExists(true, false, true, $this->email, null, false);
                } catch (systemException $e) {
                    if (($e->getMessage() == "email.login_failed")) {
                        throw new systemException("email.deleted", 403, "email1_error");
                    } else if (($e->getMessage() == "email.used") && ($this->email != $this->user_information["mail"])) {
                        throw new systemException("email.used", 403, "email1_error");
                    }
                }
                //Aca validamos si el nombre de usuario esta en uso.
                try {
                    checking::doesUserExists(true, true, false, null, $this->username, false);
                } catch (systemException $e) {
                    if (($e->getMessage() == "username.used") && ($this->username != $this->user_information["username"])) {
                        throw new systemException("username.used", 403, "username1_error");
                    }
                }
                $this->compare_and_execute();
                query_success();
            }
        }

        public function compare_and_execute(): bool
        {
            $GLOBALS["mysqli"]->begin_transaction();
            try {
                $this->userid = intval($this->userid);
                $this->coins = intval($this->coins);
                $this->personaje_id = intval($this->personaje_id);
                $this->roles = intval($this->roles);
                if ($this->email != $this->user_information["mail"]) {
                    $stmt = $GLOBALS["mysqli"]->prepare("UPDATE email_history SET deleted_at = NOW() WHERE usuario_id = ? AND deleted_at IS NULL;");
                    $stmt->bind_param('i', $this->userid);
                    $stmt->execute();
                    $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO email_history(usuario_id, mail, created_at, deleted_at) VALUES (?, ?, NOW(), null);");
                    $stmt->bind_param('is', $this->userid, $this->email);
                    $stmt->execute();
                }
                if ($this->username != $this->user_information["username"]) {
                    $stmt = $GLOBALS["mysqli"]->prepare("UPDATE username_history SET deleted_at = NOW() WHERE usuario_id = ? AND deleted_at IS NULL;");
                    $stmt->bind_param('i', $this->userid);
                    $stmt->execute();
                    $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO username_history(usuario_id, username, created_at, deleted_at) VALUES (?, ?, NOW(), null);");
                    $stmt->bind_param('is', $this->userid, $this->username);
                    $stmt->execute();
                }
                if ($this->coins != $this->user_information["monedas"]) {
                    $stmt = $GLOBALS["mysqli"]->prepare("UPDATE usuarios SET monedas = ? WHERE id=?;");
                    $stmt->bind_param('ii', $this->coins, $this->userid);
                    $stmt->execute();
                }
                if ($this->personaje_id != $this->user_information["personaje_id"]) {
                    $stmt = $GLOBALS["mysqli"]->prepare("UPDATE usuarios SET personaje_id = ? WHERE id=?;");
                    $stmt->bind_param('ii', $this->personaje_id, $this->userid);
                    $stmt->execute();
                }
                if ($this->roles != $this->user_information["systemRights"]) {
                    $stmt = $GLOBALS["mysqli"]->prepare("UPDATE roles SET perfil_id = ? WHERE usuario_id = ?;");
                    $stmt->bind_param('ii', $this->roles, $this->userid);
                    $stmt->execute();
                }
                $GLOBALS["mysqli"]->commit();
            } catch (mysqli_sql_exception $e) {
                $GLOBALS["mysqli"]->rollback();
                $GLOBALS["response"]->errstr = $e->getMessage();
                throw new systemException("global.query_failed.updateUser", 500, "global_error");
            } finally {
                if (isset($stmt) == true) {
                    $stmt->close();
                }
            }
            return true;
        }
    }
    $modifyUser_class_var = new modifyUser;
} else {
    throw new systemException("global.invalid_request_method", 405, "global_error");
}

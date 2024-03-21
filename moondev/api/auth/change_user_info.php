<?php

declare(strict_types=1);

namespace moondev\api\auth\change;

use autoLogin;
use stdClass;
use mysqli_sql_exception;
use moondev\api\auth\validator\checking;
use Exception;
use systemException;

$GLOBALS['response'] = new stdClass;

require_once('../system_handler.php');

if ($_SERVER['REQUEST_METHOD'] ===  'POST') {
    require_once('user_module.php');

    require_once("../mysqli_connector.php");
    class validateData
    {
        public function __construct($selector)
        {
            $this->validateDataSuccess = false;
            $this->selector = $selector;
            $this->getData();
            switch ($selector) {
                case "password":
                    $this->validateNoProfile();
                    checking::validatePassword($this->password2, "2", true, false, null);
                    checking::doTheyMatch($this->password2, $this->password3, 'password.not_the_same', "password3_error");
                    $this->password_hashed_new = checking::hashPassword($this->password2);
                    break;
                case "password_profile":
                    $this->autoLogin();
                    checking::validatePassword($this->password, "1", false, true, null);
                    checking::validatePassword($this->password2, "2", true, true, null);
                    checking::doTheyMatch($this->password2, $this->password3, 'password.not_the_same', "password3_error");
                    $this->password_hashed_new = checking::hashPassword($this->password2);
                    break;
                case "username_profile":
                    $this->autoLogin();
                    checking::validateUsername($this->username, "1", false, true, null);
                    checking::validateUsername($this->username2, "2", true, true, null);
                    checking::doTheyMatch($this->username2, $this->username3, 'username.not_the_same', "username3_error");
                    break;
                case "username":
                    $this->validateNoProfile();
                    checking::validateUsername($this->username, "1", false, false, null);
                    checking::validateUsername($this->username2, "2", true, true, null);
                    checking::doTheyMatch($this->username2, $this->username3, 'username.not_the_same', "username3_error");
                    break;
                case "email":
                    $this->validateNoProfile();
                    checking::validatePassword($this->password, "1", true, false, null);
                    checking::validateEmail($this->email2, "2", true, null);
                    checking::doTheyMatch($this->email2, $this->email3, 'email.not_the_same', "email3_error");
                case "email_profile":
                    $this->autoLogin();
                    checking::validateEmail($this->email, "1", false, null);
                    checking::validateEmail($this->email2, "2", true, null);
                    checking::doTheyMatch($this->email2, $this->email3, 'email.not_the_same', "email3_error");
                    break;
            }
            $this->validateDataSuccess = true;
        }
        private function validateNoProfile()
        {
            checking::validateEmail($this->email, "1", false, null);
            checking::validatePassword($this->password, "1", false, false, null);
        }
        private function autoLogin()
        {
            require_once("islogged.php");
            $GLOBALS["autoLogin"] = new autoLogin;
        }
        protected function is_profile()
        {
            if (preg_match("/profile/", $this->selector)) {
                return true;
            } else {
                return false;
            }
        }
        protected function userid(): bool
        {
            if ($this->is_profile()) {
                $this->userid = $_SESSION["userid"];
                return true;
            } else {
                $this->userid = checking::doesUserExists(false, false, true, $this->email, null, true);
                checking::AuthenticatePassword($this->password, checking::getPassword($this->userid), "email.login_failed", "email1_error");
                return false;
            }
        }
        protected function getData(): bool
        {
            switch ($this->selector) {
                case "password":
                    $this->email = checking::dataExists('email1', 'email.empty', 'email.non_string', 'email.slash', true, "email1_error");
                    $this->password = checking::dataExists('password1', 'password.empty', 'password.non_string', 'password.slash', false, "password1_error");
                    $this->password_hashed = checking::hashPassword($this->password);
                    $this->password2 = checking::dataExists('password2', 'password.empty', 'password.non_string', 'password.slash', false, "password2_error");
                    $this->password3 = checking::dataExists('password3', 'password.empty', 'password.non_string', 'password.slash', false, "password3_error");
                    break;
                case "password_profile":
                    $this->password = checking::dataExists('password1', 'password.empty', 'password.non_string', 'password.slash', false, "password1_error");
                    $this->password_hashed = checking::hashPassword($this->password);
                    $this->password2 = checking::dataExists('password2', 'password.empty', 'password.non_string', 'password.slash', false, "password2_error");
                    $this->password3 = checking::dataExists('password3', 'password.empty', 'password.non_string', 'password.slash', false, "password3_error");
                    break;
                case "username":
                    $this->email = checking::dataExists('email1', 'email.empty', 'email.non_string', 'email.slash', true, "email1_error");
                    $this->password = checking::dataExists('password1', 'password.empty', 'password.non_string', 'password.slash', false, "password1_error");
                    $this->password_hashed = checking::hashPassword($this->password);
                    $this->username = checking::dataExists('username1', 'username.empty', 'username.non_string', 'username.slash', true, "username1_error");
                    $this->username2 = checking::dataExists('username2', 'username.empty', 'username.non_string', 'username.slash', true, "username2_error");
                    $this->username3 = checking::dataExists('username3', 'username.empty', 'username.non_string', 'username.slash', true, "username3_error");
                    break;
                case "username_profile":
                    $this->username = checking::dataExists('username1', 'username.empty', 'username.non_string', 'username.slash', true, "username1_error");
                    $this->username2 = checking::dataExists('username2', 'username.empty', 'username.non_string', 'username.slash', true, "username2_error");
                    $this->username3 = checking::dataExists('username3', 'username.empty', 'username.non_string', 'username.slash', true, "username3_error");
                    break;
                case "email":
                    $this->email = checking::dataExists('email1', 'email.empty', 'email.non_string', 'email.slash', true, "email1_error");
                    $this->password = checking::dataExists('password1', 'password.empty', 'password.non_string', 'password.slash', false, "password1_error");
                    $this->password_hashed = checking::hashPassword($this->password);
                    $this->email2 = checking::dataExists('email2', 'email.empty', 'email.non_string', 'email.slash', true, "email2_error");
                    $this->email3 = checking::dataExists('email3', 'email.empty', 'email.non_string', 'email.slash', true, "email3_error");
                    break;
                case "email_profile":
                    $this->email = checking::dataExists('email1', 'email.empty', 'email.non_string', 'email.slash', true, "email1_error");
                    $this->email2 = checking::dataExists('email2', 'email.empty', 'email.non_string', 'email.slash', true, "email2_error");
                    $this->email3 = checking::dataExists('email3', 'email.empty', 'email.non_string', 'email.slash', true, "email3_error");
                    break;
            }
            return true;
        }
    }

    class changeUsername extends validateData
    {
        final public function __construct($profile)
        {
            parent::__construct(($profile == true) ? "username_profile" : "username");
            if ($this->validateDataSuccess === true) {
                createClass();
                $this->userid();
                $this->username_is_actual();
                try {
                    checking::doesUserExists(true, true, false, null, $this->username2, false);
                } catch (systemException $e) {
                    if ($e->getMessage() == "username.used") {
                        throw new systemException($e->getMessage(), $e->getCode(), "username2_error");
                    } else {
                        throw new systemException($e->getMessage(), $e->getCode(), $e->getInput());
                    }
                }
                $this->InsertNewUsername();
                query_success();
            }
        }
        private function username_is_actual(): bool
        {
            $query = "SELECT username FROM username_history uh INNER JOIN usuarios u ON uh.usuario_id = u.id AND uh.deleted_at IS NULL WHERE u.id = " . $this->userid . ";";
            $result = $GLOBALS["mClass"]->execute_sql($query, "global.query_failed.validateUsername", 500, "global_error");
            $GLOBALS["mClass"]->numRowIsNotZero('username.wrong', $result, 500, "username1_error");
            if ($result->fetch_assoc()["username"] != $this->username) {
                throw new systemException("username.wrong", 401, "username1_error");
            }
            return true;
        }
        private function insertNewUsername(): bool
        {
            $GLOBALS["mysqli"]->begin_transaction();
            try {
                $stmt = $GLOBALS["mysqli"]->prepare("UPDATE username_history SET deleted_at = NOW() WHERE username_history.username = (SELECT uh.username FROM username_history AS uh WHERE usuario_id = ? AND deleted_at IS NULL);");
                $stmt->bind_param('i', $this->userid);
                $stmt->execute();
                $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO username_history(usuario_id, username, created_at, deleted_at) VALUES (?, ?, NOW(), null);");
                $stmt->bind_param('is', $this->userid, $this->username2);
                $stmt->execute();
                $GLOBALS["mysqli"]->commit();
            } catch (mysqli_sql_exception $e) {
                $GLOBALS["mysqli"]->rollback();
                $GLOBALS["response"]->errstr = $e->getMessage();
                throw new systemException("global.query_failed.insertNewUsername", 500, "global_error");
            } finally {
                if (isset($stmt) == true) {
                    $stmt->close();
                }
            }
            return true;
        }
    }

    class changePassword extends validateData
    {
        final public function __construct($profile)
        {
            parent::__construct(($profile == true) ? "password_profile" : "password");
            if ($this->validateDataSuccess === true) {
                createClass();
                if ($this->userid() == true) {
                    checking::AuthenticatePassword($this->password, checking::getPassword($this->userid), "password.wrong", "password1_error");
                }
                $this->changePassword();
                query_success();
            }
        }
        private function changePassword(): bool
        {
            $this->query = "UPDATE usuarios SET clave = '" . $this->password_hashed_new . "', last_password_change = NOW() WHERE id=" . $this->userid . ";";
            $result = $GLOBALS["mysqli"]->query($this->query);
            $GLOBALS["mClass"]->storeMySQLiResult_exception($result, 'global.query_failed.changePassword', 500);
            return true;
        }
    }

    class changeEmail extends validateData
    {
        final public function __construct($profile)
        {
            parent::__construct(($profile == true) ? "email_profile" : "email");
            if ($this->validateDataSuccess === true) {
                createClass();
                if ($this->userid() == true) {
                    try {
                        checking::doesUserExists(false, false, true, $this->email, null, false);
                    } catch (systemException $e) {
                        if ($e->getMessage() == "email.login_failed") {
                            throw new systemException("email.wrong", $e->getCode(), $e->getInput());
                        } else {
                            throw new systemException($e->getMessage(), $e->getCode(), $e->getInput());
                        }
                    }
                }
                try {
                    checking::doesUserExists(true, false, true, $this->email2, null, false);
                } catch (systemException $e) {
                    if ($e->getInput() == "email1_error") {
                        throw new systemException($e->getMessage(), $e->getCode(), "email2_error");
                    } else {
                        throw new systemException($e->getMessage(), $e->getCode(), $e->getInput());
                    }
                }
                $this->email_is_actual();
                $this->insertNewEmail();
                query_success();
            }
        }
        private function email_is_actual(): bool
        {
            $query = "SELECT mail FROM email_history eh INNER JOIN usuarios u ON eh.usuario_id = u.id AND eh.deleted_at IS NULL WHERE u.id = " . $this->userid . ";";
            $result = $GLOBALS["mClass"]->execute_sql($query, "global.query_failed.validateEmail", 500, "global_error");
            $GLOBALS["mClass"]->numRowIsNotZero('email.wrong', $result, 500, "email1_error");
            if ($result->fetch_assoc()["mail"] != $this->email) {
                throw new systemException("email.wrong", 401, "email1_error");
            }
            return true;
        }
        private function insertNewEmail(): bool
        {
            $GLOBALS["mysqli"]->begin_transaction();
            try {
                $stmt = $GLOBALS["mysqli"]->prepare("UPDATE email_history SET deleted_at = NOW() WHERE email_history.usuario_id=? AND email_history.deleted_at IS NULL;");
                $stmt->bind_param('i', $this->userid);
                $stmt->execute();
                $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO email_history(usuario_id, mail, created_at, deleted_at) VALUES (?, ?, NOW(), null);");
                $stmt->bind_param('is', $this->userid, $this->email2);
                $stmt->execute();
                $GLOBALS["mysqli"]->commit();
            } catch (mysqli_sql_exception $e) {
                $GLOBALS["mysqli"]->rollback();
                $GLOBALS["response"]->errstr = $e->getMessage();
                throw new systemException("global.query_failed.insertNewEmail", 500, "global_error");
            } finally {
                if (isset($stmt) == true) {
                    $stmt->close();
                }
            }
            return true;
        }
    }

    if (isset($_REQUEST["auth_method"]) !== true) {
        throw new systemException("global.unknow_auth_method", 400, "global_error");
    }

    switch ($_POST['auth_method']) {
        case "username":
            $GLOBALS['response']->auth_method = "username";
            $authentification_class_var = new changeUsername(false);
            break;
        case "username_profile":
            $GLOBALS['response']->auth_method = "username_profile";
            $authentification_class_var = new changeUsername(true);
        case "password_profile":
            $GLOBALS['response']->auth_method = "password_profile";
            $authentification_class_var = new changePassword(true);
            break;
        case "password":
            $GLOBALS['response']->auth_method = "password";
            $authentification_class_var = new changePassword(false);
            break;
        case "email":
            $GLOBALS['response']->auth_method = "email";
            $authentification_class_var = new changeEmail(false);
            break;
        case "email_profile":
            $GLOBALS['response']->auth_method = "email_profile";
            $authentification_class_var = new changeEmail(true);
        default:
            throw new systemException('global.invalid_auth_method', 400, "global_error");
            break;
    }
} else {
    throw new systemException("global.invalid_request_method", 405, "global_error");
}

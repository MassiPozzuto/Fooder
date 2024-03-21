<?php

declare(strict_types=1);

namespace moondev\api\auth\Authenticator;

use moondev\api\auth\validator\checking;
use stdClass;
use mysqli_sql_exception;
use autoLogin;
use systemException;
use Exception;

$GLOBALS['response'] = new stdClass;

require_once('../system_handler.php');

if ($_SERVER['REQUEST_METHOD'] ===  'POST') {

    require_once('user_module.php');

    require_once("../mysqli_connector.php");

    abstract class validateData
    {
        public $isRegister;
        public $validateDataSuccess;
        public $useemail;
        protected $email;
        protected $password;
        protected $password_hashed;
        protected $password2;
        protected $username;
        protected $query;
        protected $userid;
        protected $user_information;
        protected function __construct($isRegister, $useEmail)
        {
            $this->validateDataSuccess = false;
            $this->isRegister = $isRegister;
            $this->useemail = $useEmail;
            $this->getData($this->isRegister);

            checking::validateEmail($this->email, "1", (($this->isRegister == true) ? true : false), null);
            checking::validatePassword($this->password, "1", (($this->isRegister == true) ? true : false), false, null);
            if ($this->isRegister === true) {
                checking::doTheyMatch($this->password, $this->password2, 'password.not_the_same', "password2_error");
                checking::validateUsername($this->username, "1", true, false, null);
                $this->password_hashed = checking::hashPassword($this->password);
            }
            $this->validateDataSuccess = true;
        }
        protected function getData()
        {
            $this->email = checking::dataExists('email1', 'email.empty', 'email.non_string', 'email.slash', true, "email1_error");
            $this->password = checking::dataExists('password1', 'password.empty', 'password.non_string', 'password.slash', false, "password1_error");
            if ($this->isRegister === true) {
                $this->username = checking::dataExists('username1', 'username.empty', 'username.non_string', 'username.slash', true, "username1_error");
                //$this->birthdate = \Auth\Validator\checking::dataExists('birthdate', 'birthdate.empty', 'birthdate.non_string', 'birthdate.slash', true);
                $this->password2 = checking::dataExists('password2', 'password.empty', 'password.non_string', 'password.slash', false, "password2_error");
            }
        }
        protected function selectAll($useemail)
        {
            $this->query = GET_USER_QUERY;
            $this->query .= (" WHERE ");
            if ($useemail === true) {
                $this->query .= ("eh.mail = '" . $this->email . "'");
            } else {
                $this->query .= ("ui.username = '" . $this->username . "'");
            }
            $this->query .= ";";
            $result = $GLOBALS["mClass"]->execute_sql($this->query, "global.query_failed.selectAll", 500, "global_error");
            $GLOBALS["mClass"]->numRowIsNotZero('global.selectAll.unknow_selectAll', $result, 500, "global_error");
            $row = $result->fetch_assoc();
            $this->userid = $row['id'];
            if (isset($this->password_hashed) !== true) {
                $this->password_hashed = $row['clave'];
            }
            return $row;
        }
    }

    trait createCookie
    {
        private function cookieConstructor()
        {
            //Este constructor requiere si o si un UserID para funcionar.
            if (isset($this->userid) !== true) {
                throw new systemException("global.cookie.unknow_userid", 500, "global_error");
            }
            $this->createCookie();
        }
        private function createCookie()
        {
            $expirationDays = 30;
            $this->expirationDate = time() + ($expirationDays * 24 * 60 * 60);
            setcookie(
                "moondev_auth",
                $this->userid,
                $this->expirationDate,
                "/",
                "localhost",
                false,
                true
            );
            return true;
        }
    }

    class register extends validateData
    {
        protected $result;
        use createCookie;
        final public function __construct($saveCookie)
        {
            $this->saveCookie = filter_var($saveCookie, FILTER_VALIDATE_BOOLEAN);
            parent::__construct(true, true);
            if ($this->validateDataSuccess === true) {
                createClass();
                checking::doesUserExists($this->isRegister, true, true, $this->email, $this->username, false);
                $this->createUser();
                $this->user_information = $this->selectAll(true);
                if ($this->saveCookie === true) { $this->cookieConstructor(); }
                require_once("islogged.php");
                autoLogin::createSessionID($this->user_information);
                query_success();
            }
        }
        private function createUser()
        {
            $GLOBALS["mysqli"]->begin_transaction();
            try {
                $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO usuarios(clave, personaje_id, monedas, created_at, deleted_at) VALUES (?, 1, 100, NOW(), null);");
                $stmt->bind_param('s', $this->password_hashed);
                $stmt->execute();
                $inserted_id = intval($stmt->insert_id);
                $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO username_history(usuario_id, username, created_at, deleted_at) VALUES (?, ?, NOW(), null);");
                $stmt->bind_param('is', $inserted_id, $this->username);
                $stmt->execute();
                $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO email_history(usuario_id, mail, created_at, deleted_at) VALUES (?, ?, NOW(), null);");
                $stmt->bind_param('is', $inserted_id, $this->email);
                $stmt->execute();
                $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO roles(usuario_id, perfil_id) VALUES(?, ?);");
                $default_profile_id = DEFAULT_PROFILE_ID;
                $stmt->bind_param('ii', $inserted_id, $default_profile_id);
                $stmt->execute();
                $GLOBALS["mysqli"]->commit();
            } catch (mysqli_sql_exception $e) {
                $GLOBALS["mysqli"]->rollback();
                $GLOBALS["response"]->errstr = $e->getMessage();
                throw new systemException("global.query_failed.register", 500, "global_error");
            } finally {
                if (isset($stmt) == true) {
                    $stmt->close();
                }
            }
            return true;
        }
    }
    class login extends validateData
    {
        use createCookie;
        final public function __construct($saveCookie)
        {
            $this->saveCookie = filter_var($saveCookie, FILTER_VALIDATE_BOOLEAN);
            parent::__construct(false, true);
            if ($this->validateDataSuccess === true) {
                createClass();
                checking::doesUserExists($this->isRegister, false, true, $this->email, null, false);
                $this->user_information = $this->selectAll(true);
                checking::AuthenticatePassword($this->password, $this->password_hashed, false, "email.login_failed", "email1_error");
                if ($this->saveCookie === true) { $this->cookieConstructor(); }
                require_once("islogged.php");
                autoLogin::createSessionID($this->user_information);
                query_success();
            }
        }
    }

    if (isset($_REQUEST["auth_method"]) !== true) {
        throw new systemException("global.unknow_auth_method", 400, "global_error");
    } else if (isset($_REQUEST["saveCookie"]) !== true) {
        throw new systemException("global.cookie.unset", 400, "global_error");
    }
    $GLOBALS["response"]->saveCookie = $_REQUEST["saveCookie"];

    switch ($_REQUEST['auth_method']) {
        case "true":
            $GLOBALS['response']->auth_method = "register";
            $authentification_class_var = new register($_REQUEST["saveCookie"]);
            break;
        case "false":
            $GLOBALS['response']->auth_method = "login";
            $authentification_class_var = new login($_REQUEST["saveCookie"]);
            break;
        default:
            throw new systemException('global.invalid_auth_method', 400, "global_error");
            break;
    }
} else {
    throw new systemException("global.invalid_request_method", 405, "global_error");
}

<?php
//ARCHIVO DE PRUEBA PARA INSERTAR X NUMEROS DE USUARIOS A LA BASE DE DATOS
//Se utilizara para probar el paginador, no utilizar en produccion.
//Ya que el archivo es de prueba, no esta codificado para detectar errores

//Aviso: Este programa puede demorar un rato largo dependiendo de la computadora
//y la cantidad maxima de registros establecida, cuanto mas grande, mas lento.
define("DEFINED_MAX", 300);
require_once("../api/mysqli_connector.php");
createClass();

$GLOBALS["mysqli"]->begin_transaction();
try {
    for ($i = 0; $i <= DEFINED_MAX; $i++) {
        $password_hashed = password_hash(str_shuffle("dahpoqwudsvsckeeagidajisjissdsd"), PASSWORD_DEFAULT);
        $email = strval(str_shuffle("HDajhajhsdaDSASsad") . "@gmail.com");
        $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO usuarios(mail, clave, personaje_id, monedas, created_at, deleted_at) VALUES (?, ?, 100, 100, NOW(), null);");
        $stmt->bind_param('ss', $email, $password_hashed);
        $stmt->execute();
        $inserted_id = intval($stmt->insert_id);
        $username = str_shuffle("HDajhajhsdaDSASsad");
        $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO username_history(usuario_id, username, created_at, deleted_at) VALUES (?, ?, NOW(), null);");
        $stmt->bind_param('is', $inserted_id, $username);
        $stmt->execute();
        /*$stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO email_history(usuario_id, mail, created_at, deleted_at) VALUES (?, ?, NOW(), null);");
        $stmt->bind_param('is', $inserted_id, $email);
        $stmt->execute();*/
        $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO roles(usuario_id, perfil_id) VALUES(?, ?);");
        $default_profile_id = 0;
        $stmt->bind_param('ii', $inserted_id, $default_profile_id);
        $stmt->execute();
    }
} catch (mysqli_sql_exception $e) {
    $GLOBALS["mysqli"]->rollback();
    $GLOBALS["response"]->errstr = $e->getMessage();
    throw new Exception("global.query_failed.register", 500);
} finally {
    if (isset($stmt) == true) {
        $stmt->close();
    }
}

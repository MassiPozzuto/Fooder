<?php
$GLOBALS["response"] = new stdClass;
require_once("../api/system_handler.php");
require_once("../api/mysqli_connector.php");
createClass();
$query = "SELECT id, mail, created_at FROM usuarios;";
$result = $GLOBALS["mClass"]->execute_sql($query, "FALLO AL OBTENER EMAILS", 500, null);
$array_resultados = $result->fetch_all(MYSQLI_ASSOC);

$GLOBALS["mysqli"]->begin_transaction();
try {
    foreach ($array_resultados as $iterator) {
        /*echo("<pre>");
        print_r($iterator);
        echo("</pre>");*/
        $mail = $iterator["mail"];
        $id = intval($iterator["id"]);
        $created_at = $iterator["created_at"];
        $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO email_history(usuario_id, mail, created_at, deleted_at) VALUES (?, ?, ?, null);");
        $stmt->bind_param('iss', $id, $mail, $created_at);
        $stmt->execute();
    }
    $GLOBALS["mysqli"]->commit();
} catch (mysqli_sql_exception $e) {
    $GLOBALS["mysqli"]->rollback();
    $GLOBALS["response"]->errstr = $e->getMessage();
    throw new systemException("FALLO AL MIGRAR EMAILS", 500, null);
} finally {
    if (isset($stmt) == true) {
        $stmt->close();
    }
}

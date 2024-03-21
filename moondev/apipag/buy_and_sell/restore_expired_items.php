<?php
//Esta funcion restaurara a los inventarios los objetos del mercado online expirados
//Es decir, los que han pasado 7 DIAS desde su publicacion y nadie los ha comprado.
function restoreItems(): bool
{
    //Selecciono tods los objetos expirados
    $main_query = "SELECT * FROM objetos_venta WHERE (expiration_date + INTERVAL 7 DAY) < NOW();";
    $result_restore = $GLOBALS["mysqli"]->query($main_query);
    $result_fetched = $result_restore->fetch_all(MYSQLI_ASSOC);
    $GLOBALS["mysqli"]->begin_transaction();
    try {
        //Devuelvo a los inventarios correspondientes sus objetos
        foreach ($result_fetched as $fetched) {
            $stmt = $GLOBALS["mysqli"]->prepare("INSERT INTO inventarios (objeto_id, usuario_id, cantidad, created) VALUES (?, ?, 1, NOW());");
            $stmt->bind_param('ii', $fetched["objeto_id"], $fetched["usuario_id"]);
            $stmt->execute();
        }
        //Los borro del mercado
        $GLOBALS["mysqli"]->real_query("DELETE FROM objetos_venta WHERE expiration_date < NOW();");
        $GLOBALS["mysqli"]->real_query("DELETE FROM purchase_history WHERE deleted_at < NOW();");
        //Eejecuto la transaccion
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
    return true;
}

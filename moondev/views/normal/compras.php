<link rel="stylesheet" type="text/css" href="<?php echo $fileinfo; ?>online.css">
<script type="module" src="<?php echo $fileinfo; ?>compras.js"></script>
<div class="containercompras">
    <head>
        <title>Historial de compras</title>
    </head>
    <header class="navbar-shop">
        <?php require_once("includes/nav.php"); ?>
    </header>
    <div id="swipe_title" class="title-sectionn">Historial de compras</div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="textocompra">
        <p>Aca puedes ver tu historial de compras y de ventas. Debes tener en cuenta lo siguiente:</p> <br>
        <ol>
            <li>Las transacciones son finales</li> <br>
            <li>Este historial solo muestra transacciones concluidas exitosamente</li> <br>
            <li>Los registros de este historial desapareceran una vez se alcance la fecha de expiracion de dicho registro (7 dias)</li>
        </ol>
        <div id="comprastable">
            <button id="swipe_button"></button>
            <table border="1" class="mt10" style="width:60%; height:40%;">
                <thead>
                    <tr>
                        <th>Fecha de compra</th>
                        <th>Nombre Objeto</th>
                        <th>Precio</th>
                        <th id="buy_or_seller">Vendedor</th>
                        <th>Fecha de expiracion</th>
                    </tr>
                </thead>
                <tbody id="purchase_history_table">
                <tbody>
            </table>
        </div>
    </div>
</div>
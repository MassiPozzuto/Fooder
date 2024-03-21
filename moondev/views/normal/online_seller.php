<link rel="stylesheet" type="text/css" href="controllers/normal/online/online.css">
<script type="module" src="controllers/normal/online/online.js"></script>
<script src="includes/close-modal.js"></script>
<script src="controllers/normal/autocompletar.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<head>
    <title>Surmoon - Tus objetos a la venta</title>
</head>
<header class="navbar-shop">
    <?php require_once("includes/nav.php");?>
    </div>
</header>
<div class="content-page">
<div class="title-section">Tus objetos a la venta</div>
<div class="title-sectionn" id="response_search">
</div>
    <div class="container-itemsml" id="container-items">
        <div class="items-ls"></div>
    </div>
    <div class="modal" id="modal-object-buy" style="display: none;">
        <div class="body-modal">
            <button class="btn-close" onclick="hide_modal('modal-object-buy')"><i class="fa fa-times botonopc" aria-hidden="true"></i></button>
            <h3>Comprar Objeto</h3>
            <input type="text" id="codigo" style="display: none;">
            <div class="div-flex">
                <div id="imgbuy2" style=" width: 500px; border: 1px solid black;"><img id="imgbuy" src="" style=" width: 200px; margin: 5px 150px auto; "></div>
            </div>
            <div class="div-flex">
                <label>Objeto:</label>
                <textarea type="text" id="nombreobj" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Historia:</label>
                <textarea type="text" id="descripcion" disabled readonly></textarea>
            </div>
            <div class="div-flex" style="display: none;">
                <label>Nombre del vendedor:</label>
                <textarea type="text" id="seller" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Precio:</label>
                <textarea type="text" id="precio" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Publicado el:</label>
                <textarea type="text" id="sell_created_at" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Expira el:</label>
                <textarea type="text" id="sell_deleted_at" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Rareza:</label>
                <textarea type="text" id="rareza" disabled readonly></textarea>
            </div>
            <button class="btn-save" onclick="javascript:cancel_sell();">Quitar del mercado</button>
        </div>
    </div>
</div>
<script>
    function hide_modal(id) {
        document.getElementById(id).style.display = "none";
    }
    function show_modal(id) {
        document.getElementById(id).style.display = "block";
    }
</script>
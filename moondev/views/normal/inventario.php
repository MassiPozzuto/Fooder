<script>
    window.hide_modal = function hide_modal(id) {
        document.getElementById(id).style.display = "none";
    }

    window.show_modal = function show_modal(id) {
        document.getElementById(id).style.display = "block";
    }
    document.addEventListener(
        "click",
        function(event) {
            if (
                event.target.matches(".modal-object") ||
                !event.target.closest(".body-modal")
            ) {
                closeModal()
            }
        },
        false
    )

    window.closeModal = function closeModal() {
        document.querySelectorAll(".modal").forEach(element => {
            element.style.display = "none";
        });
    }
</script>

<script src="<?php echo $fileinfo; ?>invequip.js"></script>
<script type="module" src="<?php echo $fileinfo; ?>inventario.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $fileinfo; ?>online.css">

<head>
    <title>Surmoon - Perfil</title>
</head>
<header class="navbar-shop">
    <?php require_once("includes/nav.php"); ?>
</header>
<div class="all">
    <div class="title-sectionn">Perfil</div>
    <div class="avatar"><img class="humanratio" id="humanofinal" src="img/h3.png"></img></div>
    <div class="itemsequiplist">
        <div class="itemeq" id="cabezaeqdiv"><a onclick="javascript:window.mostrarobjeq(idcabeza)"><img class="imgequip" id="cabezaeq" src="img/Slot Casco 2.png"></img></a></div>
        <div class="itemeq" id="torsoeqdiv"><a onclick="javascript:window.mostrarobjeq(idtorso)"><img class="imgequip" id="torsoeq" src="img/Slot Pechera 2.png"></img></a></div>
        <div class="itemeq" id="piernaseqdiv"><a onclick="javascript:window.mostrarobjeq(idpiernas)"><img class="imgequip" id="piernaseq" src="img/Slot Pantalones 2.png"></img></a></div>
        <div class="itemeq" id="botaseqdiv"><a onclick="javascript:window.mostrarobjeq(idbotas)"><img class="imgequip" id="botaseq" src="img/Slot Botas 2.png"></img></a></div>
        <div class="itemeq" id="armaeqdiv"><a onclick="javascript:window.mostrarobjeq(idarma)"><img class="imgequip" id="armaeq" src="img/Slot Arma.png"></img></a></div>
        <div class="itemeq" id="mascotaeqdiv"><a onclick="javascript:window.mostrarobjeq(idmascota)"><img class="imgequip" id="mascotaeq" src="img/Slot Mascota.png"></img></a></div>
    </div>

    <div class="itemsinv">
        <table class="invtable">
            <thead class="headinv">
                <tr class="rowhead">
                    <td class="columnhead">Inventario</td>
                </tr>
            </thead>
            <tbody class="bodyinv" id="bodyinv">
            </tbody>
        </table>
    </div>
    <input type="text" id="codigo" style="display: none;">

    <!-- MODAL DE VENTA-->
    <div class="modal modal-object" id="modal-object-venta" style="display: none;">
        <div class="body-modal">
            <button class="btn-close" onclick="javascript:hide_modal('modal-object-venta')"><i class="fa fa-times botonopc" aria-hidden="true"></i></button>
            <h3>Venta del objeto</h3>
            <div class="div-flex">
                <div style=" width: 500px; border: 1px solid black;"><img class="object_img" id="imgbuy_venta" src="" style=" width: 200px; margin: 5px 150px auto; "></div>
            </div>
            <div class="div-flex">
                <label>Objeto:</label>
                <textarea type="text" id="nombreobj_venta" class="objeto_name" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Precio de venta:</label>
                <input type="number" id="precio_venta" placeholder="Ingresa el precio de venta"></textarea>
            </div>
            <button class="btn-save" onclick="javascript:window.vender()">Vender</button>
        </div>
    </div>

    <!-- MODAL DE OBJETOS-->
    <div class="modal modal-object" id="modal-object-inv" style="display: none;">
        <div class="body-modal">
            <button class="btn-close" onclick="javascript:hide_modal('modal-object-inv')"><i class="fa fa-times botonopc" aria-hidden="true"></i></button>
            <h3>Informacion del objeto</h3>
            <div class="div-flex">
                <div style=" width: 500px; border: 1px solid black;"><img class="object_img" id="imgbuy" src="" style=" width: 200px; margin: 5px 150px auto; "></div>
            </div>
            <div class="div-flex">
                <label>Objeto:</label>
                <textarea type="text" id="nombreobj" class="objeto_name" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Historia:</label>
                <textarea type="text" id="descripcion" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Precio:</label>
                <textarea type="text" id="precio" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Rareza:</label>
                <textarea type="text" id="rareza" disabled readonly></textarea>
            </div>
            <div class="div-flex">
                <label>Parte:</label>
                <textarea type="text" id="parte" disabled readonly></textarea>
            </div>
            <button class="btn-equipsell" onclick="javascript:equipar();">Equipar</button>
            <button class="btn-equipsell" onclick="javascript:window.open_venta();">Vender</button>
        </div>
    </div>
</div>
<!-- MODAL DE EQUIPADO-->
<div class="modal modal-object" id="modal-object-eq" style="display: none;">
    <div class="body-modal body-modal-eq">
        <button class="btn-close" onclick="hide_modal('modal-object-eq')"><i class="fa fa-times botonopc" aria-hidden="true"></i></button>
        <h3>Objeto Equipado</h3>
        <div class="div-flex">
            <div style=" width: 100%; border: 1px solid black; display:flex; justify-content: center;"><img class="object_img" id="imgbuy-e" src="" style=" width: 200px;"></div>
        </div>
        <div class="div-flex">
            <label>Objeto:</label>
            <textarea type="text" id="nombreobj-e" class="objeto_name" disabled readonly></textarea>
        </div>
        <div class="div-flex">
            <label>Historia:</label>
            <textarea type="text" id="descripcion-e" disabled readonly></textarea>
        </div>
        <div class="div-flex">
            <label>Precio:</label>
            <textarea type="text" id="precio-e" disabled readonly></textarea>
        </div>
        <div class="div-flex">
            <label>Rareza:</label>
            <textarea type="text" id="rareza-e" disabled readonly></textarea>
        </div>
        <div class="div-flex">
            <label>Parte:</label>
            <textarea type="text" id="parte-e" disabled readonly></textarea>
        </div>
        <button class="btn-equipsell" onclick="javascript:desequipar()">Desequipar</button>
        <button class="btn-equipsell" onclick="javascript:open_venta_eqip()">Vender</button>
    </div>

</div>
</div>
</div>
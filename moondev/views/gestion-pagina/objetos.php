<script type="module" src="<?php echo $fileinfo; ?>objetos.js"></script>

<body class="adminm">
    <div class="modal" id="modal-object" style="display: none;">
        <div class="body-modal">
            <button class="btn-close" onclick="hide_modal('modal-object')"><i class="fa fa-times botonopc" aria-hidden="true"></i></button>
            <h3>Añadir Objeto</h3>
            <input type="text" id="codigo" style="display: none;">
            <div class="div-flex">
                <label>Nombre</label>
                <input type="text" id="nombre">
            </div>
            <div class="div-flex">
                <label>Descripcion</label>
                <input type="text" id="descripcion">
            </div>
            <div class="div-flex">
                <label>Precio</label>
                <input type="number" id="precio">
            </div>
            <div class="div-flex">
                <label>Rareza</label>
                <select id="rareza">
                    <option value="1">Común</option>
                    <option value="2">Raro</option>
                    <option value="3">Epico</option>
                    <option value="4">Mitico</option>
                    <option value="5">Gucci</option>
                    <option value="6">Ancestral</option>
                </select>
            </div>
            <div class="div-flex">
                <label>Parte</label>
                <select id="parte">
                    <option value="cabeza">Cabeza</option>
                    <option value="torso">Torso</option>
                    <option value="piernas">Piernas</option>
                    <option value="botas">Botas</option>
                    <option value="arma">Arma</option>
                    <option value="mascota">Mascota</option>
                </select>
            </div>
            <div class="div-flex">
                <label>Imagen</label>
                <input type="file" id="imagen">
            </div>
            <div class="div-flex">
                <label>En venta</label>
                <select id="enventa">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button class="btn-save" onclick="save_object()">Guardar</button>
        </div>
    </div>
    <div class="modal" id="modal-object-edit" style="display: none;">
        <div class="body-modal">
            <button class="btn-close" onclick="hide_modal('modal-object-edit')"><i class="fa fa-times botonopc" aria-hidden="true"></i></button>
            <h3>Editar Objeto</h3>
            <div class="div-flex">
            <label>Código</label>
            <input type="text" id="codigo-e" disabled class="ingresadores">
            </div>
            <div class="div-flex">
                <label>Precio</label>
                <input type="number" id="precio-e" class="ingresadores">
            </div>
            <div class="div-flex">
                <label>Nombre</label>
                <input type="text" id="nombre-e" class="ingresadores">
            </div>
            <div class="div-flex">
                <label>Descripción</label>
                <input type="text" id="descripcion-e" class="ingresadores">
            </div>
            <div class="div-flex">
                <label>Rareza</label>
                <select id="rareza-e">
                    <option value="1">Común</option>
                    <option value="2">Raro</option>
                    <option value="3">Epico</option>
                    <option value="4">Mitico</option>
                    <option value="5">Gucci</option>
                    <option value="6">Ancestral</option>
                </select>
            </div>
            <div class="div-flex">
                <label>Parte</label>
                <select id="parte-e">
                    <option value="cabeza">Cabeza</option>
                    <option value="torso">Torso</option>
                    <option value="piernas">Piernas</option>
                    <option value="botas">Botas</option>
                    <option value="arma">Arma</option>
                    <option value="mascota">Mascota</option>
                </select>
            </div>
            <div class="div-flex">
                <label style="padding-top: 100px;" class="label-img">Imagen</label>
                <div style="border: 1px solid; width:100%;" ><img id="rutimgobj" src="" style=><input type="file" id="imagen-e"></div>
            </div>
            <input type="text" id="rutimgobj-aux" style="display: none;">
            <div class="div-flex divenventa">
                <label style="margin-top: 6px;">En venta</label>
                <select id="enventa-e">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
            </div>

            <button class="btn-save" onclick="update_object()">Actualizar</button>
        </div>
    </div>
        <div class="bodypageadm">
            <h1>Objetos</h1>
            <div id="global_error"></div>
            <h2 id="paginator_section"></h2>
            <table class="mt10" id="get_table_all">
            </table>
            <div id="paginator_list"></div>
            <button class="botonag" onclick="show_modal('modal-object')">Agregar Objeto</button>
        </div>
    </div>
</body>
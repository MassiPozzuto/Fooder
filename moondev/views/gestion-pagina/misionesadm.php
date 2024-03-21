<script src="<?php echo $fileinfo; ?>misionesadm.js"></script>

<body class="adminm">
    <div class="modal" id="modal-object" style="display: none;">
        <div class="body-modal">
            <button class="btn-close" onclick="hide_modal('modal-object')"><i class="fa fa-times" aria-hidden="true"></i></button>
            <h3>Crear Mision</h3>
            <input type="text" id="id_mis" style="display: none;">
            <div class="div-flex">
                <label>Imagen</label>
                <input type="file" id="mis_rutaimg">
            </div>
            <div class="div-flex">
                <label>Titulo</label>
                <input type="text" id="titulo_mis">
            </div>
            <div class="div-flex">
                <label>Descripcion</label>
                <input type="text" id="descripcion_mis">
            </div>
            <div class="div-flex">
                <label>Oro</label>
                <input type="number" id="oro_mis">
            </div>
            <div class="div-flex">
                <label>Winrate</label>
                <select id="winrate_mis">
                    <option value="10">10%</option>
                    <option value="20">20%</option>
                    <option value="30">30%</option>
                    <option value="40">40%</option>
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90">90%</option>
                    <option value="100">100%</option>
                </select>
            </div>
            <div class="div-flex">
                <label>Droprate</label>
                <select id="droprate_mis">
                    <option value="10">10%</option>
                    <option value="20">20%</option>
                    <option value="30">30%</option>
                    <option value="40">40%</option>
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90">90%</option>
                    <option value="100">100%</option>
                </select>
            </div>
            <div class="div-flex">
                <label>Tiempo</label>
                <select id="tiempo_mis">
                    <option value="900">15"</option>
                    <option value="1800">30"</option>
                    <option value="2700">45"</option>
                    <option value="3600">1 Hora</option>
                    <option value="4500">1 Hora 15"</option>
                    <option value="5400">1 Hora 30"</option>
                    <option value="6300">1 Hora 45"</option>
                    <option value="7200">2 Horas</option>
                    <option value="8100">2 Horas 15"</option>
                    <option value="9000">2 Horas 30"</option>
                    <option value="9900">2 Horas 45"</option>
                    <option value="10800">3 Horas</option>
                    <option value="11700">3 Horas 15"</option>
                    <option value="12600">3 Horas 30"</option>
                    <option value="13500">3 Horas 45"</option>
                    <option value="14400">4 Horas</option>
                </select>
            </div>
            <button class="btn-save" onclick="save_mis()">Crear Misión</button>
        </div>
    </div>
    <div class="modal" id="modal-object-edit" style="display: none;">
        <div class="body-modal">
            <button class="btn-close" onclick="hide_modal('modal-object-edit')"><i class="fa fa-times" aria-hidden="true"></i></button>
            <h3>Editar Mision</h3>
            <div class="div-flex">
            <label>Id</label>
            <input type="text" id="id_mis-e" disabled class="ingresadores">
            </div>
            <div class="div-flex">
                <label style="padding-top: 100px;" class="label-img">Imagen</label>
                <div style="border: 1px solid; width:100%;" ><img id="rutimgmis" src=""><input type="file" id="mis_rutaimg-e"></div>
            </div>    
            <div class="div-flex">
                <label>Titulo</label>
                <input type="text" id="titulo_mis-e" class="ingresadores">
            </div>
            <div class="div-flex">
                <label>Descripcion</label>
                <input type="text" id="descripcion_mis-e" class="ingresadores">
            </div>
            <div class="div-flex">
                <label>Tiempo</label>
                <select id="tiempo_mis-e">
                    <option value="900">15"</option>
                    <option value="1800">30"</option>
                    <option value="2700">45"</option>
                    <option value="3600">1 Hora</option>
                    <option value="4500">1 Hora 15"</option>
                    <option value="5400">1 Hora 30"</option>
                    <option value="6300">1 Hora 45"</option>
                    <option value="7200">2 Horas</option>
                    <option value="8100">2 Horas 15"</option>
                    <option value="9000">2 Horas 30"</option>
                    <option value="9900">2 Horas 45"</option>
                    <option value="10800">3 Horas</option>
                    <option value="11700">3 Horas 15"</option>
                    <option value="12600">3 Horas 30"</option>
                    <option value="13500">3 Horas 45"</option>
                    <option value="14400">4 Horas</option>
                </select>
            </div>
            
            <div class="div-flex">
                <label>Oro</label>
                <input type="number" id="oro_mis-e" class="ingresadores">
            </div>
            <div class="div-flex">
                <label>Winrate</label>
                <select id="winrate_mis-e">
                    <option value="10">10%</option>
                    <option value="20">20%</option>
                    <option value="30">30%</option>
                    <option value="40">40%</option>
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90">90%</option>
                    <option value="100">100%</option>
                </select>
            </div>
            <div class="div-flex">
                <label>Droprate</label>
                <select id="droprate_mis-e">
                    <option value="10">10%</option>
                    <option value="20">20%</option>
                    <option value="30">30%</option>
                    <option value="40">40%</option>
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90">90%</option>
                    <option value="100">100%</option>
                </select>
            </div>
            <input type="text" id="rutimgmis-aux" style="display: none;">
            <button class="btn-save" onclick="update_mis()">Actualizar</button>
        </div>
    </div>
        <div class="bodypageadm">
            <h1>Misiones</h1>
            <div id="global_error"></div>
            <h2 id="paginator_section"></h2>
            <table class="mt10" id="get_table_all">
            </table>
            <div id="paginator_list"></div>
            <button class="botonag" onclick="show_modal('modal-object')">Crear Mision</button>
        </div>
    </div>
</body>
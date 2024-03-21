<script type="module" src="<?php echo $fileinfo; ?>usuariosadm.js"></script>
<script id="auth_settings" type="application/json">
    <?php require_once("api/get_settings.php");
    getSettings("auth"); ?>
</script>

<body class="adminm">
    <div class="modal" id="modal-object-edit" style="display: none;">
        <div class="body-modal">
            <button class="btn-close" onclick="javascript:hide_modal('modal-object-edit'); javascript:empty_errors();"><i class="fa fa-times" aria-hidden="true"></i></button>
            <!--<div id="testing_input_error"></div>-->
            <h3>Editar Usuario</h3>
            <div class="div-flex">
                <label>ID</label>
                <input type="text" id="id_usu-e" disabled readonly class="ingresadores">
            </div>
            <div id="userid_error" class="display_error_class"></div>
            <div class="div-flex">
                <label>Email</label>
                <input type="text" id="mail_usu-e" class="ingresadores">
            </div>
            <div id="email1_error" class="display_error_class"></div>
            <div class="div-flex">
                <label>Usuario</label>
                <input type="text" id="usuario_usu-e" class="ingresadores">
            </div>
            <div id="username1_error" class="display_error_class"></div>
            <div class="div-flex">
                <label>Clave</label>
                <input type="text" id="clave_usu-e" class="ingresadores" disabled readonly>
            </div>
            <div id="password1_error" class="display_error_class"></div>
            <div class="div-flex">
                <label>Color de piel</label>
                <select id="personaje_id-e" class="ingresadores">
                    <option value="1">Negro</option>
                    <option value="2">Blanco</option>
                </select>
            </div>
            <div id="personaje_id_error" class="display_error_class"></div>
            <div class="div-flex">
                <label>Monedas</label>
                <input type="number" id="monedas_usu-e" class="ingresadores">
            </div>
            <div id="coins_error" class="display_error_class"></div>
            <div class="div-flex">
                <label>Rango en el sistema</label>
                <select id="roles_id-e" class="ingresadores">
                    <option value="0">Usuario</option>
                    <option value="1">Administrador</option>
                </select>
            </div>
            <div id="roles_error"></div>
            <button class="btn-save" id="save_button" onclick="javascript:window.update_usu();">Actualizar</button>
        </div>
    </div>
    <div class="bodypageadm">
        <h1>Usuarios</h1>
        </h3>Filtre por roles</h3>
        <select id="usuariosadm_selector" value="">
            <option value="-1">Todos</option>
            <option value="0">Usuarios</option>
            <option value="1">Administradores</option>
        </select>
        <div id="global_error"></div>
        <h2 id="paginator_section"></h2>
        <table class="mt10" id="get_table_all">
        </table>
        <div class="pagcenter" id="paginator_list"></div>
    </div>
    </div>
</body>
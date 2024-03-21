<div class="search-place">
    <input class="busqueda" type="text" id="idbusqueda" placeholder="Buscar items">
    <div id="resultado_busqueda"></div>
    <button class="btn-main btn-search" onclick="search_objeto()"><i class="fa fa-search" aria-hidden="true"></i></button>
    <div class="options-place">
        <div class="dropdown">
            <i class="fa fa-cog dropbtn" onclick="usar()" aria-hidden="true"></i>
            <div id="opciones" class="dropdown-content">
                <?php if ($admin_rights === true) {
                    echo ('<a href="' . ($GLOBALS["index_root"]) . 'admin" class="adminnav">Administraci&oacute;n</a>');
                } ?>
                <a  class="historialnav" href="<?php echo ($GLOBALS["index_root"]); ?>compras">Historial de Compras/Ventas</a>
                <a  class="credenav" href="<?php echo ($GLOBALS["index_root"]); ?>change">Credenciales</a>
                <a href="<?php echo ($GLOBALS["index_root"]); ?>logout">Cerrar sesion</a>
            </div>
        </div>
    </div>
    <script>
        function usar() {
            document.getElementById("opciones").classList.toggle("show");
        }
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</div>
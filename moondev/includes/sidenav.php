
    <div class="body-nav-bar">
        <ul class="mt10">
            <li> <div class="div_eclipse"><p class="class_p">EclipseCoins: <?php echo($_SESSION["coins"]); ?><img class="div_moneda" src="img/moneda_oro_rojo_x4.png"></p></div></li>
            <?php if(($_GET['seccion'] == 'mercado') || ($_GET["seccion"] == "busqueda")){ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>mercado"><img src="img/mercado_ab.png" class="img-sidenav"></a></li>
            <?php }else{ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>mercado"><img src="img/mercado_cerrado.png" class="img-sidenav"></a></li>
            <?php } ?>
            <?php if($_GET['seccion'] == 'online'){ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>online"><img src="img/online_cerrado.png" class="img-sidenav"></a></li>
            <?php }else{ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>online"><img src="img/online_ab.png" class="img-sidenav"></a></li>
            <?php } ?>
            <?php if($_GET['seccion'] == 'misiones'){ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>misiones"><img src="img/misiones_cerrado.png" class="img-sidenav"></a></li>
            <?php }else{ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>misiones"><img src="img/misiones_ab.png" class="img-sidenav"></a></li>
            <?php } ?>
            <?php if($_GET['seccion'] == 'recompensa'){ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>recompensa"><img src="img/diario_open.png" class="img-sidenav"></a></li>
            <?php }else{ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>recompensa"><img src="img/diario.png" class="img-sidenav"></a></li>
            <?php } ?>
            <?php if($_GET['seccion'] == 'inventario'){ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>inventario"><img src="img/perfil_2.png" class="img-sidenav"></a></li>
            <?php }else{ ?>
                <li><a href="<?php echo ($GLOBALS["index_root"]) ?>inventario"><img src="img/perfil.png" class="img-sidenav"></a></li>
            <?php } ?>     
        </ul>
    </div> 

<div class="container">
    <nav class="navbar navbar-expand-xl nav-custom navbar-light fixed-top ">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="../controllers/homepage.php">
                    <img src="../Img/cattusmangalogo.png" width="105" height="65" class="d-inline-block align-top">
                </a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggleNavbar" aria-controls="toggleNavbar" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="toggleNavbar">
                <ul class="navbar-nav text-center">
                    <li class="nav-item active"><a class="nav-link" id="tabcategorias" style="color: #fff" href="../controllers/categorias.php">Categorías</a></li>
                    <li class="nav-item"> <a class="nav-link" id="tabtienda" style="color: #fff" href="../controllers/tienda.php?type=all&page=1">Tienda</a> </li>
                    <?php if (isset($newssesion)) {
                        session_start($newssesion);
                    };
                    if (isset($_SESSION['datos'])) { ?>
                        <li class="nav-item"> <a class="nav-link" id="tabinventario" style="color: #fff" href="../controllers/inventario.php?type=all">Tu inventario</a> </li>
                        <li class="nav-item"> <a class="nav-link" id="tabsubmanga" style="color: #fff" href="../controllers/subir_manga.php">Subir manga</a> </li>
                        <?php if ($_SESSION['datos']['role_id'] == 3 || $_SESSION['datos']['role_id'] == 4) { ?>
                            <li class="nav-item"> <a class="nav-link" id="tabmoderacion"  style="color: #fff" href="../controllers/moderacion.php?section=moderation"> Moderación</a> </li>
                    <?php }
                    } ?>
                    <li class="nav-item rounded-5 sub-button"> <a class="nav-link" id="tabsub"  style="color: #fff" href="../controllers/suscripciones.php">Suscripciones</a> </li>
                </ul>
              
                <div class="d-flex justify-content-end ms-auto p-1">
                    <form class="d-flex align-self-center" action="../controllers/get_all_mangas.php" method="GET">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary botonbusqueda_i" type="submit"><i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="menu-container" style="position:absolute;">
                            </div>
                            <input class="form-control barrabusqueda_bl" type="text" name="search" id="searchbar" placeholder="Buscar">
                        </div>
                    </form>
                     
                    <script src="../js/searchsuggestions.js"></script>
                    <?php
                    if (isset($_SESSION['datos'])) { ?>
                    
                        <ul class="nav nav-pills nav-justify-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="">
                                    <img src="<?php echo $_SESSION['datos']['profile_pic']; ?>" id="avatar" alt="Avatar" class="avatar"><?php echo ($_SESSION['datos']['Name']); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="../controllers/perfil.php?User=<?php echo ($_SESSION['datos']['ID']); ?>"><i class="bi bi-person-circle"></i>
                                            Perfil</a></li>

                                    <li><a class="dropdown-item" href="../controllers/likedmangas.php"><i class="bi bi-heart"></i>
                                            Marcadores</a></li>
                                    <li><a class="dropdown-item" href="../controllers/configuracion_perfil.php"><i class="bi bi-gear"></i>
                                            Configuración</a></li>
                                    <li><button id="changer" class="dropdown-item"><i class="bi bi-moon"></i> Cambiar tema
                                        </button></li>
                                    <li><a class="dropdown-item" href="../controllers/tienda?type=all&page=1"></i>Balance: <?php echo ($_SESSION['datos']['points']);  ?> <img src="../img/cattus_coin.png" width="20" height="20"></a></li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../controllers/logout.php"><i class="bi bi-box-arrow-left"></i>
                                            Cerrar sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } else { ?>
                        <ul class="nav nav-pills nav-justify-center ms-auto">
                            <div class="space">
                                <a type="button" href="../controllers/login.php" class="btn btn-light">
                                    Iniciar sesión</a>
                                <a type="button" href="../controllers/register.php" class="btn btn-primary ">
                                    Crear tu cuenta</a>
                            </div>
                        </ul>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
</div>
</nav>
<nav class="navbar navbar-default ">
</nav>
<nav class="navbar  navbar-default navbar-fixed-top ">
    <div class="container-fluid">
    </div>
</nav>
</div>
<script src="../js/buscador.js"></script>
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#changer').click(function() {
            var change = "true";
            $.post("../controllers/checklaymode.php", {
                change: change,
            }, function(data, status) {
                $("body").toggleClass("darkmode lightmode")
            });
        });
    });
</script>

<style>
    .botonbusqueda_i {
        background-color: #688CD8;
        border-radius: 30px 00px 0px 30px;
 
    }
    .barrabusqueda_bl {
        border-radius: 0px 30px 30px 0px;

    }

</style>

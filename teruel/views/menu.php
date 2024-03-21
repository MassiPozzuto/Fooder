<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Home cooking</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0">
                <li class="nav-item">
                    <?php if (isset($_SESSION['usuario'])) { ?>
                        <a class="nav-link" href="receta_alta.php">Crear Recetas</a>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['usuario'])) { ?>
                        <a class="nav-link" href="logout.php">(<?php echo $_SESSION['usuario']['nombre']; ?>) Logout</a>
                    <?php } else { ?>
                        <a class="nav-link" href="login.php">Login</a>
                    <?php } ?>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>
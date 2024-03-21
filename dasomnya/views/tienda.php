<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="homepage.php">Inicio</a></li>
  <li class="breadcrumb-item active" arial-current="page"><a href="#">Tienda</a></li>
</ol>
<div class="container mt-2">
  <div class="row">
    <div class="col-sm-2">
      <div class="🚫">
        <div class="d-flex flex-column px-3">
          <h3>Filtrar</h3>
          <ul class="nav nav-pills" id="menu">
            <a href="?type=all&page=1" class="nav-link"> Todo</a>
            <?php require_once("../controllers/itemfilter.php") ?>
            <li>
              <div class="btn-group">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Ordenar por:
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="tienda.php?type=<?php echo $_GET['type'] ?>&lowest=true&page=1">Menor precio</a>
                  <li><a class="dropdown-item" href="tienda.php?type=<?php echo $_GET['type'] ?>&highest=true&page=1">Mayor precio</a>
                </ul>
              </div>
        </div>
      </div>
    </div>
    <div class="col py-3">
      <h1 class="text-center">Tienda de puntos</h1>
      <hr />
      <p class="small text-center">Aquí podrás canjear tus puntos obtenidos a través de misiones diarias, puedes elegir entre personalización para tu perfil o canjear mangas</p>

      <?php
      if (isset($_SESSION['datos'])) { ?>
        <a class="">Balance: <?php echo ($_SESSION['datos']['points']); ?> <img src="../img/cattus_coin.png" width="20" height="20"></a>
      <?php } ?>


      <section class="pt-5 pb-5 shadow-sm">
        <?php if (isset($_GET['error'])) {
          if ($_GET['error'] == "true") {
            echo '<div class="alert alert-danger" role="alert">
              Algo salió mal.. Estamos trabajando para repararlo.
              </div>';
          }
          if ($_GET['error'] == "notenoughpoints") {
            echo '<div class="alert alert-danger" role="alert">
              Creditos insuficientes.
              </div>';
          }
          if ($_GET['error'] == "none") {
            echo '<div class="alert alert-success" role="alert">
               Objeto comprado exitosamente! Revisa tu inventario.
              </div>';
          }
        }

        ?>

        <div class="container">
          <div class="row pt-5">
            <div class="col-12">
            </div>
          </div>
          <div class="row row-cols-2 row-cols-md-3">
            <?php require_once("../controllers/itemshow.php") ?>
          </div>
        </div>

        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <?php if ($_GET['page'] == 1) { ?>
              <li class="page-item disabled">
                <a class="page-link">Anterior</a>
              </li>
            <?php } else {
              $previous = intval($_GET['page']) -  1; ?>
              <li class="page-item">
                <a class="page-link" href="tienda.php?type=<?php echo $_GET['type']; ?>&page=<?php echo $previous . $fplink; ?>">Anterior</a>
              </li>
            <?php }

            for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
              echo "<li class='page-item'><a id='p". $page_number."' class='page-link' href='tienda.php?type=" . $_GET['type'] . "&page=" . $page_number . $fplink . "'>" . $page_number . "</a></li>";
            } ?>

            <li class="page-item">
              <?php if ($_GET['page'] == $page_number - 1) { ?>
                <a class="page-link disabled">Siguiente</a>
              <?php } else {
                $next = intval($_GET['page']) + 1;
              ?>
                <a class="page-link"  href="tienda.php?type=<?php echo $_GET['type']; ?>&page=<?php echo $next . $fplink; ?>">Siguiente</a>
              <?php } ?>
            </li>
          </ul>
        </nav>


      </section>
    </div>
  </div>
</div>
</div>
<script>
 $(document).ready(function () {
    $('#tabtienda').addClass('underline');
    $('#p<?php echo $_GET['page']?>').addClass('disabled'); 
});
</script>
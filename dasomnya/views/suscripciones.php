<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="homepage.php">Inicio</a></li>
  <li class="breadcrumb-item active" arial-current="page"><a href="#">Suscripciones</a></li>
</ol>
<style>
  .negrito {
    color: black;
    opacity: 0.8;
  }

  .negritotitle {
    color: black;
    font-size: 25px;
    line-height: 40px;

  }

  .celestito {
    color: #549fe1;
    font-size: 36px;
    line-height: 50px;
  }
</style>


<div class="container d-flex justify-content-center">
  <div class="row row-cols-1 row-cols-md-2 ">
    <div class="col mb-3">
      <div class="shadow-sm card" style="width: 25rem;">
        <img class="card-img-top holacat" src="../img/Otros/gatonocorona.png" alt="Card image cap">
        <div class="card-body align-items-stretch">
          <h5 class="card-title text-center negritotitle">Cat</h5>
          <p class="lead text-center celestito">1.99USD/mes</p>

          <div class="container">
            <ul>
              <li class="negrito">Acceso a todos los capítulos</li>
              <li class="negrito">Ganancia de puntos multiplicada x1.5</li>
              <li class="negrito">Beneficio</li>
              <li class="negrito">Un agradecimiento</li>
            </ul>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-center ">
            <a href="../controllers/payment.php" class="btn btn-primary"><i class="bi bi-cart"></i>1 Mes</a>
            <a href="#" class="btn btn-primary"><i class="bi bi-cart"></i>6 Meses</a>
            <a href="#" class="btn btn-primary "><i class="bi bi-cart"></i>12 Meses</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col mb-3">
      <div class="shadow-sm card" style="width: 25rem;">
        <img class="card-img-top" src="../img/otros/gatocorona.png" alt="Card image cap">
        <div class="card-body align-items-stretch">
          <h5 class="card-title text-center negritotitle">Cattus</h5>
          <p class="lead  text-center celestito">4.99USD/mes</p>
          <div class="container">
            <ul>
              <li class="negrito">Mismos beneficios que Cat</li>
              <li class="negrito">Recomendar tu manga en el homepage</li>
              <li class="negrito">Ganancia de puntos multiplicada x2.5</li>
              <li class="negrito">Personalización de usuario exclusiva</li>
            </ul>
          </div>
          <div class="d-grid gap-2 d-md-flex justify-content-md-center">
            <a href="../controllers/payment.php" class="btn btn-primary"><i class="bi bi-cart"></i>1 Mes</a>
            <a href="#" class="btn btn-primary"><i class="bi bi-cart"></i>6 Meses</a>
            <a href="#" class="btn btn-primary "><i class="bi bi-cart"></i>12 Meses</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<hr class="invisible">

<style>
  .card:hover .card-img-top {
    opacity: 100%;
    filter: brightness(100%);
    transition: all 0.2s ease 0s;
  }
</style>

<script>
  $(document).ready(function() {
    $('.holacat').hover(function() {
      $(this).attr('src', '../img/otros/gatonocoronacmf.gif');
    }, function() {
      $(this).attr('src', '../img/otros/gatonocorona.png');
    });
  });
</script>
<script>
 $(document).ready(function () {
    $('#tabsub').addClass('underline');

});
</script>
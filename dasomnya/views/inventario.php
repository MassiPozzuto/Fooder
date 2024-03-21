<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="homepage.php">Inicio</a></li>
    <li class="breadcrumb-item active" arial-current="page"><a href="#">Inventario</a></li>
  </ol>
<style>
    .owo12{
      padding-right: 30%;
    }
  </style>
  
  
  <div class="container mt-2 mb-5">
  <div class="row">
     <div class="col-sm-2">
     <div class="🚫">
       <div class="d-flex flex-column px-3">
         <h3>Filtrar</h3>
         
           <ul class="nav nav-pills" id="menu">
            <a href="?type=all" class="nav-link owo12" >Todo</a>
            <?php require_once("../controllers/itemfilter.php")?>
           </ul>
        </div>
     </div>

     </div>
     <div class="col-sm-10 py-3">
      <h1 class="text-center">Inventario</h1>
      <hr/>
      <?php 
      require_once ("countitems.php");
        if(isset($_GET['error'])){
      if($_GET['error'] == "true"){
        echo '<div class="alert alert-danger" role="alert">
              Algo salió mal.. Estamos trabajando para repararlo.
              </div>';
      }
       if($_GET['error'] == "none"){
        echo '<div class="alert alert-success" role="alert">
               Foto de perfil modificada exitosamente!
              </div>';
      }
       if($_GET['error'] == "none1"){
        echo '<div class="alert alert-success" role="alert">
               Fondo modificado exitosamente!
              </div>';
      }
    }?>

         <div class="container">
            <div class="row pt-5">
              <div class="col-12">
    
            <div class="row row-cols-2 row-cols-md-3">
        <?php require_once("../controllers/showinventory.php") ?>
          </div>
      </section>
    </div>
  </div>
</div>
</div>
</div>
</div>
<hr class="invisible">
<script>
 $(document).ready(function () {
    $('#tabinventario').addClass('underline');

});
</script>
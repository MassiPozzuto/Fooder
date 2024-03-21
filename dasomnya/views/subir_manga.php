<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="homepage.php">Inicio</a></li>
  <li class="breadcrumb-item active" arial-current="page"><a href="#">Subir mangas</a></li>
</ol>

<h1>Sube tu manga</h1>
<hr>
<a class="nav-link" href="../controllers/como_subir_manga.php">
  <p style="color:#50AAFA" ;>¿cómo subir tu manga? ඞ
</a>
<form method="POST" action="../controllers/subir_manga.php" enctype="multipart/form-data">
  <div id="subirmanga">

    Ingresa el título del manga:
    <input type="text" id="title" name="title" class="form-control" placeholder="Título">

    Ingresa la sinopsis del manga:
    <textarea type="text" class="form-control" name="description" placeholder="Sinopsis"></textarea>

    Elije una categoría del manga:

    <select name="categories" class="form-select">
      <option selected>Selecciona una</option>
      <?php
      $countergenres = 1;
      foreach ($rowCategories as $categorias) { ?>
        <option value="<?php print_r($categorias[1]); ?>"><?php print_r($categorias[0]); ?></option>
      <?php $countergenres++;
      } ?>

    </select><br>

    Sube la caratula de tu manga!
    <input type="file" name="caratula" class="form-control" id="caratula" placeholder="Caratula">
    <br>
    Y por ultimo el primer capitulo:
    <input type="file" name="chapters[]" class="form-control" id="chapters" placeholder="Primer capitulo" multiple>
    <br>


    <div class="d-flex flex-row-reverse">

      <button type="submit" name="submit" id="enviar" class="btn btn-primary" text="Enviar">Enviar</button>
    </div>
  </div>
</form>



<hr class="invisible">
<hr class="invisible">
<hr class="invisible">
<script>
 $(document).ready(function () {
    $('#tabsubmanga').addClass('underline');

});
</script>
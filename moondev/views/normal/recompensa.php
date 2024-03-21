<link rel="stylesheet" type="text/css" href="<?php echo $fileinfo; ?>mercado.css">
<script src="<?php echo $fileinfo; ?>recompensa.js"></script>
<head>
  <title>Surmoon - Recompensa</title>
</head>
<header class="navbar-shop">
  <?php require_once("includes/nav.php"); ?>
</header>
<div class="title-section">Recompensa diaria</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="imgcofre">
  <img src="img/cofrecerrado.png" alt="Cargando..." id="imgcofre" style="height: 225px;"></img>
</div>
<button id="open_recompensa" class='abrir' onclick='javascript:abrir();' disabled="true">Abrir</button>
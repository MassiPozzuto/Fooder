<style>

 .card-contenido{
display: flex;
flex-direction: column;
align-items: left;
padding: 10px 14px;
 }

.slide-contenido{
  margin: 0 40px;
}

.imagen-contenido, 
.card-contenido {
  display: flex;
flex-direction: column;
align-items: center;
padding: 10px 14px;
}

  .card-img {
height: 100%;
width: 100%;
object-fit: cover;
border-radius: 100%;
border: 3px solid #549fe1;
}

.nombre{
font-size: 30px;
font-weight: 500;
color: #333;
}

.card-imagen {
position: center;
height: 150px;
width: 150px;
border-radius: 50%;
background: #FFF;
padding: 3px;
}

.imagen-contenido{
  position: relative;
  row-gap: 5px;
  
}

.slide-contenedor{
  max-width: 1120px;
  width: 100%;
}

.card{
  width: 320px;
  border-radius: 25px;
background-color: #FFF;
 }

.descripcion {
font-size: 13px;
color: #707070;
text-align: left;
margin-left: 2px;
margin-right: 2px;
}
 
.px {
  width: 250px; }

   
  
.moderation {
    background-color: #A0ACBD;
    min-width: 380px;
    max-width: 380px;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 8;
    -webkit-box-orient: vertical;
  }

.aver1 {
    max-width: 380px;
    max-height: 70px;
    overflow: hidden;
    overflow-y: auto;
  }

.titlem {
    color: white;
  }

.holaright {
   margin-left: 10px;
  }
</style>



<?php
if (isset($_GET['error'])) {
  if ($_GET['error'] == "emptyinput") {
    echo '<div class="alert alert-danger" role="alert">
              Debes completar todos los campos.
              </div>';
  }
  if ($_GET['error'] == "invaliduid") {
    echo '<div class="alert alert-danger" role="alert">
              El nombre de usuario no es valido. Asegurate de que contenga entre 4 a 12 caracteres.
              </div>';
  }
  if ($_GET['error'] == "invalidemail") {
    echo '<div class="alert alert-danger" role="alert">
              El Email ingresado no es valido.
              </div>';
  }
  if ($_GET['error'] == "passwordnotmatch") {
    echo '<div class="alert alert-danger" role="alert">
              Las contraseñas no coinciden.
              </div>';
  }
  if ($_GET['error'] == "uidtaken") {
    echo '<div class="alert alert-danger" role="alert">
              El nombre de usuario o Email ingresado ya esta en uso.
              </div>';
  }
  if ($_GET['error'] == "stmt_error") {
    echo '<div class="alert alert-danger" role="alert">
             Algo salió mal. Estamos trabajando para repararlo.
              </div>';
  }
  if ($_GET['error'] == "none") {
    echo '<div class="alert alert-success" role="alert">
               Usuario creado exitosamente!
              </div>';
  }
  if ($_GET['error'] == "none1") {
    echo '<div class="alert alert-success" role="alert">
               Usuario modificado exitosamente!
              </div>';
  }
  if ($_GET['error'] == "date") {
    echo '<div class="alert alert-danger" role="alert">
               Formato de fecha incorrecto.
              </div>';
  }
}
?>
<div class="container mt-2">
  <div class="row">
    <div class="col-sm-2">
      <div class="🚫">
        <div class="d-flex flex-column px-3">
          <h3>Filtrar</h3>
          <ul class="nav nav-pills" id="menu">
            <?php if ($_SESSION['datos']['role_id'] == 4) { ?>
              <a href="?section=administration&roles=todos&page=1" class="nav-link px-0 d-flex d-sm-inline holaright">Administración</a>
              <a href="?section=moderation" class="nav-link px-0 d-flex d-sm-inline holaright">Moderación</a>
            <?php   } ?>
          </ul>
        </div>
      </div>

    </div>
    <div class="col-sm-10 py-3">
      <?php
      if ($_GET['section'] == 'moderation') { ?>
        <h1 class="text-center">Moderación</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Moderación</li>
        </ol>
        
        <div class="containerTotals d-flex gap-4 row m-2 justify-content-center">
            <div class="TotalPageViews">
          <center><?php require_once("pagetotals.php"); echo($a2); ?></center> <p>Usuarios totales</p>
            </div>
            <div class="TotalPageViews">
            <center> <?php echo ($a3);?></center>       <p>Mangas totales</p>
            </div>
        </div>

        <ul class="list-group">
          <li class="list-group-item"> <a href="moderacion.php?section=moderationusers&page=1">Usuarios</a>
          </li>
          <li class="list-group-item"> <a href="moderacion.php?section=moderationcomments&page=1">Comentarios</a>
          </li>

        </ul>


      <?php }
      if ($_GET['section'] == 'moderationusers') { ?>
        <h1 class="text-center">Usuarios por moderar</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="moderacion.php?section=moderation">Moderación</a></li>
          <li class="breadcrumb-item active">Usuarios</li>

        </ol>

        <?php if ($numModerationUser == 0) { ?>
          <h3> No hay ningún usuario por moderar </h4>
            <?php } else { ?>
              
    <div class="container">
        <div class="row pt-5">
            <div class="col-12">
                <div class="row row-cols-1 row-cols-md-2">
            <?php foreach ($rowModerationUser as $valores) { ?>
               
              <div class="col-sm-5 mb-4 d-flex align-items-stretch">
                          <div class="card" style="width:400px">
                              <div class="imagen-contenido">
                              <div class="card-imagen">
                              <a href="perfil.php?User=<?php echo $valores['Affected_User_ID'] ?>"><center><img src="<?php echo $valores['profile_pic']; ?>" alt="" class="card-imagen  card-img"></a>
                              </div>
                              <div class="card-contenido">     
                              <div class="nombre"> <?php echo $valores['Name']; ?> <hr> </div>
                              <div class="descripcion">
                              <p> Email: <?php echo $valores['Email']; ?> </p>
                              <p> Reportado por el usuario: <?php echo $valores['User_ID']; ?></p>
                              <div class="px">
                              <p> Información del reporte: <?php echo $valores['information']; ?> </p>
                              </div>
                              </div>
                              <div class="d-flex justify-content-end">
                              <button class="eliminar btn btn-danger align-self-end" style="border:1px solid black"> <a href="moderation/delete_user.php?User=<?php echo $valores['Affected_User_ID']; ?>"> Eliminar </a></button>
                              <button class="suspender btn btn-warning align-self-end" style="border:1px solid black"> <a href="moderation/ban_reactivate_user.php?User=<?php echo $valores['Affected_User_ID']; ?>&type=ban">Suspender</a></button>
                              </div>
                          </div>      
                          </div>
                          </div>
                          </div>
                          <?php } ?> 
                  </div>
                  </div>
                  </div>
                  </div>
                </div>
                </div>
                </div>
                </div>
                  
                  <?php { ?>
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <?php if ($_GET['page'] == 1) { ?>
          <li class="page-item disabled">
            <a class="page-link">Anterior</a>
          </li>
        <?php } else {
                $previous = intval($_GET['page']) -  1; ?>
          <li class="page-item">
            <a class="page-link" href="moderacion.php?section=<?php echo $_GET['section']; ?>&page=<?php echo $previous; ?>">Anterior</a>
          </li>
        <?php }

              for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
                echo "<li class='page-item'><a class='page-link' href='moderacion.php?section=" . $_GET['section'] . "&page=" . $page_number . "'>" . $page_number . "</a></li>";
              } ?>

        <li class="page-item">
          <?php if ($_GET['page'] == $page_number - 1) { ?>
            <a class="page-link disabled">Siguiente</a>
          <?php } else {
                $next = intval($_GET['page']) + 1;
          ?>
            <a class="page-link" href="moderacion.php?section=<?php echo $_GET['section']; ?>&page=<?php echo $next; ?>">Siguiente</a>
          <?php } ?>
        </li>
      </ul>
    </nav>
    </div>
               
    <?php } ?>
   
</div>
<hr class="invisible">

<?php 
          }
        }

        if ($_GET['section'] == 'moderationcomments') { ?>
<center>
  <h1> Comentarios por moderar</h1>
</center>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="moderacion.php?section=moderation">Moderación</a></li>
  <li class="breadcrumb-item active">Comentarios</li>

</ol>
<?php if ($numModerationComment == 0) { ?>
  <h2> No hay ningún comentario por moderar </h2>
<?php } else { ?>


    <div class="container">
        <div class="row pt-5">
            <div class="col-12">
                <div class="row row-cols-1 row-cols-md-2">
                      <?php foreach ($rowModerationComment as $indice => $valores) { ?>
                        <div class="col-sm-5 mb-4 d-flex align-items-stretch">
                          <div class="card" style="width: 500px;">
                          <h4 class="nombre"><center> <?php echo $valores['Name']; ?> </h4></center>
                          <div class="m-2">
                          <a href="perfil.php?User=<?php echo $valores['af_user'] ?>"><center><img src="<?php echo $valores['profile_pic']; ?>" alt="" class="card-imagen  card-img"> </a>
                          <hr>
                          <div class="descripcion">
                          <p> Email: <?php echo $valores['Email']; ?> </p>
                          <p> Reportado por el usuario: <?php echo $valores['user_ID']; ?></p>
                          <p> Informacion del reporte: <?php echo $valores['information']; ?> </p>
                          
                          <p class="aver1"> Comentario: <?php echo htmlspecialchars($valores['content']); ?> </p>
                          </div>
                        </div>
                       <div class="d-flex justify-content-end">
                          <button class="eliminar btn btn-danger align-self-end" style="border:1px solid black"> <a href="moderation/delete_comment.php?id=<?php echo $valores['MC_ID']; ?>&com=<?php echo $valores['c_ID']; ?>"> Eliminar comentario </a></button>
                          <button class="suspender btn btn-warning align-self-end" style="border:1px solid black"> <a href="moderation/ignore_comment.php?id=<?php echo $valores['MC_ID']; ?>">Ignorar</a></button>
                          </div>
                          </div>      
                          </div>
                  <?php } ?> 
                  </div>
                  </div>
                  </div>
                  </div>
                </div>
              
                  
                  <?php { ?>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <?php if ($_GET['page'] == 1) { ?>
              <li class="page-item disabled">
                <a class="page-link">Anterior</a>
              </li>
            <?php } else {
                $previous = intval($_GET['page']) -  1; ?>
              <li class="page-item">
                <a class="page-link" href="moderacion.php?section=<?php echo $_GET['section']; ?>&page=<?php echo $previous; ?>">Anterior</a>
              </li>
            <?php }

              for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
                echo "<li class='page-item'><a class='page-link' href='moderacion.php?section=" . $_GET['section'] . "&page=" . $page_number . "'>" . $page_number . "</a></li>";
              } ?>

            <li class="page-item">
              <?php if ($_GET['page'] == $page_number - 1) { ?>
                <a class="page-link disabled">Siguiente</a>
              <?php } else {
                $next = intval($_GET['page']) + 1;
              ?>
                <a class="page-link" href="moderacion.php?section=<?php echo $_GET['section']; ?>&page=<?php echo $next; ?>">Siguiente</a>
              <?php } ?>
            </li>
          </ul>
        </nav>


    </div>
  </div>
  </div>
  <hr class="invisible">

<?php }
          }
        }

        if ($_GET['section'] == 'administration') { ?>
<center>
  <h1> Administración de usuarios</h1>
</center>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a>administracion</a></li>
  <li class="breadcrumb-item active">Usuarios</li>

</ol>
<div class="btn-group">
  <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    Filtrar por: <?php echo $_GET['roles'] ?>
  </button>
  <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="?section=administration&roles=todos&page=1">Todos</a>
    <li><a class="dropdown-item" href="?section=administration&roles=usuarios&page=1">Usuarios</a>
    <li><a class="dropdown-item" href="?section=administration&roles=moderadores&page=1">Moderadores</a>
    <li><a class="dropdown-item" href="?section=administration&roles=administradores&page=1">Administradores</a>
  </ul>
  <button type="button" class="btn btn-success" onclick="open_modal()">Insertar usuario</button>
</div>
<!-- Modal de insertar usuario -->
<div id="myModal" class="modal fade" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Insertar un nuevo usuario</h5>
      </div>
      <div class="modal-body">
        <form action="../controllers/moderation/insert_user.php?section=newuser" method="POST">
          <strong>Ingresa el E-mail</strong>
          <div class="">
            <input type="email" name="email" class="form-control emails rounded-4" placeholder="E-mail">
          </div><br>
          <div class="">
            <strong>Ingresa el nombre de usuario</strong>
            <input type="text" name="username" class="form-control rounded-4" placeholder="Nombre de Usuario"><br>
          </div>
          <div class="">
            <strong>Ingresa el rol</strong>
            <label class="form__container--text"></label>
            <select id="subres" name="role" class="form-control form__container--input">
              <option value="2">Usuario</option>
              <option value="3">Moderador</option>
              <option value="4">Administrador</option>
            </select><br>
          </div>
          <div class="">
            <strong>Ingresa la contraseña</strong>
            <input type="password" class="form-control lascontrasenias rounded-4" name="password" placeholder="Contraseña"><br>
          </div>
          <div class="">
            <strong>Repite la contraseña</strong>
            <input type="password" class="form-control lascontrasenias rounded-4" name="password2" placeholder="Repita la contraseña">
          </div><br>
          <div class="d-flex justify-content-end">
            <button class="btn btn-primary" type="submit" name="submit">Enviar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

    <div class="container">
        <div class="row pt-5">
            <div class="col-12">
                <div class="row row-cols-1 row-cols-md-3">
   
    <?php foreach ($rowAdministration as $usuarios) { ?>
      <div class="col-sm-5 mb-4 d-flex align-items-stretch">
        <div class="card" style="width: 500px;" style="height: 100px;">
          <?php if ($usuarios['role_id'] == 2 || $usuarios['ID'] == $_SESSION['datos']['ID'] || $usuarios['role_id'] == 3) { ?>
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $usuarios['ID']; ?>">
                <span class="badge text-bg-secondary"><i class="bi bi-pencil-square"></i>
                </span>
              </button>
            </div>
            <div class="modal fade" id="edit<?php echo $usuarios['ID']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar usuario: <?php echo $usuarios['ID']; ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="../controllers/moderation/edituser.php?userid=<?php echo $usuarios['ID'] ?>&page=<?php echo $_GET['page'] ?>" method="POST">
                      Nombre de usuario:
                      <input type="text" class="form-control" name="username" value="<?php echo $usuarios['Name'] ?>"></input>
                      Email:
                      <input type="email" class="form-control" name="email" value="<?php echo $usuarios['Email'] ?>"></input>
                      Puntos:
                      <input type="number" class="form-control" name="points" value="<?php echo $usuarios['points'] ?>"></input>
                      Contraseña:
                      <input type="text" class="form-control" name="password" placeholder="Nueva contraseña"></input>
                      Rol
                      <select class="form-select" name="role">
                        <option selected value=<?php echo $usuarios['role_id']; ?>><?php echo $usuarios['name']; ?></option>
                        <?php if ($usuarios['role_id'] == 2) { ?>
                          <option value="1">Invitado</option>
                          <option value="3">Moderador</option>
                          <option value="4">Administrador</option>
                        <?php } else if ($usuarios['role_id'] == 3) { ?>
                          <option value="1">Invitado</option>
                          <option value="2">Usuario</option>
                          <option value="4">Administrador</option>
                        <?php } else if ($usuarios['role_id'] == 4) { ?>
                          <option value="1">Invitado</option>
                          <option value="2">Usuario</option>
                          <option value="3">Moderador</option>
                        <?php } ?>
                      </select>
                      Fecha de desactivación:
                      <input type="datetime" class="form-control" name="datedes" value="<?php echo $usuarios['desactivation_date'] ?>" placeholder="aaaa-mm-dd hh:mm:ss"></input>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" name="submit" class="btn btn-primary">Guardar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
          
          <div class="imagen-contenido">
               <div class="card-imagen">           
                 <a href="perfil.php?User=<?php echo $usuarios['ID'] ?>"><img src="<?php echo $usuarios['profile_pic']; ?>" alt="" class="card-imagen  card-img"> </a>
               </div>
               <div class="card-contenido"> 
          <h4 class="nombre"> <?php echo $usuarios['Name']; ?> <hr> </h4>
         <div class="px"> 
          <div class="descripcion">
          
            <p> Email: <?php echo $usuarios['Email']; ?> </p>
            <p> Rol: <?php echo $usuarios['name']; ?></p>
            <p> Número de reportes: <?php //Aca iria un select count de los reportes;
                                    ?> </p>
            <?php if (($usuarios['desactivation_date'] == NULL && $usuarios['reactivation_at'] == NULL) || ($usuarios['desactivation_date'] == NULL && $usuarios['reactivation_at'] < date('Y-m-d'))) { ?>
              <p> Estado: Activo </p>
            <?php } else if ($usuarios['desactivation_date'] != NULL) { ?>
              <p> Estado: Baneado permanentemente </p>
            <?php } else if ($usuarios['reactivation_at'] != NULL) { ?>
              <p> Estado: Baneado temporalmente </p>
            <?php } ?>
          </div></div>
               

          <div class="d-flex justify-content-end">
            <?php if ($_SESSION['datos']['ID'] != $usuarios['ID']) { ?>
              <?php if (($usuarios['role_id'] == 2) && ($usuarios['desactivation_date'] == NULL)) { ?>
                <button class="eliminar btn btn-warning"> <a href="moderation/give_remove_moderator.php?User=<?php echo $usuarios['ID']; ?>"> Dar moderador </a></button>
                <button class="eliminar btn btn-danger"> <a href="moderation/delete_user.php?User=<?php echo $usuarios['ID']; ?>"> Eliminar </a></button>
              <?php }
              if (($usuarios['desactivation_date'] != NULL) || ($usuarios['reactivation_at'] != NULL && $usuarios['reactivation_at'] > date('Y-m-d'))) { ?>
                <button class="eliminar btn btn-success"> <a href="moderation/ban_reactivate_user.php?User=<?php echo $usuarios['ID']; ?>&type=reactivate"> Reactivar usuario </a></button>
              <?php   } else if ($usuarios['role_id'] == 3) { ?>
                <button class="eliminar btn btn-warning"> <a href="moderation/give_remove_moderator.php?User=<?php echo $usuarios['ID']; ?>"> Quitar moderador </a></button>
                <button class="eliminar btn btn-danger"> <a href="moderation/delete_user.php?User=<?php echo $usuarios['ID']; ?>"> Eliminar </a></button>
            <?php }
            } ?>
          </div>
        </div>
      </div>  </div></div>

    <?php   } ?>
    <!-- Paginador -->
  </div>
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
        <a class="page-link" href="moderacion.php?section=<?php echo $_GET['section']; ?>&roles=<?php echo $_GET['roles']; ?>&page=<?php echo $previous; ?>">Anterior</a>
      </li>
    <?php }

          for ($page_number = 1; $page_number <= $total_pages; $page_number++) {
            echo "<li class='page-item'><a id='p". $page_number."' class='page-link' href='moderacion.php?section=" . $_GET['section'] . "&roles=" . $_GET['roles'] . "&page=" . $page_number . "'>" . $page_number . "</a></li>";
          } ?>

    <li class="page-item">
      <?php if ($_GET['page'] == $page_number - 1) { ?>
        <a class="page-link disabled">Siguiente</a>
      <?php } else {
            $next = intval($_GET['page']) + 1;
      ?>
        <a class="page-link" href="moderacion.php?section=<?php echo $_GET['section']; ?>&roles=<?php echo $_GET['roles']; ?>&page=<?php echo $next; ?>">Siguiente</a>
      <?php } ?>
    </li>
  </ul>
</nav>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
<script>
 $(document).ready(function () {
    $('#tabmoderacion').addClass('underline');
    $('#p<?php echo $_GET['page']?>').addClass('disabled'); 

});
</script>
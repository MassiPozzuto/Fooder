<?php 	
require_once "../server/config.php";
if(isset($_SESSION['datos'])){


$sql = "SELECT * FROM users WHERE ID = " .$_SESSION['datos']['ID'].";";

$result = mysqli_query($conn, $sql);

$user = array();
if (mysqli_num_rows($result) > 0) {
    while ($row1 = mysqli_fetch_assoc($result)) {
        $user[] = $row1;
    }

 if ($user[0]['desactivation_date'] !== NULL || $user[0]['reactivation_at'] !==NULL && $user[0]['reactivation_at'] < date('Y-m-d')){
 	echo '<script>
    $(document).ready(function(){
        $("#myModal").modal("show");
    });
</script>
<div id="myModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Este usuario ha sido penalizado</h5>    
            </div>
            <div class="modal-body">
                <p>Has sido suspendido indefinidamente de la plataforma Cattus Manga porque creemos que violaste los terminos de uso. Esto no te impedirá usar la plataforma, unicamente has sido restrigido de: </p>
               <ul> 
               <li>Iniciar sesion</li>
               <li>Comentar</li>
               <li>Comprar suscripciones</li>
               <li>Subir mangas</li>
               <li>Guardar mangas</li>
               </ul>
               <p>Si crees que nos equivocamos envianos un mensaje a este E-mail para revisar tu caso:</p>
               <p class="text-center fw-semibold">cattusmanga@gmail.com</p>
               <div class="d-flex justify-content-end">
               <a href="logout.php" type=button class="btn btn-primary"><i class="bi bi-power"></i> Cerrar sesion</a>
               </div>
              
            </div>
        </div>
    </div>
</div>';
 }
}
}
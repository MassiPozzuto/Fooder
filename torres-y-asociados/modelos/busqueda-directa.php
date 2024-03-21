<?php
require_once '../includes/config.php';
 
$html = '';
$key = $_POST['key'];
$query = 'SELECT * FROM categorias WHERE categorias.nombre LIKE "'.$key.'%" AND fecha_baja IS null ORDER BY fecha_alta DESC LIMIT 0,10';
$result = mysqli_query($conn, $query);
if(!$result){
    die("error de consulta: ".mysqli_error($conn));
}
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= '<div><a class="resultado_elemento" href="'.RUTA .'/resultados-busqueda.php?busqueda='.$row['nombre'].'"><i class="fa-solid fa-magnifying-glass"></i>'.$row['nombre'].'</a></div>';
    }
}else if(mysqli_num_rows($result) == 0){
    $html = "No se encontro ninguna categoria.";
}
echo $html;
?>
<?php
    require_once "usuario-actual.php";
    include "../includes/config.php";

    //almaceno en una variable el directorio donde se guardara la imagen
    $dir_subida = "../img/users/" . $user['id'] . "/publicaciones" . "/";
    $dir_meme_db = "img/users/" . $user['id'] . "/publicaciones" . "/";

    //se crea el directorio con @mkdir si no existe
    @mkdir($dir_subida);

    if(!file_exists($dir_subida)){
        @mkdir($dir_subida, 0777, true);
    }

    //guardo el nombre de la imagen
    $imagenNombre = $_FILES['meme']['name'];
    //guardo la ruta de la imagen
    $imagenRuta = $dir_subida . $imagenNombre;
    $memeRuta = $dir_meme_db . $imagenNombre;
    //variable para validar si se subio al directorio
    $imagenValida = false;

    //valido la subida de la imagen al directorio
    if (move_uploaded_file($_FILES['meme']['tmp_name'], $imagenRuta)) {
        $imagenValida = true;
    }

    // Si la imagen se movio correctamente, insertar los datos a la db
    if($imagenValida){
        // Consulta para insertar en la db la info necesaria de la publicacion y el autor
        $queryPubli = "INSERT INTO publicaciones VALUES (null, '" . $user['id'] . "', '$memeRuta', 'off', NOW(), null)";
        // Hace la consulta, en caso de no lograrse tira error
        if(mysqli_query($conn, $queryPubli)){
            /* --Renombra el nombre del archivo (meme) y hace el update en la db de la nueva ruta-- */
            // Consulta para saber la cantidad total de publicaciones del usuario
            $queryRename = "SELECT COUNT(usuario_id) AS 'cantPubli' FROM publicaciones WHERE usuario_id = '".$user['id']."'";
            // Se almacena aca el total
            $totalAlmacenado = mysqli_query($conn, $queryRename);
            if(!$totalAlmacenado){
                die(mysqli_error($conn));
            }
            $resultRename = mysqli_fetch_assoc($totalAlmacenado);
            
            // Consulta para saber el id de la publicacion (Importante - Se usa en varias ocaciones)
            $resultIdMeme = mysqli_query($conn, "SELECT id FROM publicaciones WHERE rutaImagen = '".$memeRuta."'");
            if(!$resultIdMeme){
                die(mysqli_error($conn));
            }
            // Aca se almacena el id
            $publi_id = mysqli_fetch_assoc($resultIdMeme);

            // Consulta para saber el nombre del archivo (Usado principalmente para saber la extension del archivo)
            $queryNombreArchivo = "SELECT rutaImagen FROM publicaciones WHERE id = '".$publi_id['id']."'";
            // Aca se almacena el nombre
            $nombreAlmacenado = mysqli_query($conn, $queryNombreArchivo);
            if(!$nombreAlmacenado){
                die(mysqli_error($conn));
            }
            $resultNombreArchivo = mysqli_fetch_assoc($nombreAlmacenado);
            
            // El string (nombre del archivo) se convierte en una array, separado por los puntos
            $nomArchivo = explode(".", $resultNombreArchivo['rutaImagen']);
            // Se almacena la cantidad maxima del array y se le resta 1, para usar como la posicion de la extension
            $posArray = count($nomArchivo) - 1;

            // Se almacena la extension completa del archivo
            $extensionArchivo = $nomArchivo[$posArray];
            // Se extablece el nuevo nombre del archivo: publicacion-n + cantidad de publicaciones del usuarios + extension
            $nuevoNombre = "publicacion-n" . $resultRename['cantPubli'] . "." . $extensionArchivo;
            // Se establece la ruta con el nuevo nombre del archivo para la parte de views de la pagina
            $nuevoDirSubida = $dir_subida . $nuevoNombre;
            // Se establece la ruta con el nuevo nombre del archivo para la base de datos
            $nuevoDirSubidaDb = $dir_meme_db . $nuevoNombre;
            // Se hace el cambio de nombre con la funcion rename()
            // Parametros: ruta completa del archivo, nueva ruta completa del archivo (esto tambien cambia el nombre)
            rename($imagenRuta, $nuevoDirSubida);
            // Se hace el update a la db con la nueva ruta
            if(!mysqli_query($conn, "UPDATE publicaciones SET rutaImagen = '$nuevoDirSubidaDb' WHERE publicaciones.id = '".$publi_id['id']."'")){
                die(mysqli_error($conn));
            }

            // Divido categorias del input-text en un array
            $categorias = $_POST['categorias'];
            $categorias_separadas = explode("-", $categorias);
            //variable para validar si existe una categoria
            $existCateg = false;

            /* --Funcion que crea categorias y las enlaza con la publicacion-- */
            // Los parametros se explican cuando se hace llamdo a la funcion
            function verifyAndCreateCategs($conexion, $array, $allUserCategs, $publicacionId){
                for($i = 0; $i < $array; $i++){
                    //Consulta de todas las categorias que hay actualmente
                    $queryAllCategs = mysqli_query($conexion, "SELECT nombre FROM categorias");
                    if(!$queryAllCategs){
                        die(mysqli_error($conexion));
                    }

                    $categsBd = mysqli_fetch_all($queryAllCategs, MYSQLI_ASSOC);

                    //Verifica si la categoria ya existe
                    foreach($categsBd as $categBd){
                        //Valida si la categoria actual es igual a alguna de las que hay en la db
                        if($allUserCategs[$i] == $categBd['nombre']){
                            //En el caso de que haya coincidencia, cambia a "true" a la variable
                            $existCateg = true;
                        }
                    }
                    
                    // En el caso de que $existCateg sea verdad ignora esto ya que la categoria ya existe
                    // Pero si es falso, entra y crea la categoria ya que no existe
                    if($existCateg == false){
                        //Consulta para insertar la categoria a la tabla "categorias"
                        $queryCateg = "INSERT INTO categorias VALUES (null, '" . $allUserCategs[$i] . "', NOW(), null) ";
                        // Hace la consulta, en caso de no lograrse tira error
                        if(!mysqli_query($conexion, $queryCateg)){
                            die('Error de Consulta' . mysqli_error($conexion));
                        }
                    }
                    
                    /* --Enlazar publicacion con la categoria-- */

                    // Consulta para obtener el id de la categoria actual
                    $querySelectCateg = "SELECT id AS 'idCateg' FROM categorias WHERE nombre = '" . $allUserCategs[$i] . "'";
                    // Guarda el id en la variable $resultSelectCateg
                    $idGuardada = mysqli_query($conexion, $querySelectCateg);
                    if(!$idGuardada){
                        die('Error de Consulta' . mysqli_error($conexion));
                    }
                    $resultSelectCateg = mysqli_fetch_assoc($idGuardada);
                    // Cosulta para insertar el id de la publicacion y el id de la categoria actual
                    $queryPubliCateg = "INSERT INTO publicaciones_categorias VALUES (null, '". $publicacionId ."', '". $resultSelectCateg['idCateg'] ."')";
                    // Hace la consulta, en caso de no lograrse tira error
                    if(!mysqli_query($conexion, $queryPubliCateg)){
                        die('Error de Consulta' . mysqli_error($conexion));
                    }
                }
            }


            /* --Verificador de cuantas categorias puso-- */

            // Mas de 10 - Descarta las que se pasen de las 10
            if(count($categorias_separadas) >= 11){
                $maxArray = 10;
                //Llamado a la funcion anterior
                //Parametros: conexion, hasta donde llegara el array, todas las categs que puso el usuario, id de la publicacion
                verifyAndCreateCategs($conn, $maxArray, $categorias_separadas, $publi_id['id']);
            }
            // Menos de 10 - Usa la cantidad de categorias que el usuario ingreso
            else if(count($categorias_separadas) < 11){
                $maxArray = count($categorias_separadas);
                //Llamado a la funcion anterior
                //Parametros: conexion, hasta donde llegara el array, todas las categs que puso el usuario, id de la publicacion
                verifyAndCreateCategs($conn, $maxArray, $categorias_separadas, $publi_id['id']);
            }

            
        }else{
            die('Error de Consulta' . mysqli_error($conn));
        }
    }

    // Se cual sea el caso, redirige a la Feed Principal
    header('Location: ../feed-principal.php');
?>